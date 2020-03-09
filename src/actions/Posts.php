<?php

namespace App\actions;

use App\User;
use App\Post;

class Posts
{
    public static function create($user, $params)
    {
        // BEGIN (write your solution here)
        $post = $user->posts()->make($params);
        $post->save();
        return $post;
        // END
    }

    public static function createLike($user, $post)
    {
        // BEGIN (write your solution here)
        $like = $post->likes()->make();
        $like->creator()->associate($user);
        $like->save();

        return $like;
        // END
    }

    public static function index($user, $limit)
    {
        $posts = Post::limit($limit)->orderBy('created_at', 'desc')->get();
        $postIds = $posts->pluck('id');
        $likedPostIds = $user->postLikes()->whereIn('post_id', $postIds)->pluck('post_id');

        $result = $posts->map(function ($post) use ($likedPostIds) {
            return ['post' => $post->toArray(), 'liked' => $likedPostIds->contains($post->id)];
        });

        return $result;
    }
}
