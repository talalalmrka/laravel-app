<form wire:submit="authenticate">
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fgx:input wire:model.live="name" id="name" class="pill" :label="__('Name')" autofocus
                autocomplete="name" :placeholder="__('Name')" startIcon="bi-person-fill" />
        </div>
        <div class="col">
            <fgx:input wire:model.live="email" id="email" class="pill" :label="__('Email address')" autofocus
                autocomplete="email" :placeholder="__('Email address')" startIcon="bi-envelope-fill" />
        </div>
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
            <fgx:switch id="agree" wire:model.live="agree" :label="__('Agree terms and policy.')" />
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary gradient w-full pill">{{ __('Create account') }}</button>
            <fgx:status class="alert-soft mt-3" />
        </div>
        @if (Route::has('login'))
            <div class="col">
                <div class="flex-space-2 justify-center text-sm">
                    <span>{{ __('Already have an account?') }}</span>
                    <a href="{{ route('login') }}" class="link">{{ __('Login') }}</a>
                </div>
            </div>
        @endif

    </div>
</form>
