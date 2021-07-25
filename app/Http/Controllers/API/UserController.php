<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response(UserResource::collection($users), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_array($request->name)) {
            $rules = [
                //"name" => "required|array",
                "name.*" => "required",
                //"email" => "required|array",
                "email.*" => "required|email|unique:users,email",
                //"password" => "required|array",
                "password.*" => "required",
            ];
            $validatedUsers = $request->validate($rules);
            $keys = array_keys($validatedUsers);
            $created_user = array();
            $users = array();
            for ($j = 0; $j < count($validatedUsers[$keys[0]]); $j++) {
                for ($i = 0; $i < count($validatedUsers); $i++) {
                    if($keys[$i] == 'password')
                    {
                        $created_user[$keys[$i]] = Hash::make($validatedUsers[$keys[$i]][$j]);
                    }else {
                        $created_user[$keys[$i]] = $validatedUsers[$keys[$i]][$j];
                    }
                }
                $user = User::create($created_user);
                array_push($users, $user);
            }
            return response(UserResource::collection($users), Response::HTTP_CREATED);
        } else if ($request->users) {
            $rules = [
                'users' => 'array',
                'users.*.name' => 'required',
                'users.*.email' => 'required|email|unique:users',
                'users.*.password' => 'required',
            ];
            $validatedUsers = $request->validate($rules);
            //dd($validatedUsers['users']);
            $users = array();
            foreach ($validatedUsers['users'] as $validatedUser) {
                //dd($validatedUser);
                $validatedUser['password'] = Hash::make($validatedUser['password']);
                $user = User::create($validatedUser);
                array_push($users, $user);
            }
            return response(UserResource::collection($users), Response::HTTP_CREATED);
        } else {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ];

            $request->validate($rules);

            $user = User::create($request->only('name', 'email') + ['password' => Hash::make($request->input('password'))]);
            return response(new UserResource($user), Response::HTTP_CREATED);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request,User $user)
    {
        $user->update($request->only('name','email')+ ['password' => Hash::make($request->input('password'))]);
        return response(new UserResource($user),Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
