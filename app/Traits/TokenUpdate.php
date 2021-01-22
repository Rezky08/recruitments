<?php

/**
 *
 */
trait TokenUpdate
{
    public function update(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return response()->json(['token' => $token], 200);
    }
}
