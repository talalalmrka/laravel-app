<div>
    <fgx:label id="{{ $collection }}" :label="$label" />
    <div class="form-drop-zone {{ $multiple ? 'multiple' : '' }}" x-cloak>
        <input type="file" wire:model="files" class="hidden" {{ $multiple ? 'multiple' : '' }}>
        <div class="previews-grid">
            @if ($previews && $previews->isNotEmpty())
                @foreach ($previews as $preview)
                    <div id="previews-item-{{ $preview->id }}" class="previews-item"
                        :class="{ 'hidden': @js(!$multiple) && queue.length }">
                        @if ($preview->type === 'image')
                            <img src="{{ $preview->url }}">
                        @else
                            <div class="flex items-center justify-center w-full h-full">
                                <div class="text-center">
                                    <i class="icon {{ $preview->icon }}"></i>
                                    <div class="text-xs mt-2">
                                        <div class="font-semibold">{{ $preview->name }}</div>
                                        <div class="mt-1">{{ $preview->mime_type }}</div>
                                        <div class="mt-1">{{ $preview->humanReadableSize }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <button type="button" class="previews-item-delete"
                            x-on:click="deletePreview(@js($preview))">
                            <i class="icon bi-trash-fill"></i>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <fgx:info id="{{ $collection }}" :info="$label" />
    <fgx:error id="{{ $collection }}" />
</div>
