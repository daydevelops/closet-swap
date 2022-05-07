<x-app-layout>
    <div class="container mx-auto mt-8 max-w-8xl">
        <div class="md:flex align-center mx-auto max-w-2xl mb-16">
            <div class="px-8 md:shrink-0 md:mx-0 md:text-left mx-auto text-center">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                    class="inline rounded-full md:h-40 h-20 md:w-40 w-20 object-cover border m-3">

                <div class="mx-auto text-center">
                    <i class="cursor-pointer text-4xl px-2 text-blue-400 fa fa-comment-dots"></i>
                    <i class="cursor-pointer text-4xl px-2 text-pink-200 fa fa-heart"></i>
                </div>
            </div>
            <div class="md:mx-0 mx-auto md:text-left text-center">
                <h2 class="font-semibold text-4xl text-gray-800">
                    {{ $user->name }}
                </h2>
                <p class="text-gray-400">
                    <span>@</span>{{ $user->handle }}
                </p>
                <p class="text-gray-800 text-2xl">
                    {{ $user->bio }}
                </p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4">
            @foreach($products as $product)
            <x-product-preview :product="$product" />
            @endforeach
        </div>
    </div>
</x-app-layout>
