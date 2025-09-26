<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    // 🔹 Lien vers le post associé
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // 🔹 Lien vers l'utilisateur qui a fait le commentaire
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
