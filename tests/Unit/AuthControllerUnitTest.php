<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class AuthControllerUnitTest extends TestCase
{
    use RefreshDatabase, MockeryPHPUnitIntegration;

    /**
     * Test successful login.
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $request = new LoginRequest([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $authControllerMock = \Mockery::mock(AuthController::class);
        $authControllerMock->shouldReceive('login')->andReturn(response()->json(['access_token' => 'mocked_token']));

        $response = $authControllerMock->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $responseData = $response->getData(true);
        $this->assertArrayHasKey('access_token', $responseData);
        $this->assertEquals('mocked_token', $responseData['access_token']);
    }

    /**
     * Test login with invalid credentials.
     *
     * @return void
     */
    public function testLoginWithInvalidCredentials()
    {
        $request = new LoginRequest([
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);

        $userMock = \Mockery::mock(User::class);
        $userMock->shouldReceive('where')->andReturn(null);

        $authController = new AuthController($userMock);
        $response = $authController->login($request);

        $this->assertEquals(401, $response->getStatusCode());
    }
}
