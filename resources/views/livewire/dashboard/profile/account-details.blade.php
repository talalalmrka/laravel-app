<form wire:submit="save">
    <fgx:card>
        <fgx:card-header class="text-primary" icon="bi-key-fill" :title="__('Account details')" />
        <fgx:card-body>
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fgx:input type="text" id="name" wire:model.live="name" :label="__('Name')"
                        startIcon="bi-person-fill" />
                </div>
                <div class="col">
                    <fgx:input type="text" id="email" wire:model.live="email" :label="__('Email')"
                        startIcon="bi-envelope-fill" />
                </div>
            </div>
        </fgx:card-body>
        <fgx:card-submit-footer />
    </fgx:card>
</form>
