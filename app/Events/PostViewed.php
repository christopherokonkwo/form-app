<?php

namespace App\Events;

use App\Models\Post;

class PostViewed
{
    /**
     * The post instance.
     *
     * @var Post
     */
    public $post;

    /**
     * Create a new event instance.
     *
     * @param  Post  $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
