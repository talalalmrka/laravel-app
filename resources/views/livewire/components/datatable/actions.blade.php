@props(['item', 'actions'])
<div class="flex-space-2 md:flex-space-3">
    @foreach ($actions as $action)
        {!! $action->click("{$action->click}({$item->id})")->render() !!}
    @endforeach
</div>
