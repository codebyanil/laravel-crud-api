<?php


namespace Tests\Feature;


use Tests\TestCase;

class ParentTestRoute extends TestCase
{
    protected $invalidId = 124545999;

    protected function assertSuccess($response, int $code = 200)
    {
        // check for default 200 response code.
        $this->assertIsNumeric(200, $response->getStatusCode());
        $content = json_decode($response->content());
        // check for inner status code.
        $this->assertIsNumeric($code, $content->code);
        $this->assertObjectHasAttribute('status', $content);
        $this->assertTrue(true, $content->status);
    }

    protected function assertFailure($response, int $code = 500)
    {
        $this->assertIsNumeric(200, $response->getStatusCode());
        $content = json_decode($response->content());
        // check for inner status code.
        $this->assertIsNumeric($code, $content->code);
        $this->assertObjectHasAttribute('status', $content);
        $this->assertFalse(false, $content->status);
    }

}
