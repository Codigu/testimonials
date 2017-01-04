@extends('vendor.copya.layouts.frontend', ['title' => 'Blog Page'])

@section('content')
    <div class="blog-page">
        <h1>Blogs</h1>
        <div class="blog-list">
            <ul></ul>
        </div>
        <input type="button" id="blog-more" />
    </div>
    [categories]
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajax({
                url: "/api/posts?paginated=true&page=1",
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