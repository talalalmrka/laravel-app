<div>
    <x-slot name="actions">
        <a wire:navigate href="{{ route('dashboard.posts') }}" class="btn xs btn-outline-primary">
            @icon('bi-list-ul')
            <span>{{ __('All') }}</span>
        </a>
        @if (!empty($post->id))
            <a wire:navigate href="{{ route('dashboard.posts.create') }}" class="btn xs btn-outline-green">
                @icon('bi-plus')
                <span>{{ __('Create') }}</span>
            </a>
        @endif
    </x-slot>
    <div class="flex flex-col md:flex-row gap-4">
        <div class="card card-body grow">
            <form wire:submit="save">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fgx:input wire:model.live="name" id="name" :label="__('Name')" autofocus />
                        @if (!empty($post->id))
                            <a href="{{ $post->permalink }}" target="_blank" class="link text-sm flex-space-2 mt-2">
                                @icon('bi-box-arrow-up-right')
                                <span>{{ $post->permalink }}</span>
                            </a>
                        @endif
                    </div>
                    <div class="col">
                        <fgx:input wire:model.live="slug" id="slug" :label="__('Slug')" autofocus />
                    </div>
                    <div class="col">
                        <fgx:textarea wire:model.live="description" id="description" :label="__('Description')" />
                    </div>
                    <div class="col">
                        <fgx:editor wire:model.live="content" id="content" :label="__('Content')" :value="$content"/>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
            <fgx:status class="mt-4 alert-soft" />
        </div>

        <div class="card card-body md:w-1/3">
            <livewire:components.file wire:model="thumbnail" :model="$post" collection="thumbnail" accept="image/*" :label="__('Featured image')">
            <fgx:error id="thumbnail"/>
            @dump($thumbnail)
        </div>
    </div>
</div>
