<form wire:submit="authenticate">
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fgx:input wire:model.live="email" id="email" class="pill" :label="__('Email address')" autofocus
                autocomplete="email" :placeholder="__('Email')" startIcon="bi-envelope-fill" />
        </div>
        <div class="col">
            <fgx:password wire:model.live="password" id="password" class="pill" :label="__('Password')"
                autofocus autocomplete="password" :placeholder="__('Password')" startIcon="bi-key-fill" />
        </div>
        <div class="col">
            <fgx:switch id="remember" wire:model.live="remember" :label="__('Remember Me.')" />
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary gradient w-full pill">{{ __('Sign in') }}</button>
            <fgx:status class="alert-soft mt-3" />
        </div>
        @if (Route::has('password.request'))
            <div class="col text-center">
                <div class="flex-space-2 justify-center">
                    <span>{{ __('Forgot your password?') }}</span>
                    <a href="{{ route('password.request') }}" class="link">{{ __('Recover password') }}</a>
                </div>
            </div>
        @endif
        @if (Route::has('register'))
            <div class="col">
                <div class="flex-space-2 justify-center text-sm">
                    <span>{{ __('Don\'t have an account?') }}</span>
                    <a href="{{ route('register') }}" class="link">{{ __('Sign up') }}</a>
                </div>
            </div>
        @endif

    </div>
</form>
