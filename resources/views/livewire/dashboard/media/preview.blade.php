@props(['media', 'class' => null, 'atts' => []])

<div
    class="relative flex items-center justify-center w-32 h-32 rounded border bg-gray/5 border-gray-300 dark:border-gray-600">
    @switch($media->type)
        @case('image')
            <img class="max-w-full max-h-full" src="{{ $media->original_url }}" alt="{{ $media->name }}" />
        @break

        @case('video')
            <video class="max-w-full max-h-full" controls>
                <source src="{{ $media->original_url }}" type="{{ $media->mime_type }}">
                Your browser does not support the video tag.
            </video>
        @break

        @default
            <div class="text-center">
                <i class="icon {{ preview($media)->icon }} w-8 h-8"></i>
                <div class="text-center font-medium">{{ $media->name }}</div>
                <div class="text-center font-light">{{ $media->type }}</div>
                <div class="text-center font-light">{{ $media->humanReadableSize }}</div>
            </div>
    @endswitch
</div>
