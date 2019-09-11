<?php


namespace Tests\Feature\Members;


use Tests\Feature\ParentTestRoute;

class GetAnMemberTest extends ParentTestRoute
{
    public function testGetMemberSuccessfully()
    {
        $this->json('GET', "api/members", [])
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [['id',
                'name',
                'email',
                'created_at'
            ]]]);

        $this->json('GET', "api/members", [
            'per_page' => 0
        ])
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [['id',
                'name',
                'email',
                'created_at'
            ]]]);
    }
}
