<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\EnsureApiKeyIsValid;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnsureApiKeyIsValidMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the middleware allows requests with a valid API key.
     *
     * @return void
     */
    public function test_valid_api_key()
    {
        $request = Request::create('/test', 'GET');
        $request->headers->set('X-API-KEY', 'your-secret-api-key');

        $middleware = new EnsureApiKeyIsValid();

        $response = $middleware->handle($request, function ($req) {
            return response('Passed middleware', 200);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Passed middleware', $response->getContent());
    }

    /**
     * Test that the middleware blocks requests with an invalid API key.
     *
     * @return void
     */
    public function test_invalid_api_key()
    {
        $request = Request::create('/test', 'GET');
        $request->headers->set('X-API-KEY', 'invalid-api-key');

        $middleware = new EnsureApiKeyIsValid();

        $response = $middleware->handle($request, function ($req) {
            return response('Passed middleware', 200);
        });

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Invalid API Key']),
            $response->getContent()
        );
    }

    /**
     * Test that the middleware blocks requests without an API key.
     *
     * @return void
     */
    public function test_missing_api_key()
    {
        $request = Request::create('/test', 'GET'); 

        $middleware = new EnsureApiKeyIsValid();

        $response = $middleware->handle($request, function ($req) {
            return response('Passed middleware', 200);
        });

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Invalid API Key']),
            $response->getContent()
        );
    }
}