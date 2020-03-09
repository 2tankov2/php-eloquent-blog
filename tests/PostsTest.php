<?php

namespace App\Tests;

use App\actions\Posts;
use App\User;
use App\Post;
use App\PostLike;

class PostsTest extends BaseTest
{
    private $user;
    private $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->factory->create(User::class);
        $this->post = $this->factory->create(Post::class);
    }

    public function testCreate()
    {
        $params = [
            'title' => $this->faker->text,
            'body' => $this->faker->text
        ];

        $post = Posts::create($this->user, $params);
        $this->assertEquals($this->user->toArray(), $post->creator->toArray());
    }

    public function testPostLike()
    {
        $like = Posts::createLike($this->user, $this->post);
        $this->assertEquals($this->user->toArray(), $like->creator->toArray());
        $this->assertEquals($this->post->toArray(), $like->post->toArray());
    }
}
