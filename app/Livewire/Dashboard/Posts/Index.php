<?php

namespace App\Livewire\Dashboard\Posts;

use App\Livewire\Components\Datatable\Datatable;
use App\Livewire\Components\Datatable\Columns\Column;
use App\Models\Post;

class Index extends Datatable
{
    public function builder()
    {
        return Post::post();
    }

    public function getColumns()
    {
        return [

            Column::make('user_id')
                ->label(__('Author'))
                ->sortable()
                ->content(function (Post $post) {
                    return thumbnail([
                        'title' => $post->user?->display_name,
                        'image' => $post->user?->getFirstMediaUrl('avatar'),
                    ]);
                }),
            Column::make('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable(),
            Column::make('slug')
                ->label(__('Slug'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center'),
            Column::make('status')
                ->label(__('Status'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center')
                ->content(function (Post $post) {
                    return badge(['label' => $post->status]);
                }),
        ];
    }
    public function create()
    {
        $this->redirect(route('dashboard.posts.create'), true);
    }
    public function show(Post $post)
    {
        $this->redirect($post->permalink, true);
    }
    public function edit(Post $post)
    {
        $this->redirect(route('dashboard.posts.edit', $post), true);
    }
    public function delete(Post $post)
    {
        $post->delete();
        session()->flush('status', __('Post deleted'));
        $this->redirect(route('dashboard.posts'), true);
    }
    public function render()
    {
        return view('livewire.dashboard.posts.index', [
            //'posts' => Post::where('type', 'post')->paginate(),
        ])->layout('layouts.dashboard', [
            'title' => __('Posts'),
        ]);
    }
}
