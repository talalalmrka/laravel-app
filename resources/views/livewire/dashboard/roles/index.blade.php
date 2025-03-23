<div class="card">
    <div class="btn-group sm m-2">
        <button wire:click="deleteSelected" class="btn btn-red sm">
            <i class="icon bi-trash-fill"></i>
        </button>
        <a wire:navigate href="{{ route('dashboard.roles.create') }}" class="btn btn-green">
            <i class="icon bi-plus-lg"></i>
        </a>
    </div>
    <x-fgx::status class="m-2 alert-soft" />
    <div class="table-container">
        <table class="table table-striped table-divide table-rounded xs">
            <thead>
                <tr>
                    <th><input type="checkbox" /></th>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Guard name') }}</th>
                    <th>{{ __('Permissions') }}</th>
                    <th>{{ __('Creation data') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($roles->isNotEmpty())
                    @foreach ($roles as $role)
                        <tr wire:key="{{ $role->id }}">
                            <td>
                                <input type="checkbox" wire:model="selected" value="{{ $role->id }}"
                                    name="selected[]" />
                            </td>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->guard_name }}</td>
                            <td>
                                @foreach ($role->getPermissionNames() as $permission)
                                    <span class="badge badge-primary badge-outline pill">{{ $permission }}</span>
                                @endforeach
                            </td>
                            <td>{{ $role->created_at->format('d, M Y') }}</td>
                            <td>
                                <div class="flex space-x-2 justify-center">
                                    <button wire:click="edit({{ $role->id }})" type="button"
                                        class="btn btn-green xs flex-space-1 justify-center">
                                        <i class="icon bi-pencil-square"></i>
                                        <x-fgx::loader wire:loading wire:target="edit({{ $role->id }})" />
                                    </button>
                                    <button wire:click="delete({{ $role->id }})"
                                        wire:confirm="{{ __('Are you sure to delete?') }}" type="button"
                                        class="btn btn-red xs flex-space-1 justify-center">
                                        <i class="icon bi-trash-fill"></i>
                                        <x-fgx::loader wire:loading wire:target="delete({{ $role->id }})" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">{{ __('No data found') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if ($roles->isNotEmpty())
        <div class="p-2">
            {{ $roles->links() }}
        </div>
    @endif
</div>
