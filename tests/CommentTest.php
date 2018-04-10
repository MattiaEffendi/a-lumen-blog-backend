<?php

class Comment extends TestCase
{
    public function testGetCommentsByPostId()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $comment = factory(App\Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $this->json('GET','/comments/', ['post_id' => $post->id])
            ->seeStatusCode(200)
            ->seeJsonEquals([$comment->toArray()]);
        $this->seeInDatabase('comments', $comment->toArray());
    }
}