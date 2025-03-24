<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="col">
            <livewire:dashboard.profile.avatar :user="$user" wire:key="avatar" />
        </div>
        <div class="col md:col-span-2">
            <livewire:dashboard.profile.account-details :user="$user" wire:key="account_details" />
        </div>
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col">
            <livewire:dashboard.profile.images :user="$user" wire:key="images" />
        </div>
        <div class="col">
            Column 2
        </div>
        </d>
    </div>
