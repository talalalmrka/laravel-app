<div>
    <x-slot name="actions">
        <a wire:navigate href="{{ route('dashboard.users') }}" class="btn xs btn-outline-primary">
            @icon('bi-list-ul')
            <span>{{ __('All') }}</span>
        </a>
        @if (!empty($user->id))
            <a wire:navigate href="{{ route('dashboard.users.create') }}" class="">
                @icon('bi-plus')
                <span>{{ __('Create') }}</span>
            </a>
        @endif
    </x-slot>
    <div class="card card-body">
        <form wire:submit="save">
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <x-fgx::input wire:model.live="name" id="name" :label="__('Name')" startIcon="bi-person-fill"
                        autofocus autocomplete="name" />
                </div>
                <div class="col">
                    <x-fgx::input wire:model.live="email" id="email" :label="__('Email')" startIcon="bi-envelope-fill"
                        autofocus autocomplete="email" />
                </div>
                @if (empty($user->id))
                    <div class="col">
                        <x-fgx::input type="password" wire:model.live="password" id="password" :label="__('Password')"
                            startIcon="bi-key-fill" autofocus autocomplete="new-password" />
                    </div>
                @endif
                <div class="col">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
        <x-fgx::status class="mt-4 alert-soft" />
    </div>
</div>
