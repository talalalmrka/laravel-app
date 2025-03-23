<div class="grid grid-cols-1 gap-3">
    <div class="col">
        <fgx:alert class="alert-info alert-soft">
            {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
        </fgx:alert>
    </div>
    <div class="col">
        <button wire:click="sendVerification" type="button" class="btn btn-primary gradient w-full pill">
            {{ __('Resend verification email') }}
        </button>
        @if (session('status') == 'verification-link-sent')
            <fgx:alert class="alert-success">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </fgx:alert>
        @endif
    </div>
    <div class="col">
        <button wire:click="logout" type="button" class="btn btn-outline-primary w-full pill">
            {{ __('Logout') }}
        </button>
    </div>
</div>
