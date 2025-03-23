<form wire:submit="confirmPassword">
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fgx:alert class="alert-info alert-soft">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </fgx:alert>
        </div>
        <div class="col">
            <fgx:input wire:model.live="password" id="password" class="pill" :label="__('Password')" autofocus
                autocomplete="new-password" :placeholder="__('Password')" startIcon="bi-key-fill" />
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary gradient w-full pill">{{ __('Confirm') }}</button>
            <fgx:status class="alert-soft mt-3" />
        </div>
    </div>
</form>
