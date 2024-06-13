<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
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

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        try {
            $this->user->create($request);
            Toastr::success('User created successfully');

            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            Toastr::error('User failed to create');

            return redirect()->route('users.create');
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

    public function destroy(User $id)
    {
        try {
            $this->user->delete($id);
            Toastr::success('User deleted successfully');

            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            Toastr::error('User failed to delete');

            return redirect()->route('users.index');
        }
    }
}
