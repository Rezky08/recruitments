<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{

    private $user_model;
    function __construct()
    {
        $this->user_model = new User();
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'filled', 'exists:users,email'],
            'password' => ['required', 'filled']
        ];
        $messages = [
            'email.exists' => 'username or password is invalid'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response = [
                'ok' => false,
                'message' => $validator->errors()->first()
            ];
            return response()->json($response, 400);
        }

        $user = $this->user_model->where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            $response = [
                'ok' => false,
                'message' => 'username or password is invalid'
            ];
            return response()->json($response, 400);
        }

        Auth::setUser($user);
        return $this->update($request);
    }

    public function update(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return response()->json(['token' => $token], 200);
    }
}
