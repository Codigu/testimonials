<ul>
@foreach($posts as $post)
    <li>
        <h3>{{ $post->title }}</h3>
        <div class="content">{{ substr($post->content, 0, 100) }}</div>
    </li>
@endforeach
</ul>