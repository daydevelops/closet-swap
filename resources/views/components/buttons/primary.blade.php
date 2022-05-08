<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-male-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-male-3 focus:outline-none focus:border-male-3 focus:ring focus:ring-male-1 active:bg-male-3 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
