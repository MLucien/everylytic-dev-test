<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Repositories\UserRepository;
use App\Http\Controllers\UserListing;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mockery;

class UserListingTest extends TestCase
{
    protected $userRepository;
    protected $userListing;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->userListing = new UserListing($this->userRepository);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testIndex()
    {
        $users = [
            (object) ['name' => 'John Doe', 'email' => 'john@example.com'],
            (object) ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
        ];

        $this->userRepository->shouldReceive('all')->once()->andReturn($users);
        $view = $this->userListing->index();

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('users.index', $view->getName());
        $this->assertArrayHasKey('users', $view->getData());
        $this->assertEquals($users, $view->getData()['users']);
    }

    public function testCreate()
    {
        $view = $this->userListing->create();

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('users.create', $view->getName());
    }

    public function testStore()
    {
        $request = Mockery::mock(Request::class);
        $requestData = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $this->userRepository->shouldReceive('create')->once()->with($requestData);
        $redirectResponse = $this->userListing->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $redirectResponse);
        $this->assertEquals('users.index', $redirectResponse->getTargetUrl());
        $this->assertContains('User created successfully', $redirectResponse->getSession()->get('success'));
    }

    public function testShow()
    {
        $userId = 1;
        $user = (object) ['name' => 'John Doe', 'email' => 'john@example.com'];
        $this->userRepository->shouldReceive('find')->once()->with($userId)->andReturn($user);
        $view = $this->userListing->show($userId);

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('users.show', $view->getName());
        $this->assertArrayHasKey('user', $view->getData());
        $this->assertEquals($user, $view->getData()['user']);
    }

    public function testEdit()
    {
        $userId = 1;
        $user = (object) ['name' => 'John Doe', 'email' => 'john@example.com'];
        $this->userRepository->shouldReceive('find')->once()->with($userId)->andReturn($user);
        $view = $this->userListing->edit($userId);

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('users.edit', $view->getName());
        $this->assertArrayHasKey('user', $view->getData());
        $this->assertEquals($user, $view->getData()['user']);
    }

    public function testUpdate()
    {
        $request = Mockery::mock(Request::class);
        $userId = 1;
        $requestData = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $this->userRepository->shouldReceive('update')->once()->with($userId, $requestData);
        $redirectResponse = $this->userListing->update($request, $userId);

        $this->assertInstanceOf(RedirectResponse::class, $redirectResponse);
        $this->assertEquals('users.index', $redirectResponse->getTargetUrl());
        $this->assertContains('User updated successfully', $redirectResponse->getSession()->get('success'));
    }

    public function testDestroy()
    {
        $userId = 1;
        $this->userRepository->shouldReceive('delete')->once()->with($userId);
        $redirectResponse = $this->userListing->destroy($userId);

        $this->assertInstanceOf(RedirectResponse::class, $redirectResponse);
        $this->assertEquals('users.index', $redirectResponse->getTargetUrl());
        $this->assertContains('User deleted successfully', $redirectResponse->getSession()->get('success'));
    }
}
