<div>
  <div class="alert alert-success alert-soft">
    Welocome:
    <div>{{ auth()->user()->name }}</div>
    <div>{{ auth()->user()->email }}</div>
  </div>
<a class="btn btn-red mt-4" href="{{ route('logout')}}">
  {{ __('Sign out') }}
</a>
</div>
