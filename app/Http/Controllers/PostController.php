<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only('store', 'destroy');
    }
    public function index()
    {
                    //Or orderBy(date,desc|asc)
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20); //collection

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);


        $request->user()->posts()->create($request->only('body'));
        /*
        You can use this for multiple inputs
        $request->user()->posts()->create([
            'body' => $request->body
        ]);
        */
        return back();
        //auth()->user()->post()->create();
        // Post::create([
        //     'user_id' => auth()->user()->id, //auth()->id
        //     'body' => $request->body
        // ]);

    }
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();
        return back();
    }
}
