<?php
namespace App\Http\Controllers;
use App\Models\Utilisateur;
use App\Repository\UtilisateurRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    protected $utilisateurRepository;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(\App\Http\Requests\Auth\LoginRequest $request)
    {
        if (Auth::attempt($request->only('login', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/ia');
        }
        return back()->withErrors([
            'login' => 'These credentials do not match our records.',
        ])->withInput($request->only('login'));
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'login' => 'required|string|email|unique:utilisateurs,login',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $this->utilisateurRepository->create([
            'nom' => $request->nom,
            'login' => $request->login,
            'password' => $request->password,
        ]);

        Auth::attempt(['login' => $request->login, 'password' => $request->password]);
        return redirect('/ia');
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    public function profile()
    {
        $utilisateur = Auth::user();
        return view('utilisateurs.profile', compact('utilisateur'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nom' => 'required|string|max:255',
            'login' => 'required|string|email|unique:utilisateurs,login,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'nom' => $request->nom,
            'login' => $request->login,
        ];
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $this->utilisateurRepository->update($user->id, $data);

        return redirect()->route('utilisateurs.profile')->with('success', 'Profil mis à jour !');
    }

    public function destroyProfile()
    {
        $user = Auth::user();
        $this->utilisateurRepository->delete($user->id);
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Compte supprimé.');
    }
}