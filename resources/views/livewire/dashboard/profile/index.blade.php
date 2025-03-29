<div class="pb-10">
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
            <livewire:dashboard.profile.personal :user="$user" wire:key="personal" />
        </div>
        <div class="col">
            <livewire:dashboard.profile.contact :user="$user" wire:key="contact" />
        </div>
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col">
            <livewire:dashboard.profile.address :user="$user" wire:key="address" />
        </div>
        <div class="col">
            <livewire:dashboard.profile.about :user="$user" wire:key="about" />
        </div>
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col">
            <livewire:dashboard.profile.password :user="$user" wire:key="change_password" />
        </div>
        <div class="col">
            <livewire:dashboard.profile.delete :user="$user" wire:key="delete_account" />
        </div>
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col">
            <livewire:dashboard.profile.images :user="$user" wire:key="images" />
        </div>
        <div class="col">
            col
        </div>
    </div>
</div>
