<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Comment;

class CommentTest extends TestCase
{
    // Trait implemented in order to rollback each database affectation before each test
    use DatabaseTransactions;

    /**
     * @test
     * It displays all comments
     * @return void
     */
    public function it_displays_all_records()
    {
        $this->json('get', '/api/v1/comments')
            // HTTP response should be 200
            ->assertStatus(200)
            // Data and Meta keys should exist
            ->assertJsonStructure(['data', 'meta'])
            // And data should contain all comments
            ->assertJsonCount(Comment::count(), 'data');
    }

    /**
     * @test
     * It create a comment
     * @return void
     */
    public function it_create_a_comment()
    {
        $commentData = [
            "data" => [
                "name" => "David",
                "comment" => "Hi Luis!",
                "reply_to" => null,
                "comment_level" => 1
            ]
        ];

        $this->json('post', '/api/v1/comments', $commentData)
            // HTTP response should be 201
            ->assertStatus(201)
            // Response JSON should be the comment
            ->assertJson($commentData);
    }

    /**
     * @test
     * It creates a reply comment
     * @return void
     */
    public function it_creates_a_reply_comment()
    {
        $cm = Comment::create([
            "name" => "Luis",
            "comment" => "Hi!"
        ]);

        $commentData = [
            "data" => [
                "name" => "David",
                "comment" => "Hi Luis!",
                "reply_to" => $cm->id,
                "comment_level" => 2
            ]
        ];

        $this->json('post', '/api/v1/comments', $commentData)
            // HTTP response should be 201
            ->assertStatus(201)
            // Response JSON should be the comment
            ->assertJson($commentData);
    }

    /**
     * @test
     * It tries to reply a comment that doesn't exist
     * @return void
     */
    public function it_tries_to_create_a_invalid_reply_comment()
    {
        $commentData = [
            "data" => [
                "name" => "David",
                "comment" => "Hi Luis!",
                "reply_to" => 9999,
                "comment_level" => 2
            ]
        ];

        $this->json('post', '/api/v1/comments', $commentData)
            // HTTP response should be 422
            ->assertStatus(422)
            // Response JSON should be the comment
            ->assertJson([
                    "message" => "The given data was invalid.",
                    "errors" => [
                        "reply_to" => [
                            "The selected reply to is invalid."
                        ]
                    ]
                ]);
    }

    /**
     * @test
     * It tries to create a comment with layer greater than 3
     * @return void
     */
    public function it_tries_to_create_a_invalid_comment_level()
    {
        $commentData = [
            "data" => [
                "name" => "David",
                "comment" => "Hi Luis!",
                "reply_to" => null,
                "comment_level" => 5
            ]
        ];

        $this->json('post', '/api/v1/comments', $commentData)
            // HTTP response should be 422
            ->assertStatus(422)
            // Response JSON should be the comment
            ->assertJson([
                    "message" => "The given data was invalid.",
                    "errors" => [
                        "comment_level" => [
                            "The comment level may not be greater than 3."
                        ]
                    ]
                ]);
    }
}
