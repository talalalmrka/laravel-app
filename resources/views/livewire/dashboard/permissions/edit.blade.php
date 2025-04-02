<div>
    <x-slot name="actions">
        <a wire:navigate href="{{ route('dashboard.permissions') }}" class="btn xs btn-outline-primary">
            @icon('bi-list-ul')
            <span>{{ __('All') }}</span>
        </a>
        @if (!empty($permission->id))
            <a wire:navigate href="{{ route('dashboard.permissions.create') }}" class="btn xs btn-outline-green">
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
                        <fgx:input id="name" wire:model.live="name" :label="__('Name')"/>
                    </div>
                    <div class="col">
                        <fgx:radio id="guard_name" wire:model.live="guard_name" :label="__('Guard name')" :options="guard_name_options()"/>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon bi-floppy"></i>
                            <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                            <fgx:loader wire:loading wire:target="save"/>
                        </button>
                        <fgx:status/>
                    </div>
                </div>
            </fgx:card-body>
        </fgx:card>
    </form>
</div>
