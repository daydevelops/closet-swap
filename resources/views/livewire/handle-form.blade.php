<x-jet-form-section submit="updateHandle">
    <x-slot name="title">
        {{ __('Update Handle') }}
    </x-slot>

    <x-slot name="description">
        {{ __('You can only choose your handle once, so pick a good one.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="handle" value="{{ __('Handle') }}" />
            <x-jet-input id="handle" class="block mt-1 w-full" type="text" name="handle" required
                value="{{ old('handle') }}" wire:model="handle" />
            @if($success != '')
            <p class="text-xs text-male-3 mt-1">{{$success}}</p>
            @endif
            @if($warning != '')
            <p class="text-xs text-female-3 mt-1">{{$warning}}</p>
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
