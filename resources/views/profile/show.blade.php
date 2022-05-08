<x-app-layout>
    <div class="container mx-auto mt-8 max-w-8xl">
        <div class="md:flex align-center mx-auto max-w-2xl mb-16">
            <div class="px-8 md:shrink-0 md:mx-0 md:text-left mx-auto text-center">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                    class="inline rounded-full md:h-40 h-20 md:w-40 w-20 object-cover border m-3">

                @if(!auth()->check() || auth()->id() != $user->id)
                <div class="mx-auto text-center">
                    <i class="cursor-pointer text-4xl px-2 text-male-2 fa fa-comment-dots"></i>
                    <i class="cursor-pointer text-4xl px-2 text-female-1 fa fa-heart"></i>
                </div>
                @endif
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
                <p class="text-gray-400 mt-4">
                    <span>999</span> Followers
                </p>
            </div>
        </div>

        @if(auth()->check() && auth()->id() == $user->id);
        <div class="text-center mb-8">
            <a href="{{route('products.create')}}"><x-button type="primary">Show Off A New Item!</x-button></a>
        </div>
        @endif

        <livewire:product-list user_id="{{$user->id}}"/>
    </div>
</x-app-layout>
