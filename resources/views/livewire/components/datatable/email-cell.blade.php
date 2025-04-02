@props(['user'])
<div class="flex items-center space-x-1 rtl:space-x-reverse">
    <x-verified :verified="$user->hasVerifiedEmail()" class="sm" />
    <a class="font-medium hover:underline" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
</div>
@if (!$user->hasVerifiedEmail())
    <button wire:click="sendEmailVerification({{ $user->id }})" type="button"
        class="flex items-center text-xs font-medium text-blue-600 dark:text-blue-500 hover:underline">
        <x-loader wire:loading wire:target="sendEmailVerification({{ $user->id }})" size="3" />
        {{ __('Send verification') }}
    </button>
@endif
