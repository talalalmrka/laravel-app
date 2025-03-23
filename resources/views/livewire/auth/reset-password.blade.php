<form wire:submit="resetPassword">
    <div class="grid grid-cols-1 gap-3">
        <input type="hidden" wire:model="email" />
        <div class="col">
            <fgx:input type="password" wire:model.live="password" id="password" class="pill" :label="__('Password')"
                :placeholder="__('Password')" autofocus autocomplete="new-password" startIcon="bi-key-fill" />
        </div>
        <div class="col">
            <fgx:input type="password" wire:model.live="password_confirmation" id="password_confirmation" class="pill"
                :label="__('Confirm password')" :placeholder="__('Confirm password')" autofocus
                autocomplete="new-password" startIcon="bi-key-fill" />
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary gradient w-full pill">{{ __('Reset password') }}</button>
            <fgx:status class="alert-soft mt-3" />
        </div>
    </div>
</form>
