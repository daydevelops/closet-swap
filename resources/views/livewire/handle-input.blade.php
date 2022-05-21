<div>
    <x-jet-input id="handle" class="block mt-1 w-full" type="text" name="handle" required value="{{ old('handle') }}" wire:model="handle" />
    @if($success != '')
    <p class="text-xs text-male-3 mt-1">{{$success}}</p>
    @endif
    @if($warning != '')
    <p class="text-xs text-female-3 mt-1">{{$warning}}</p>
    @endif
</div>
