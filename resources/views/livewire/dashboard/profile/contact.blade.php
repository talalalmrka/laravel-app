<form wire:submit="save">
    <fgx:card>
        <fgx:card-header class="text-primary" icon="bi-telephone-fill" :title="__('Contact')" />
        <fgx:card-body>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col">
                    <fgx:tel id="phone" wire:model.live="phone" :label="__('Phone')" startIcon="bi-telephone-fill" />
                </div>
                <div class="col">
                    <fgx:input type="text" id="url" wire:model.live="url" :label="__('Website')"
                        startIcon="bi-globe" />
                </div>
                <div class="col">
                    <fgx:tel id="whatsapp" wire:model.live="whatsapp" :label="__('Whatsapp')"
                        startIcon="bi-whatsapp" />
                </div>
                <div class="col">
                    <fgx:input type="text" id="facebook" wire:model.live="facebook" :label="__('Facebook')"
                        startIcon="bi-facebook" />
                </div>
            </div>
        </fgx:card-body>
        <fgx:card-submit-footer />
    </fgx:card>
</form>
