<?php

namespace App\Livewire\Post\View;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Item extends Component
{
    public Post $post;

    public function render()
    {
        $comments = $this->post->comments;
        return view('livewire.post.view.item',['comments'=>$comments]);
    }
}
