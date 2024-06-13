<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('users.index', ['users' => $this->user->getAll()]);
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $this->user->findById($user)]);
    }

    public function store(UserRequest $request)
    {
        $validate = $request->validated();
        try {
            $this->user->storeData($validate);
            Toastr::success('User created successfully');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            Toastr::error('User failed to create');
            return redirect()->route('users.index');
        }
    }

    public function edit(User $id)
    {
        return view('users.edit', ['user' => $this->user->findById($id)]);
    }

    public function update(Request $request, User $id)
    {
        try {
            $this->user->updateData($request, $id);
            Toastr::success('User updated successfully');

            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            Toastr::error('User failed to update');

            return redirect()->route('users.edit', $id);
        }
    }

    public function destroy(User $user)
    {
        try {
            $this->user->delete($user->id);
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'User failed to delete'], 500);
        }
    }
}
