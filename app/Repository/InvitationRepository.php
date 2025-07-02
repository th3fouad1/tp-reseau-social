<?php

namespace App\Repository;

use App\Models\Invitation;

class InvitationRepository implements IInvitationRepository
{
    public function getAll()
{
    return Invitation::with(['sender', 'receiver'])->get();
}


    public function findById($id)
    {
        return Invitation::findOrFail($id);
    }

    public function create(array $data)
    {
        unset($data['_token']); // Remove the _token field
        return Invitation::create($data);
    }


    public function update($id, array $data)
    {
        $invitation = Invitation::findOrFail($id);
        $invitation->update($data);
        return $invitation;
    }

    public function delete($id)
    {
        return Invitation::destroy($id);
    }

    public function exists($userA, $userB)
{
    return Invitation::where(function ($query) use ($userA, $userB) {
        $query->where('sender_id', $userA)
              ->where('receiver_id', $userB);
    })->orWhere(function ($query) use ($userA, $userB) {
        $query->where('sender_id', $userB)
              ->where('receiver_id', $userA);
    })->exists();
}

}
