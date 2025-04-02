@props(['user'])
<div class="flex flex-wrap gap-2">
    @foreach ($user->getRoleNames() as $role)
        <span
            class="bg-green-200 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{ $role }}</span>
    @endforeach
</div>
