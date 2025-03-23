<form wire:submit="sendPasswordResetLink">
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fgx:input wire:model.live="email" id="email" class="pill" :label="__('Email address')" autofocus
                autocomplete="email" :placeholder="__('Email')" startIcon="bi-envelope-fill" />
        </div>
        <div class="col">
            <button type="submit"
                class="btn btn-primary gradient w-full pill">{{ __('Email password reset link') }}</button>
            <fgx:status class="alert-soft mt-3" />
        </div>
        @if (Route::has('login'))
            <div class="col">
                <div class="flex-space-2 justify-center text-sm">
                    <span>{{ __('Back to') }}</span>
                    <a href="{{ route('login') }}" class="link">{{ __('Login') }}</a>
                </div>
            </div>
        @endif

    </div>
</form>
