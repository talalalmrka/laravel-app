<div class="container my-6">
  <h3>Profile</h3>
  <div class="card">
    <div class="card-body">
      <form wire:submit="save">
        <div class="grid grid-cols-1 gap-4">
          <div class="col">
            <label for="name" class="form-label {{ $errors->has('name') ? 'error': '' }}">
              {{ __('Name') }}
              </label>
              <input id="name" wire:model.live="name" class="form-control {{ $errors->has('name') ? 'error': '' }}" autofocus />
              @error('name')
                  <div class="text-sm mt-1.5 text-red">{{ $message }}</div>
              @enderror
          </div>
          <div class="col">
            <label for="email" class="form-label {{ $errors->has('email') ? 'error': '' }}">
              {{ __('Email') }}
            </label>
              <input id="email" wire:model.live="email" class="form-control {{ $errors->has('email') ? 'error': '' }}" autofocus />
              @error('email')
                  <div class="text-sm mt-1.5 text-red">{{ $message }}</div>
              @enderror
          </div>
          <div class="col">
            <label for="images" class="form-label {{ $errors->has('images') || $errors->has('images.*') ? 'error': '' }}">
              {{ __('Name') }}
              </label>
              <x-file model="images" accept="image/*"/>]
              @error(['images', 'images.*'])
                  <div class="text-sm mt-1.5 text-red">{{ $message }}</div>
              @enderror
          </div>
          <div class="col">
            <button type="submit" class="btn btn-primary">
              {{ __('save'); }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
