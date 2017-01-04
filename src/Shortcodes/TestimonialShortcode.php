<?php

namespace CopyaTestimonial\Shortcodes;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\View;

class TestimonialShortcode {
    public function register($shortcode, $content, $compiler, $name)
    {

        /*$max = ($shortcode->max) ?: 0;
        $sort = ($shortcode->sort) ?: 'latest';
        $view = $shortcode->view;

        switch($sort){
            case 'latest':
            default:
                $posts = POST::orderBy('published_at', 'desc');
                break;
        }

        if($max > 0){
            $posts->take($max);
        }
        $posts = $posts->get();

        //check if view with the shortcode name param exists. else, fallbacks to default post widget view file
        if(View::exists('vendor.copya.front.widgets.'.$view)){

            return view('vendor.copya.front.widgets.'.$view, ['posts' => $posts]);
        } else {
            return view('vendor.copya.front.widgets.posts', ['posts' => $posts]);
        }*/

    }
}