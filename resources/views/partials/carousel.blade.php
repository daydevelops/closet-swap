@php
$carousel_id = "carousel-photos-" . $photos[0]['product_id'];
@endphp

<div id="{{$carousel_id}}" data-bs-interval="false" class="carousel carousel-dark relative max-h-{{$height}} w-{{$width}}" data-bs-ride="carousel">
    <div class="carousel-inner relative w-full h-{{$height}}">
        @foreach($photos as $photo)
        <div class="carousel-item relative max-w-full max-h-full min-h-{{$height}} {{$photo['is_primary'] ? 'active' : ''}}">
            <img src="{{$photo['path']}}" class="max-w-{{$width}} max-h-{{$height}} h-{{$height}} block mx-auto" />
        </div>
        @endforeach
    </div>
    <button
        class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:bg-slate-200 bg-slate-100 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"
        type="button" data-bs-target="#{{$carousel_id}}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon inline-block bg-no-repeat" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button
        class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:bg-slate-200 bg-slate-100 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
        type="button" data-bs-target="#{{$carousel_id}}" data-bs-slide="next">
        <span class="carousel-control-next-icon inline-block bg-no-repeat" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
