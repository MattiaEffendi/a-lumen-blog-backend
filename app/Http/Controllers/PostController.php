<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Routing\Controller as BaseController;

class PostController extends BaseController
{
    public function get($id)
    {
        return $this->getOne($id);
    }

    public function getAll()
    {
        $message = 'prova';
        Log::emergency($message);
        Log::alert($message);
        Log::critical($message);
        Log::error($message);
        Log::warning($message);
        Log::notice($message);
        Log::info($message);
        Log::debug($message);

        return Post::orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return Post
     */
    public function new(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',
        ]);

        $post = new Post();
        $post->fill($request->all());
        $post->user_id = Auth::user()->id;
        $post->save();

        return $this->getOne($post->id);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        Gate::authorize('update', $post);

        $post->fill($request->all());
        $post->save();

        return $this->getOne($post->id);
    }

    /**
     * @param $id
     *
     * @throws \Exception
     *
     * @return array
     */
    public function delete($id)
    {
        $post = Post::findOrFail($id);

        Gate::authorize('delete', $post);

        $post->delete();

        return [];
    }

    private function getOne($id)
    {
        return Post::findOrFail($id);
    }
}
