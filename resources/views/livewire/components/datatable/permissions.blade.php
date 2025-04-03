@props(['role', 'size' => 'sm', 'pill' => true, 'outline' => true, 'color' => 'emerald'])
<div class="inline-flex flex-wrap gap-2">
    @if ($role->getPermissionNames()->isNotEmpty())
        @foreach ($role->getPermissionNames() as $permission)
            @php
                $label = is_string(__("models.permissions.{$permission}"))
                    ? __("models.permissions.{$permission}")
                    : $permission;
                $icon = config("icons.{$permission}", '');
            @endphp
            <fgx:badge :label="$label" :icon="$icon" :color="$color" :size="$size"
                :pill="$pill" :outline="$outline" />
        @endforeach
    @endif

</div>
