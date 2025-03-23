<x-app-layout :title="$title ?? ''">
    @include('partials.header', [
        'class' => 'sticky top-0 bg-gray-50 dark:bg-gray-700 max-w-full z-50 shadow-xs',
    ])
    <main class="main min-h-[75vh]">
        {{ $slot }}
    </main>
    @include('partials.footer')
</x-app-layout>
