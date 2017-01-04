<?php

namespace CopyaTestimonial\Http\Controllers\FrontEnd;

use Copya\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use CopyaPost\Eloquent\Post;

class TestimonialsController extends BaseController
{
    public function index()
    {
        $posts = Post::all();

        return view('vendor.copya.front.posts.index', array('posts' => $posts))->withShortcodes();
    }

    public function show($slug)
    {
        $post = Post::findBySlug($slug);
        if (!$post || $post->published_at == null) {
            return abort(404);
        }
        $prev = prev_post($post->id);
        $next = next_post($post->id);

        return view('vendor.copya.front.posts.show', array('post' => $post, 'prev' => $prev, 'next' => $next))->withShortcodes();
    }
}
