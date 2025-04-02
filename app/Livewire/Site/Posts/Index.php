<?php

namespace App\Livewire\Site\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.site.posts.index', [
            'posts' => Post::where('type', 'post')->paginate(),
        ])->layout('layouts.default', [
            'title' => __('Blog'),
        ]);
    }
}
