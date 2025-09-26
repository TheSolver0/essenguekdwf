<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $table = 'newsletter_subscribers';

    protected $fillable = [
        'email',
        'subscribed',
    ];

    protected $casts = [
        'subscribed' => 'boolean',
    ];

    public function scopeSubscribed($query)
    {
        return $query->where('subscribed', true);
    }

    public function subscribe()
    {
        $this->subscribed = true;
        $this->save();
    }

    public function unsubscribe()
    {
        $this->subscribed = false;
        $this->save();
    }
}
