<?php
namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Laravel\Socialite\Facades\Socialite;
use Inertia\Testing\AssertableInertia as Assert;

class LoginTest extends TestCase
{
    private function mock_socialite()
    {
        $user = Mockery::mock('Laravel\Socialite\Two\User');

        $user
            ->shouldReceive('getId')
            ->andReturn(rand())
            ->shouldReceive('getNickName')
            ->andReturn(uniqid())
            ->shouldReceive('getName')
            ->andReturn(uniqid())
            ->shouldReceive('getEmail')
            ->andReturn(uniqid() . '@gmail.com')
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')
            ->andReturn($user);

        Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($provider);

        $this->get('/login/google/callback');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unauthenticated_user_can_view_login_page()
    {
        $this->get('/login')->assertInertia(fn (Assert $page) => $page
            ->component('Login'));
    }

    public function test_unauthenticated_user_cannot_visit_dashboard_route()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_user_can_login_with_google_account()
    {
        $this->mock_socialite();
        $this->get('/')->assertLocation('/')->assertStatus(200);
    }

    public function test_user_can_view_dashboard_page()
    {
        $this->mock_socialite();
        $this->get('/')->assertInertia(fn (Assert $page) => $page
            ->component('Dashboard'));
    }

    public function test_authenticated_user_can_logout()
    {
        $this->mock_socialite();

        $response = $this->post('/logout');
        $response->assertRedirect('/login')->assertLocation('/login');
    }
}
