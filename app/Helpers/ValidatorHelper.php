<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;

class ValidatorHelper
{
    public function validate($data, $rules, $message = [])
    {
        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            $response = [
                'ok' => false,
                'message' => $validator->errors()->first()
            ];
            return response()->json($response, 400);
        }
        return true;
    }
}
