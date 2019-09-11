<?php


namespace Tests\Feature\Members;


use Tests\Feature\ParentTestRoute;

class PostAnMemberTest extends ParentTestRoute
{
    public function testMissingParameter()
    {
        $this->json('POST', 'api/members', [])
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => [
                'name',
                'email'
            ]]);
    }

    public function testStoreMemberSuccessfully()
    {
        $this->json('POST', 'api/members', [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ])
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'email']);
    }
}
