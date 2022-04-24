<div>
    <div class="card h-96 relative m-2 hover:-m-1 z-10 hover:z-20 hover:h-full">
        @include('partials.carousel',['photos'=>$product->photos])
        <h3 class="font-bold text-lg mt-2">{{$product->title}}</h3>
        <h3 class="text-sm text-gray-400 mb-2">
            {{$product->category->name}}
                @if($product->size)
                    | Size: {{$product->category->name}}
                @endif
        </h3>
        <p class="block text-gray-800 italic">{{$product->description}}</p>
        <p class="block text-gray-800 font-weight-700 text-sm bottom-0 absolute">
            @foreach(json_decode($product->tags) as $tag)
                {{' #' . $tag}}
            @endforeach
        </p>
    </div>
</div>
