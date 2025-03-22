<div>
  <div class="card card-body md:max-w-[350px] mx-auto">
    <h5 class="text-gradient from-primary to-pink text-3xl font-semibold text-center">Sign in</h5>
    <form wire:submit="login">
        <div class="grid grid-cols-1 gap-3">
            <div class="col">
                <label for="login" class="form-label {{ $errors->has('email') ? 'error' : ''; }}">{{ __('Email') }}</label>
                <div class="form-control-container">
                    <span class="start-icon">
                        <i class="icon bi-envelope-fill"></i>
                    </span>
                    <input wire:model="email" type="text" id="email" name="email" class="form-control has-start-icon pill {{ $errors->has('email') ? 'error' : ''; }}" placeholder="Email" autocomplete="email">
                </div>
            </div>
            <div class="col">
                <label for="password" class="form-label {{ $errors->has('password') ? 'error' : ''; }}">Password</label>
                <div class="form-control-container">
                    <span class="start-icon">
                        <i class="icon bi-key-fill"></i>
                    </span>
                    <input wire:model="password" type="password" id="password" name="password" class="form-control pill has-start-icon has-end-icon {{ $errors->has('password') ? 'error' : ''; }}" placeholder="Password" autofocus="" autocomplete="password">
                    <button type="button" class="end-icon btn-password-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"></path>
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"></path>
                        </svg></button>
                </div>
            </div>
            <div class="col">
                <label class="form-switch">
                    <input wire:model="remember" type="checkbox" name="remember">
                    <span class="toggle-slider"></span>
                    <span class="form-switch-label">Remember Me</span>
                </label>
            </div>
            <div class="col text-center text-sm">
                <div class="flex space-x-2 justify-center text-sm">
                    <span>Forgot password?</span>
                    <a href="#!" class="link">Recover password</a>
                </div>
            </div>
            <div class="col">
                <button type="submit" role="button" class="btn btn-primary w-full pill">Sign in</button>
            </div>
            <div class="col">
                <div class="flex space-x-2 justify-center text-sm">
                    <span>Don't have an account?</span>
                    <a href="#!" class="link">Sign up</a>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
