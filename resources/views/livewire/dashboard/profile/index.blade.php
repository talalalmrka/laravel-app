<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="col">
            <div class="card h-full min-h-40">

            </div>
        </div>
        <div class="col md:col-span-2">
            <livewire:dashboard.profile.account-details :user="$user" />
        </div>
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col">
              <livewire:dashboard.profile.images :user="$user" />
        </div>
        <div class="col">
          Column 2
        </div>
    </d>
</div>
