<x-app-layout>
    <div class="container mx-auto my-8 max-w-8xl">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div>
                <div class="card">
                    <div class="mb-1 max-h-96">
                        @include('partials.carousel',['photos'=>$product['photos'], 'height' => 96, 'width' => 96])
                    </div>

                    @if(!auth()->check() || auth()->id() != $product->user->id)
                    <div class="mx-auto text-center">
                        <i class="cursor-pointer text-4xl px-2 text-blue-400 fa fa-comment-dots"></i>
                        <i class="cursor-pointer text-4xl px-2 text-pink-200 fa fa-heart"></i>
                    </div>
                    @endif
                </div>
            </div>

            <div class="text-left m-4">
                <h2 class="font-semibold text-4xl text-gray-800">
                    {{ $product->title }}
                </h2>
                <h3 class="font-semibold text-xl text-gray-800 mb-8">

                    <img src="{{ $product->user->profile_photo_url }}" alt="{{ $product->user->name }}"
                        class="inline rounded-full h-8 w-8 object-cover border">
                    {{ $product->user->name }}
                </h3>
                <div class="grid grid-cols-3 col-span-2 text-gray-400">
                    <p>
                        Category:
                    </p>
                    <p>
                        {{ $product->category->name }}
                    </p>
                </div>
                <div class="grid grid-cols-3 col-span-2 text-gray-400">
                    <p>
                        Size:
                    </p>
                    <p>
                        {{ $product->size }}
                    </p>
                </div>
                <div class="grid grid-cols-3 col-span-2 text-gray-400">
                    <p>
                        Gender:
                    </p>
                    <p>
                        {{ $product->gender }}
                    </p>
                </div>
                <div class="grid grid-cols-1 mb-4 text-gray-400">
                    <p>
                        @foreach(json_decode($product->tags) as $tag)
                        {{' #' . $tag}}
                        @endforeach
                    </p>
                </div>
                <div class="grid grid-cols-1">
                    <p>
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>
        <div class="container my-8">
            <h4 class="text-center text-lg font-semibold">More like this...</h4>
            <livewire:product-list similar_to_product_id="{{$product->id}}"/>
        </div>
    </div>
</x-app-layout>
