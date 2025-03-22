<div class="card card-body md:max-w-[350px] mx-auto">
    <h5 class="text-gradient from-primary to-pink text-3xl font-semibold text-center">Create account</h5>
    <form wire:submit="register">
        <div class="grid grid-cols-1 gap-3">
            <div class="col">
                <label for="name" class="form-label">Username</label>
                <div class="form-control-container">
                    <span class="start-icon">
                        <i class="icon bi-person-fill"></i>
                    </span>
                    <input wire:model="name" type="text" id="name" name="name" class="form-control has-start-icon pill {{ $errors->has('name') ? 'error' : ''; }}" placeholder="Username" autofocus="" autocomplete="name">
                </div>
            </div>
            <div class="col">
                <label for="email" class="form-label {{ $errors->has('email') ? 'error' : ''; }}">Email</label>
                <div class="form-control-container">
                    <span class="start-icon">
                        <i class="icon bi-envelope"></i>
                    </span>
                    <input wire:model="email" type="text" id="email" name="email" class="form-control has-start-icon pill {{ $errors->has('email') ? 'error' : ''; }}" placeholder="Email" autofocus="" autocomplete="email">
                </div>
            </div>
            <div class="col">
                <label for="password" class="form-label {{ $errors->has('password') ? 'error' : ''; }}">Password</label>
                <div class="form-control-container">
                    <span class="start-icon">
                        <i class="icon bi-key-fill"></i>
                    </span>
                    <input wire:model="password" type="password" id="password" name="password" class="form-control pill has-start-icon has-end-icon password-toggle-inited {{ $errors->has('password') ? 'error' : ''; }}" placeholder="Password" autofocus="" autocomplete="new-password">
                    <button type="button" class="end-icon btn-password-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"></path>
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"></path>
                        </svg></button>
                </div>
            </div>
            <div class="col">
                <label for="password_confirmation" class="form-label {{ $errors->has('password_confirmation') ? 'error' : ''; }}">Confirm password</label>
                <div class="form-control-container">
                    <span class="start-icon">
                        <i class="icon bi-key-fill"></i>
                    </span>
                    <input wire:model="password_confirmation" type="password" id="password_confirmation" name="password_confirmation" class="form-control pill has-start-icon has-end-icon password-toggle-inited {{ $errors->has('password_confirmation') ? 'error' : ''; }}" placeholder="Confirm password" autofocus="" autocomplete="new-password">
                    <button type="button" class="end-icon btn-password-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"></path>
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"></path>
                        </svg></button>
                </div>
            </div>
            <div class="col">
                <label class="form-switch {{ $errors->has('agree') ? 'error' : ''; }}">
                    <input wire:model="agree" type="checkbox" name="agree">
                    <span class="toggle-slider"></span>
                    <span class="form-switch-label">I aggree <a class="link" href="#!">terms</a> and <a class="link" href="#!">conditions</a>.</span>
                </label>
            </div>
            <div class="col">
                <button type="submit" role="button" class="btn btn-primary w-full pill">Register</button>
            </div>
            <div class="col">
                <div class="flex space-x-2 justify-center text-sm">
                    <span>Have an account?</span>
                    <a href="#!" class="link">Sign in</a>
                </div>
            </div>
        </div>
    </form>
</div>