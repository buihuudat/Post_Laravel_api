<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($id)
  {
    $post = Post::find($id);

    if (!$post) {
      return response([
        'message' => 'Post not found'
      ], 403);
    }

    return response([
      'comment' => $post->comments()->with('user:id,name,image')->get(),
    ], 200);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $id)
  {
    $post = Post::find($id);
    if (!$post) {
      return response([
        'message' => 'Post not found'
      ]);
    }
    $attrs = $request->validate([
      'comment' => 'required|string'
    ]);

    Comment::create([
      'comment' => $attrs['comment'],
      'post_id' => $id,
      'user_id' => auth()->user()->id
    ]);

    return response([
      'message' => 'created comment successfully'
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $comment = Comment::find($id);
    if (!$comment) {
      return response([
        'message' => 'Comment not found'
      ]);
    }

    if ($comment->user_id != auth()->user()->id) {
      return response([
        'message' => 'Permission denied'
      ]);
    }

    $attrs = $request->validate([
      'comment' => 'required|string'
    ]);

    $comment->update([
      'comment' => $attrs['comment']
    ]);

    return response([
      'message' => 'Comment updated successfully'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $comment = Comment::find($id);
    if (!$comment) {
      return response([
        'message' => 'comment not found'
      ]);
    }

    if ($comment->user_id != auth()->user()->id) {
      return response([
        'message' => 'Permission denied'
      ]);
    }

    $comment->delete();

    return response([
      'message' => 'Comment deleted successfully'
    ]);
  }
}
