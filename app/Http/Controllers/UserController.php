<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia("Users/Index", [
            "initialSearch" => request("search"),
            "users" => User::filter(request()->only("search"))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(
                    fn($user) => [
                        "id" => $user->id,
                        "name" => $user->name,
                        "username" => $user->username,
                        "role" => $user->role->name,
                        "role_id" => $user->role_id,
                        "status" => $user->status,
                    ]
                ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return inertia("Users/Create", [
            "roles" => Role::whereNotIn("id", [1])
                ->get()
                ->transform(
                    fn($role) => [
                        "label" => $role->name,
                        "value" => $role->id,
                    ]
                ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());

        return back()->with("success", __("messages.success.store.user"));
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Inertia\Response
     */
    public function show(User $user)
    {
        return inertia("Users/Show", [
            "user" => $user,
            "roles" => Role::whereNotIn("id", [1])
                ->get()
                ->transform(
                    fn($role) => [
                        "label" => $role->name,
                        "value" => $role->id,
                    ]
                ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        return inertia("Users/Edit", [
            "user" => [
                "id" => $user->id,
                "name" => $user->name,
                "username" => $user->username,
                "role_id" => $user->role_id,
                "status" => $user->getRawOriginal("status"),
            ],
            "roles" => Role::whereNotIn("id", [1])
                ->get()
                ->transform(
                    fn($role) => [
                        "label" => $role->name,
                        "value" => $role->id,
                    ]
                ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return back()->with("success", __("messages.success.update.user"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route("users.index")->with(
            "success",
            __("messages.success.destroy.user")
        );
    }

    /**
     * Block user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function block(User $user)
    {
        $user->status = !$user->getRawOriginal("status");
        $user->update();

        if ($user->getRawOriginal("status")) {
            $msg = __("messages.user.active_user");
        } else {
            $msg = __("messages.user.no_active_user");
        }

        return back()->with("success", $msg);
    }

    /**
     * Change Password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        if (!Hash::check($request->old_password, $request->user()->password)) {
            return back()->with(
                "error",
                __("messages.error.store.change_password")
            );
        }

        $request
            ->user()
            ->update(["password" => bcrypt($request->new_password)]);

        return back()->with(
            "success",
            __("messages.success.update.change_password")
        );
    }

    public function resetPassword(User $user)
    {
        $user->update(["password" => bcrypt("12345678")]);

        return back()->with(
            "success",
            __("messages.success.store.reset_password")
        );
    }
}
