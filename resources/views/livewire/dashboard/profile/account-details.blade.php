<form wire:submit="save">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-primary">{{ __('Account details') }}</h5>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fgx:input type="text" id="name" wire:model="name" :label="__('Name')"
                        startIcon="bi-person-fill" />
                </div>
                <div class="col">
                    <fgx:input type="text" id="email" wire:model="email" :label="__('Email')"
                        startIcon="bi-envelope-fill" />
                </div>
            </div>
        </div>
        <div class="card-footer flex-space-1 justify-between">
            <button type="submit" class="btn btn-primary pill sm">
                <span wire:loading.remove wire:target="save">{{ __('save') }}</span>
                <fgx:loader wire:loading wire:target="save" />
            </button>
            <fgx:status class="alert-soft sm" />
        </div>
    </div>
</form>
