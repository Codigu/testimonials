@extends('vendor.copya.layouts.frontend', ['title' => $category->name])

@section('content')
    <h1>{{ $category->name }}</h1>
    <div class="blog-list">
        <ul></ul>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajax({
                url: "/api/categories/{{ $category->id }}/posts?paginated=true&page=1",
                context: document.body
            }).done(function(data) {
                $.each(data.data, function(key, value) {
                    console.log(value);
                    $(".blog-list ul").append('<li>'+value.title+'</li>');
                });
            });
        });
    </script>
@endsection