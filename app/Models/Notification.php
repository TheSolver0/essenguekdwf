<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // Si ta table s'appelle 'notification' au singulier
    protected $table = 'notification';

    // Colonnes que tu peux remplir
    protected $fillable = [
        'user_id',
        'title',     // par ex
        'message',   // par ex
        'created_at',
        'updated_at'
    ];

    // Si tu utilises les timestamps automatiques
    public $timestamps = true;

    // Relation vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
