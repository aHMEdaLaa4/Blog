<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\Postsresources;
use App\Models\User;
use App\Notifications\NotifyUser;
use App\Traits\HttpResponses;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class PostController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Postsresources::collection(Post::where('user_id',Auth::user()->id)->get());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $request->validated($request->all());
        $post = Post::create([
            'body' => $request->body,
            'user_id' => Auth::user()->id
        ]);
        return new Postsresources($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $post)
    {
        $post = Post::find($post);
        if ($post) {
            return new Postsresources($post);
        }
        return $this->error('','this Post is not exist',404);

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if (Auth::user()->id !== $post->user_id) {
            return $this->error('','You are not Authorized',403);
        }

        $request->validated($request->all());
        $post->update([
            'body' =>$request->body
        ]);
        return new Postsresources($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::user()->id !== $post->user_id) {
            return $this->error('','You are not Authorized',403);
        }
        $post->delete();
        return response(null,201);
    }

}
