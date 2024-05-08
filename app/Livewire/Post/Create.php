<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media=[];
    public $description;
    public $location;

    public $hide_like_view;

    public $allow_commenting;

    function submit()
    {

        dd([
            $this->media,
            $this->description,
            $this->location,
            $this->hide_like_view,
            $this->allow_commenting
        ]);
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function render()
    {
        return view('livewire.post.create');
    }
}