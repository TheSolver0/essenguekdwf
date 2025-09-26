<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model {
    use HasFactory;

    protected $table = 'medias';

    protected $fillable = [
        'nom','category','media_url','implantation',
        'date_publication','date_expiration','archived','notes'
    ];

    protected $casts = [
        'date_publication' => 'date',
        'date_expiration'  => 'date',
        'archived' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($m) {
            if (!$m->date_publication) {
                $m->date_publication = now();
            }
            if (!$m->date_expiration) {
                $m->date_expiration = now()->addDays(80);
            }
        });
    }

    // scope pour récupérer uniquement les actifs visibles
    public function scopeActive($query) {
        return $query->where('archived', false)
                     ->where(function($q){
                         $q->whereNull('date_expiration')
                           ->orWhere('date_expiration', '>=', now());
                     });
    }
}
