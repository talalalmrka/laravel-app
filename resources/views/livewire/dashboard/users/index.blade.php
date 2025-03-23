<div class="card">
    <div class="btn-group sm m-2">
        <button wire:click="deleteSelected" class="btn btn-red sm">
            <i class="icon bi-trash-fill"></i>
        </button>
        <a wire:navigate href="{{ route('dashboard.users.create') }}" class="btn btn-green">
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
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Creation data') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->isNotEmpty())
                    @foreach ($users as $user)
                        <tr wire:key="{{ $user->id }}">
                            <td>
                                <input type="checkbox" wire:model="selected" value="{{ $user->id }}"
                                    name="selected[]" />
                            </td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d, M Y') }}</td>
                            <td>
                                <div class="flex space-x-2 justify-center">
                                    <button wire:click="edit({{ $user->id }})" type="button"
                                        class="btn btn-green xs flex-space-1 justify-center">
                                        <i class="icon bi-pencil-square"></i>
                                        <x-fgx::loader wire:loading wire:target="edit({{ $user->id }})" />
                                    </button>
                                    <button wire:click="delete({{ $user->id }})"
                                        wire:confirm="{{ __('Are you sure to delete?') }}" type="button"
                                        class="btn btn-red xs flex-space-1 justify-center">
                                        <i class="icon bi-trash-fill"></i>
                                        <x-fgx::loader wire:loading wire:target="delete({{ $user->id }})" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">{{ __('No users found') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if ($users->isNotEmpty())
        <div class="p-2">
            {{ $users->links() }}
        </div>
    @endif
</div>
