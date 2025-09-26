<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PostCard extends Component
{
    public $post;
    public $delay;

    public function __construct($post = null, $delay = 0)
    {
        $this->post = $post;
        $this->delay = $delay;
    }

    public function render(): View
    {
        return view('components.post-card');
    }
}
