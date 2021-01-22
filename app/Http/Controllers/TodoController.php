<?php

namespace App\Http\Controllers;

use App\Helpers\ValidatorHelper;
use App\Models\Todo;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{

    private $user_model;
    private $todo_model;
    function __construct()
    {
        $this->user_model = new User();
        $this->todo_model = new Todo();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todo_model->all();
        return response()->json($todos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'todo_name' => ['required', 'filled']
        ];
        $validate = (new ValidatorHelper)->validate($request->all(), $rules);
        if ($validate !== true) {
            return $validate;
        }

        try {
            $user = Auth::user();

            $data = [
                'todo_name' => $request->todo_name
            ];
            $user->todos()->create($data);
            $response = [
                'ok' => true,
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'ok' => true,
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return response()->json($todo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $todo)
    {

        $rules = [
            'todo_name' => ['required', 'filled']
        ];
        $validate = (new ValidatorHelper)->validate($request->all(), $rules);
        if ($validate !== true) {
            return $validate;
        }

        try {
            $user = Auth::user();
            $todo = $user->todos()->findOrFail($todo);

            $data = [
                'todo_name' => $request->todo_name
            ];

            foreach ($data as $key => $value) {
                $todo->$key = $value;
            }
            $todo->save();

            $response = [
                'ok' => true,
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'ok' => false,
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($todo)
    {
        try {
            $user = Auth::user();
            $todo = $user->todos()->findOrFail($todo);

            $todo->delete();

            $response = [
                'ok' => true,
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'ok' => false,
            ];
            return response()->json($response, 200);
        }
    }
}
