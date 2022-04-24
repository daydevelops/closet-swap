<div>
    <div class="card product">
        {{$product->title}}
        @include('partials.carousel',['photos'=>$product->photos])
    </div>
</div>