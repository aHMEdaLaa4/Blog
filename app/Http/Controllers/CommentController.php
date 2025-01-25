<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResources;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NotifyUser;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
      return CommentResources::collection(Comment::where('post_id',$post->id)->get());  
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(string $post ,StoreCommentRequest $request)
    {
        $request->validated($request->all());
        $comment = Comment::create([
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'post_id' => $post,
        ]);
        $post = Post::find($post);
        $comment_owner = User::find($comment->user_id); // Get the user
        $post_owner = User::find($post->user_id); // Get the user
        $post_owner->notify(new NotifyUser($comment_owner->name . ' Commented on your post: ' . $comment->body));
        return new CommentResources($comment);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $post ,Comment $comment)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request,string $post, Comment $comment)
    {
        if (Auth::user()->id !== $comment->user_id) {
            return $this->error('','You are not Authorized',403);
        }

        $request->validated($request->all());
        $comment->update([
            'body' =>$request->body
        ]);
        return new CommentResources($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $post, string $comment)
    {
        $comment = Comment::find($comment);
        $post = Post::find($post);
        
        if (Auth::user()->id !== $post->user_id && Auth::user()->id !== $comment->user_id) {
            return $this->error('','You are not Authorized',403);
        }

        $comment->delete();
        return response(null,201);
    
    }
}
