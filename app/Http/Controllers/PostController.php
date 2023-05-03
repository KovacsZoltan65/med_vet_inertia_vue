<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Post::query()->paginate(10);

        return Inertia::render('posts/index', [
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        Post::create($request->all());

        return redirect()
            ->back()
            -with('message', 'Post created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $Post){}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $Post)
    {
        $Post->update($request->all());

        return redirect()
            ->back()
            ->with('message', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $Post)
    {
        $Post->delete();

        return redirect()
            ->back()
            ->with('message', 'Post deleted');
    }

    public function getPosts(){
        $data = Post::all();

        return $data;
    }
}
