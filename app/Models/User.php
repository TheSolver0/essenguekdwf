<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use App\Models\Notification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'photo',
        'badge',
        'total_dons',
        'total_likes',
        'total_commentaires',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🚀 Génération auto du username
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->username)) {
                $baseUsername = Str::slug($user->name);

                // Vérifier si déjà existant
                $count = static::where('username', 'like', $baseUsername.'%')->count();

                $user->username = $count ? $baseUsername.'-'.($count+1) : $baseUsername;
            }
        });
    }

    // -----------------------
    // Relations
    // -----------------------

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // -----------------------
    // Gamification
    // -----------------------

    /**
     * Met à jour le badge de l'utilisateur en fonction des critères
     */
    public function updateBadge()
    {
        $badge = 'Aucun';

        // Condition : engagement
        if ($this->total_likes >= 0 || $this->total_commentaires >= 0) {
            $badge = 'Membre';
        }

        // Nouveau donateur : moins de 10$
        if ($this->total_dons < 10 && $this->total_dons > 0) {
            $badge = 'Nouveau Donateur';
        }

        // Bienfaiteur : 500$ ou plus
        if ($this->total_dons >= 500) {
            $badge = 'Bienfaiteur';
        }

        // Ambassadeur KDWF : 1000$ + engagement
        if ($this->total_dons >= 1000 && $this->total_likes > 0 && $this->total_commentaires > 0) {
            $badge = 'Ambassadeur KDWF';
        }

        $this->badge = $badge;
        $this->save();
    }

    public function campagnes()
    {
        return $this->hasMany(Campagne::class);
    }

    public function dons()
    {
        return $this->hasMany(Don::class);
    }

    //public function notifications()
    //{
    //    return $this->hasMany(Notification::class);
    //}

    public function userNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Retourne l'URL de la photo de profil
     */
    public function getProfilePhotoUrlAttribute()
    {
        // Si l'utilisateur a une photo définie
        if ($this->photo) {
            return asset('storage/' . $this->photo); // ou selon ton dossier de stockage
        }

        // Sinon, une image par défaut
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
    }
}
