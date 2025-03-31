<form wire:submit="save">
    <fgx:card>
        <fgx:card-header class="text-primary" icon="bi-key-fill" :title="__('Adminstrator options')" />
        <fgx:card-body>
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fgx:switch-group id="roles" wire:model.live="roles" :label="__('Roles')" :options="$options"/>
                </div>
            </div>
        </fgx:card-body>
        <fgx:card-submit-footer />
    </fgx:card>
</form>
