<form wire:submit="save">
    <fgx:card class="h-full">
        <fgx:card-header class="text-primary" icon="bi-key-fill" :title="__('Change password')" />
        <fgx:card-body>
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fgx:input type="password" id="password" wire:model.live="password" :label="__('New password')"
                        startIcon="bi-key" autocomplete="new-password"/>
                </div>
                <div class="col">
                    <fgx:input type="password" id="password_confirmation" wire:model.live="password_confirmation" :label="__('Confirm password')"
                        startIcon="bi-key" autocomplete="new-password"/>
                </div>
            </div>
        </fgx:card-body>
        <fgx:card-submit-footer />
    </fgx:card>
</form>
