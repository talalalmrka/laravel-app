@props(['items'])
<div class="flex flex-wrap gap-2">
    @foreach ($items as $item)
        <span class="badge badge-green badge-outline pill sm green">{{ $item }}</span>
    @endforeach
</div>
