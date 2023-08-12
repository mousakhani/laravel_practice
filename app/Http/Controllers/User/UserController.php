<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            //unique:users
            // جمله ی بالا به این معنی است که همه ی ایمیل ها را  برای همه ی یوزر ها غیر از
            // یوزر جاری یونیک در نظر بگیر
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);
        // dd($user);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['data' => 'User ' . $id . ' not found', "code" => 404], 404);
        }
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['data' => 'User ' . $id . ' not found', "code" => 404], 404);
        }
        $validator = Validator::make($request->all(), [
            // template: email:unique:table_name,column,except,idColumn
            //اخرین مقدار نام ستون ایدی است. اگر نام ستون ایدی غیر ایدی باشد، از این گزینه استفاده می کنیم
            //https://laravel.com/docs/5.2/validation#rule-unique
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'confirmed|min:6',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ]);

        if ($validator->failed()) {
            return response()->json([
                'data' => $validator->messages()
            ], 400);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('admin')) {
            if (!$user->verified) {
                return response()->json(['message' => 'Only verified users can modify the admin field', 'code' => 409], 409);
            }
            $user->admin = $request->admin;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }



        if (!$user->isDirty()) {
            return response()->json(['message' => 'You need to specify a different value to update', 'code' => 422], 422);
        }

        $user->save();
        return response()->json(['data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['data' => 'User ' . $id . ' not found', "code" => 404], 404);
        }
        $user->delete();
        return response()->json(['data' => $user, 'code' => 200], 200);
    }
}
