<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $title = 'User List';
        $data = $this->userService->getAllUsers();
        return view('pages.users.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = 'Create User';
        $roles = ['admin', 'staff', 'lecturer', 'student'];
        return view('pages.users.create', compact('title', 'roles'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt('password');
        $this->userService->create($data);
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $title = 'Edit User';
        $roles = ['admin', 'staff', 'lecturer', 'student'];
        return view('pages.users.edit', compact('title', 'user', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $this->userService->update($user, $data);
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $this->userService->destroy($user);
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
