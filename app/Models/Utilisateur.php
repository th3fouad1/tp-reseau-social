<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';

    protected $fillable = ['nom', 'login', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function setPasswordAttribute($value)
    {
        // Only hash if the value is not already hashed
        if ($value && !Hash::needsRehash($value)) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function sentInvitations()
    {
        return $this->hasMany(Invitation::class, 'sender_id');
    }

    public function receivedInvitations()
    {
        return $this->hasMany(Invitation::class, 'receiver_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'sender_id');
    }
}