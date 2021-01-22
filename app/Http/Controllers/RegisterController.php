<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function index()
    {
        $data = [
            'title' => "API Register"
        ];
        return view('register', $data);
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'filled'],
            'email' => ['required', 'filled', 'unique:users,email'],
            'password' => ['required', 'filled', 'confirmed']
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
            (new User)->create($data);

            $response = [
                'success' => "account has been created"
            ];
            return redirect('/')->with($response);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'error' => "server error 500"
            ];
            return redirect('/')->with($response);
        }
    }
}
