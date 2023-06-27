<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserListing extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // // Display a listing of the users
    // public function index()
    // {
    //     $users = $this->userRepository->all();
    //     return view('users.index', compact('users'));
    // }
    // Display a listing of the users
    public function index()
    {
    $users = $this->userRepository->all();
    return view('users.index', ['users' => $users]);
    }


    // Show the form for creating a new user
    public function create()
    {
        return view('users.create');
    }

    // Store a newly created user in the database
    public function store(Request $request)
    {

        $this->userRepository->create($request->all());

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    // Display the specified user
    public function show($id)
    {
        $user = $this->userRepository->find($id);
        return view('users.show', compact('user'));
    }

    // Show the form for editing the specified user
    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        return view('users.edit', compact('user'));
    }

    // Update the specified user in the database
    public function update(Request $request, $id)
    {
        $this->userRepository->update($id, $request->all());

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    // Remove the specified user from the database
    public function destroy($id)
    {
        $this->userRepository->delete($id);

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
