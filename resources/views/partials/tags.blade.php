<p class="text-gray-400">
    @foreach($tags as $tag)
        <a href="{{route('search.tag',$tag)}}" class="hover:text-gray-700">{{' #' . $tag}}</a>
    @endforeach
</p>