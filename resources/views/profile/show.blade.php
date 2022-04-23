<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
        <p class="text-gray-400">
            <span>@</span>{{ $user->handle }}
        </p>
    </x-slot>

    <div>
    </div>
</x-app-layout>
