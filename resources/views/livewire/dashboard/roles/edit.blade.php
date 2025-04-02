<div>
    <x-slot name="actions">
        <a wire:navigate href="{{ route('dashboard.roles') }}" class="btn xs btn-outline-primary">
            @icon('bi-list-ul')
            <span>{{ __('All') }}</span>
        </a>
        @if (!$this->saved())
            <a wire:navigate href="{{ route('dashboard.roles.create') }}" class="">
                @icon('bi-plus')
                <span>{{ __('Create') }}</span>
            </a>
        @endif
    </x-slot>
    <form wire:submit="save">
        <fgx:card>
            <fgx:card-body>
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fgx:input type="text" id="name" wire:model.live="name" :label="__('Name')" />
                    </div>
                    <div class="col">
                        <fgx:radio id="guard_name" wire:model.live="guard_name" :label="__('Guard name')"
                            :options="guard_name_options()" />
                    </div>
                    <div class="col">
                        <fgx:switch-group id="permissions" wire:model.live="permissions" :label="__('Permissions')"
                            :options="permission_options($guard_name)" />
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon bi-floppy"></i>
                            <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                            <fgx:loader wire:loading wire:target="save"/>
                        </button>
                        <fgx:status class="alert-soft xs mt-2"/>
                    </div>
                </div>
            </fgx:card-body>
        </fgx:card>
    </form>
</div>
