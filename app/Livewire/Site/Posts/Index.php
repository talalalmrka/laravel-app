<?php

namespace App\Livewire\Site\Posts;

use App\Models\Post;
use Livewire\Component;
class Index extends Component
{
    public function render()
    {
        return view('livewire.site.posts.index', [
            'posts' => Post::paginate(),
        ])->layout('layouts.default', [
            'title' => __('Blog'),
        ]);
    }
}
