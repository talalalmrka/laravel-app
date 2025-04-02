<?php

namespace App\Livewire\Dashboard\Posts;

use App\Models\Post;
use Livewire\Component;

class Index extends Component
{
    public $selected = [];
    public function edit(Post $post)
    {
        $this->redirect(route('dashboard.posts.edit', $post), true);
    }
    public function delete(Post $post)
    {
        $delete = $post->delete();
        if ($delete) {
            session()->flash('status', __('Delete success.'));
        } else {
            $this->addError('status', __('Delete failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.posts.index', [
            'posts' => Post::where('type', 'post')->paginate(),
        ])->layout('layouts.dashboard', [
            'title' => __('Posts'),
        ]);
    }
}
