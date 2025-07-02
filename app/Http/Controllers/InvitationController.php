<?php
namespace App\Http\Controllers;
use App\Models\Invitation;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $friends = Utilisateur::whereIn('id', function ($query) use ($userId) {
            $query->select('sender_id')->from('invitations')
                ->where('receiver_id', $userId)->where('accepted', 1)
                ->union(
                    Invitation::select('receiver_id')->where('sender_id', $userId)->where('accepted', 1)
                );
        })->get();

        $receivedInvitations = Invitation::where('receiver_id', $userId)->where('accepted', 0)->with('sender')->get();

        return view('invitations.index', compact('friends', 'receivedInvitations'));
    }

    public function create()
    {
        $userId = Auth::id();
        $friendsAndPending = Invitation::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)->orWhere('receiver_id', $userId);
        })->pluck('sender_id', 'receiver_id')->flatten()->unique()->toArray();

        $nonFriends = Utilisateur::where('id', '!=', $userId)
            ->whereNotIn('id', $friendsAndPending)->get();

        return view('invitations.create', compact('nonFriends'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:utilisateurs,id',
        ]);

        Invitation::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'accepted' => 0,
        ]);

        return redirect()->route('invitations.index')->with('success', 'Invitation envoyée !');
    }

    public function accept($id)
    {
        $invitation = Invitation::where('id', $id)->where('receiver_id', Auth::id())->firstOrFail();
        $invitation->accepted = 1;
        $invitation->save();

        return redirect()->route('invitations.index')->with('success', 'Invitation acceptée !');
    }

    public function reject($id)
    {
        $invitation = Invitation::where('id', $id)->where('receiver_id', Auth::id())->firstOrFail();
        $invitation->delete();

        return redirect()->route('invitations.index')->with('success', 'Invitation rejetée.');
    }
}