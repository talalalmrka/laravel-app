<form wire:submit="save">
    <fgx:card>
        <fgx:card-header class="text-primary" icon="bi-geo-alt" :title="__('Address')" />
        <fgx:card-body>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col">
                    <fgx:input type="text" id="street" wire:model.live="street" :label="__('Street')" />
                </div>
                <div class="col">
                    <fgx:input type="text" id="city" wire:model.live="city" :label="__('City')" />
                </div>
                <div class="col">
                    <fgx:input type="text" id="state" wire:model.live="state" :label="__('State/Province')" />
                </div>
                <div class="col">
                    <fgx:input type="text" id="zipcode" wire:model.live="zipcode" :label="__('Zipcode')" />
                </div>
            </div>
        </fgx:card-body>
        <fgx:card-submit-footer />
    </fgx:card>
</form>
