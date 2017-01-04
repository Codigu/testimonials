<?php

namespace CopyaPost\Http\Controllers\API;

use Exception;
use Copya\Http\Controllers\API\ApiBaseController;
use CopyaPost\Eloquent\Post;
use Illuminate\Http\Request;
use Storage;


class FilesController extends ApiBaseController
{
    public function index()
    {
        return $this->collection(Post::all(), new PostTransformer);
    }

   /* public function show($id)
    {
        $post = Post::find($id);

        return $this->item($post, new PostTransformer);
    }*/

    public function store(Request $request)
    {
        try {
            //$file = $request->file('file')->store('images', 'local');
            $file = Storage::putFile('public', $request->file('file'));

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['data' => ['file' => $file]]);
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);

            $category->name = $request->name;
            $category->description = $request->description;

            $category->save();

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $this->item($category, new CategoryTransformer);
    }

    public function destroy($id)
    {
        try{
            Post::destroy($id);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['deleted' => true]);
    }
}
