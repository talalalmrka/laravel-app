<x-edit-dialog :model="$permission" :title="$title">
    <div class="grid grid-cols-1 gap-4">
        <div class="col">
            <fgx:input id="name" wire:model.live="name" :label="__('Name')" />
        </div>
        <div class="col">
            <fgx:radio id="guard_name" wire:model.live="guard_name" :label="__('Guard name')"
                :options="guard_name_options()" />
        </div>
    </div>
</x-edit-dialog>
