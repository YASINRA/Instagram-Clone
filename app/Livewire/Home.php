<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Home extends Component
{
    public $posts;

    function mount() {
        $this->posts= Post::latest()->get();
       // dd( $this->posts);
    }

    public function render()
    {
        return view('livewire.home');
    }
}
