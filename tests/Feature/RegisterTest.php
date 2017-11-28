<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    
    public function testRegisterSuccessfully() 
    {
        $payload = [
            'name' => 'Sergio',
            'email' => 'acad.sergio@gmail.com',
            'password' => 'sergio123',
            'password_confirmation' => 'sergio123'
        ];  

        $this->json('POST', 'api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token'
                ]
            ]);
    }

    public function testRequirePasswordEmailAndName(){

        $this->json('POST', 'api/register')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ],
            ]);
    }

    public function testRequirePasswordConfirmation(){
        $payload = [
            'name' => 'John',
            'email' => 'john@toptal.com',
            'password' => 'toptal123'
        ];

        $this->json('POST', 'api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['The password confirmation does not match.']                
                ]
            ]);

    }
}
