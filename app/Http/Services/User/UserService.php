<?php

namespace App\Http\Services\User;

// use Illuminate\Support\Facades\Auth;
// use App\Http\Requests\User\UserCreateRequest;
// use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Repositories\User\UserRepository;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {}

    public function index()
    {
        return $this->userRepository->findAll();
    }

    // public function store(UserCreateRequest $request)
    // {
    //     Auth::guard('api');
    //     return $this->userRepository->create($request->validated());
    // }

    // public function update($id, UserUpdateRequest $request)
    // {
    //     Auth::guard('api');
    //     return $this->userRepository->update($id, $request->validated());
    // }
}
