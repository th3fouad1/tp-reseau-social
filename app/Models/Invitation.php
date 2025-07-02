<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'accepted',
    ];

    // Relations (facultatif mais recommandé)
    public function sender()
{
    return $this->belongsTo(Utilisateur::class, 'sender_id');
}

public function receiver()
{
    return $this->belongsTo(Utilisateur::class, 'receiver_id');
}
}
