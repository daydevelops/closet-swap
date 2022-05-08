<div class="flex justify-center">

    <div class="border-male-2 border-female-2 border-andro-2 hidden">
        <!-- used to load in dynamic tailwind classes -->
    </div>

    <div
        class="card h-96 mh-96 w-72 relative hover:scale-105 duration-500 transform transition cursor-pointer max-w-xs border-2 border-{{$product['gender']}}-2">
        <a href="{{route('products.show',$product['id'])}}">
            <div class="mb-2 max-h-48">
                @include('partials.carousel',['photos'=>$product['photos'], 'height' => 48, 'width' => 56])
            </div>
            <h3 class="font-bold text-lg mt-2">{{$product['title']}}</h3>
            <h3 class="text-sm text-gray-400 mb-2">
                {{$product['category']['name']}}
                @if($product['size'])
                | Size: {{$product['size']}}
                @endif
            </h3>
            <p class="block text-gray-800 italic">{{\Illuminate\Support\Str::limit($product['description'],80)}}</p>
        </a>
        <div class="block text-gray-800 font-weight-700 text-sm bottom-0 absolute">

            @include('partials.tags',['tags'=>json_decode($product['tags'])])
        </div>
    </div>
</div>