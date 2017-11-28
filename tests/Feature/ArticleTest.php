<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Article;

class ArticleTest extends TestCase
{
    public function testArticleAreCreatedCorrectly(){
        $user = factory(User::class)->create();
        $token = $user->generateToken();   
        $headers = ['Authorization' => "Bearer $token"];        

        
        $payload = [
            'title' => 'Lorem',
            'body' => 'Ipsum'
        ];

        $this->json('POST', 'api/articles', $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'title' => 'Lorem',
                'body' => 'Ipsum'
            ]);
    }

    public function testArticlesAreUpdatedCorrectly(){
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $articleCreated = factory(Article::class)->create();

        $payload = [
            'title' => 'updated working',
            'body' => 'the body'
        ];

        $this->json('PUT', 'api/articles/'.$articleCreated->id , $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'title' => 'updated working',
                'body' => 'the body'
            ]);
        

    }

    public function testArticlesAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $articleCreated = factory(Article::class)->create();

        $this->json('DELETE', 'api/articles/'.$articleCreated->id, [], $headers)
            ->assertStatus(204);
    }

    public function testArticlesAreListedCorrectly(){
        $articleOne = factory(Article::class)->create();
        $articleTwo = factory(Article::class)->create();

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', 'api/articles', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                $articleOne->toArray(), 
                $articleTwo->toArray()
            ])
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'body',
                    'created_at',
                    'updated_at',
                ]
            ]);

    }
}
