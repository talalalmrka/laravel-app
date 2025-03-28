<form wire:submit="save">
    <fgx:card>
        <fgx:card-header class="text-primary" icon="bi-person-fill" :title="__('Personal details')" />
        <fgx:card-body>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col">
                    <fgx:input type="text" id="first_name" wire:model.live="first_name" :label="__('First name')" />
                </div>
                <div class="col">
                    <fgx:input type="text" id="last_name" wire:model.live="last_name" :label="__('Last name')" />
                </div>
                <div class="col md:col-span-2">
                    <fgx:input type="text" id="display_name" wire:model.live="display_name"
                        :label="__('Display name')" />
                </div>
            </div>
        </fgx:card-body>
        <fgx:card-submit-footer />
    </fgx:card>
</form>
