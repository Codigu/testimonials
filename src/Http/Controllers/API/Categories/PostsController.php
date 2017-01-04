<?php

namespace CopyaPost\Http\Controllers\API\Categories;

use Exception;
use CopyaPost\Transformers\PostTransformer;
use Copya\Http\Controllers\API\ApiBaseController;
use CopyaPost\Eloquent\Post;
use CopyaPost\Http\Requests\PostRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use CopyaPost\Eloquent\PostCategory;


class PostsController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Request$request, $category_id)
    {
        if($request->has('paginated')){
            $category = PostCategory::find($category_id);
            $category = $category->load('posts');

            return $this->collection($category->posts()->paginate(), new PostTransformer);
        } else {
            return $this->collection(Post::withTrashed()->get(), new PostTransformer);
        }
    }

    public function show($id)
    {
        $post = Post::withTrashed()->find($id);

        return $this->item($post, new PostTransformer);
    }

    public function store(PostRequest $request)
    {
        try {

            $data = $request->except('status');

            $post = new Post;

            $post->title = $data['title'];
            $post->content = $data['content'];
            $post->featured_image = ($request->has('featured_image')) ? $data['featured_image'] : null;
            if($request->get('status') == 'published'){
                $post->published_at = Carbon::now();
            }

            $post->save();

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $this->item($post, new PostTransformer);
    }

    public function update(PostRequest $request, $id)
    {
        try {
            $post = Post::withTrashed()->find($id);

            if($request->has('action')){
                if($request->get('action') == 'restore'){
                    $post->restore();
                }
            } else {
                $data = $request->all();

                $post->title = $data['title'];
                $post->content = $data['content'];
                $post->featured_image = ($request->has('featured_image')) ? $data['featured_image'] : null;
                if ($request->get('status') == 'published') {
                    $post->published_at = Carbon::now();
                }

                $post->save();
            }

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


        return $this->item($post, new PostTransformer);
    }

    public function destroy($id)
    {
        try{
            $post = Post::withTrashed()->find($id);
            if($post->trashed()){
                $post->forceDelete();
                return response()->json(['deleted' => true]);
            } else {
                Post::destroy($id);
                return $this->item($post, new PostTransformer);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


    }
}
