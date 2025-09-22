<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'prenom',
        'nom',
        'adresse',
        'ville',
        'region',
        'zip',
        'email',
        'telephone',
        'message',
        'lu',
    ];
}
