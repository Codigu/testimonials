@extends('vendor.copya.layouts.frontend', ['title' => $post->title])

@section('content')
    <h1>{{ $post->title }}</h1>

    <img src="{{ url('/images/medium/'.$post->featured_image) }}" />
    <div class="row">
        <div class="col-md-12">
            {!!  $post->content  !!}
        </div>
    </div>
    @if($prev)
    <div class="prev-post">
        <h5>Previous</h5>
        <a href="{{ url('post/'.$prev->slug) }}">{{ $prev->title }}</a>
    </div>
    @endif
    @if($next)
    <div class="next-post">
        <h5>Next</h5>
        <a href="{{ url('post/'.$next->slug) }}">{{ $next->title }}</a>
    </div>
    @endif
@endsection