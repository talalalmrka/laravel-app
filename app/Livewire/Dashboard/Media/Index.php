<?php

namespace App\Livewire\Dashboard\Media;

use App\Livewire\Components\Datatable\Datatable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Index extends Datatable
{

    public $id_column = true;
    public function builder()
    {
        return Media::query();
    }

    public function getColumns()
    {
        return [
            column('preview')
                ->label(__('Preview'))
                ->content(function (Media $media) {
                    return view('livewire.dashboard.media.preview', ['media' => $media]);
                }),
            column('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('type')
                ->label(__('Type'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('size')
                ->label(__('Size'))
                ->sortable()
                ->content(function (Media $media) {
                    return $media->humanReadableSize;
                }),
            column('model_type')
                ->label(__('Owner type'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('model_id')
                ->label(__('Owner id'))
                ->sortable()
                ->searchable()
                ->filterable(),

        ];
    }
    public function render()
    {
        return view('livewire.dashboard.media.index')->layout('layouts.dashboard', [
            'title' => __('Media library'),
        ]);
    }
}
