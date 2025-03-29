<form wire:submit="delete">
    <fgx:card>
        <fgx:card-header class="text-red" icon="bi-trash-fill" :title="__('Delete account')" />
        <fgx:card-body>
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fgx:alert type="warning" soft>
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </fgx:alert>
                </div>
                <div class="col">
                    {{ __('Are you sure you want to delete your account?') }}
                </div>
                <div class="col">
                    <fgx:switch id="confirm" wire:model.live="confirm" :label="__('Yes delete')" />
                </div>
            </div>
        </fgx:card-body>
        <fgx:card-submit-footer buttonClass="btn-red" icon="bi-trash-fill" :label="__('Delete Account')" />
    </fgx:card>
</form>
