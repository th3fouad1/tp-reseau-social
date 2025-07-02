<?php

namespace App\Repository;

use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UtilisateurRepository implements IUtilisateurRepository
{
    public function getAll()
    {
        return Utilisateur::all();
    }

    public function findById($id)
    {
        return Utilisateur::findOrFail($id);
    }

    public function create(array $data)
    {
        Log::info('Création utilisateur', ['data' => $data]);
        $data['password'] = bcrypt($data['password']);
        return Utilisateur::create($data);
    }

    public function update($id, array $data)
    {
        $user = Utilisateur::findOrFail($id);
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        Utilisateur::destroy($id);
    }

    
}