<?php

namespace App\Http\Controllers;

use App\Helpers\ValidatorHelper;
use App\Models\TodoList;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TodoListController extends Controller
{

    private $user_model;
    private $todo_list_model;
    function __construct()
    {
        $this->user_model = new User();
        $this->todo_list_model = new TodoList();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todo_lists = $this->todo_list_model->all();
        return response()->json($todo_lists, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'list_name' => ['required', 'filled'],
            'todo_id' => ['required', 'exists:todos,id,user_id,' . $user->id]
        ];
        $validate = (new ValidatorHelper)->validate($request->all(), $rules);
        if ($validate !== true) {
            return $validate;
        }

        try {
            $user = Auth::user();
            $data = [
                'todo_id' => $request->todo_id,
                'list_name' => $request->list_name
            ];
            $user->todolists()->create($data);
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
     * Display the specified resource.
     *
     * @param  \App\Models\TodoList  $todo_list
     * @return \Illuminate\Http\Response
     */
    public function show($todo_list)
    {
        $todo_list = $this->todo_list_model->find($todo_list);
        return response()->json($todo_list, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TodoList  $todo_list
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $todo_list)
    {
        $user = Auth::user();
        $rules = [
            'list_name' => ['required', 'filled'],
            'todo_id' => ['required', 'exists:todos,id,user_id,' . $user->id]
        ];
        $validate = (new ValidatorHelper)->validate($request->all(), $rules);
        if ($validate !== true) {
            return $validate;
        }

        try {
            $user = Auth::user();
            $todo_list = $user->todolists()->findOrFail($todo_list);
            $data = [
                'list_name' => $request->list_name
            ];
            foreach ($data as $key => $value) {
                $todo_list->$key = $value;
            }

            $todo_list->save();

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
     * @param  \App\Models\TodoList  $todo_list
     * @return \Illuminate\Http\Response
     */
    public function destroy($todo_list)
    {
        try {
            $user = Auth::user();
            $todo_list = $user->todolists()->findOrFail($todo_list);

            $todo_list->delete();

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
