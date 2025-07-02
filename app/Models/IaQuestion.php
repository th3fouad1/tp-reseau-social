<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class IaQuestion extends Model
{
    protected $fillable = ['prompt', 'answer', 'user_id'];

    public function user()
    {
        return $this->belongsTo(Utilisateur::class, 'user_id');
    }
}