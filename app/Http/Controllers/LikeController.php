<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
  public function likeOrUnlike($id)
  {
    $post = Post::find($id);

    if (!$post) {
      return response([
        'message' => 'Post not found'
      ], 400);
    }

    $like = $post->likes()->where('user_id', auth()->user()->id)->first();

    if (!$like) {
      Like::create([
        'post_id' => $id,
        'user_id' => auth()->user()->id,
      ]);
      return response([
        'message' => 'Liked'
      ], 200);
    }
    $like->delete();

    return response([
      'message' => 'disliked'
    ], 200);
  }
}
