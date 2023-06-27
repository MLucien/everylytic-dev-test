<?php

namespace Tests\Repositories;

use Tests\TestCase;
use App\Repositories\UserRepository;
use App\User;

class UserRepositoryTest extends TestCase
{
    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository(new User());
    }

    public function testAll()
    {
        // Create some dummy users
        User::factory()->count(5)->create();

        // Retrieve all users using the repository
        $users = $this->userRepository->all();

        // Assert that the returned users count matches the expected count
        $this->assertCount(5, $users);
    }

    public function testFind()
    {
        // Create a dummy user
        $user = User::factory()->create();

        // Retrieve the user using the repository
        $foundUser = $this->userRepository->find($user->id);

        // Assert that the returned user matches the expected user
        $this->assertEquals($user->id, $foundUser->id);
        $this->assertEquals($user->name, $foundUser->name);
        // Add more assertions for other user properties as needed
    }

    public function testCreate()
    {
        // Create a dummy user data
        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            // Add other user data as needed
        ];

        // Create a new user using the repository
        $createdUser = $this->userRepository->create($userData);

        // Assert that the created user exists in the database
        $this->assertDatabaseHas('users', $userData);
        // Add more assertions for the created user properties as needed
    }

    public function testUpdate()
    {
        // Create a dummy user
        $user = User::factory()->create();

        // Update the user using the repository
        $updatedUser = $this->userRepository->update($user->id, ['name' => 'Updated Name']);

        // Assert that the user's name has been updated
        $this->assertEquals('Updated Name', $updatedUser->name);
        // Add more assertions for other updated user properties as needed
    }

    public function testDelete()
    {
        // Create a dummy user
        $user = User::factory()->create();

        // Delete the user using the repository
        $this->userRepository->delete($user->id);

        // Assert that the user no longer exists in the database
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
