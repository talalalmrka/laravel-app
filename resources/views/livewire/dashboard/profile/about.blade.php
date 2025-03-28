<form wire:submit="save">
    <fgx:card>
        <fgx:card-header class="text-primary" icon="bi-info-circle" :title="__('About')" />
        <fgx:card-body>
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fgx:textarea id="about" wire:model.live="about" :label="__('About')" />
                </div>
            </div>
        </fgx:card-body>
        <fgx:card-submit-footer />
    </fgx:card>
</form>
