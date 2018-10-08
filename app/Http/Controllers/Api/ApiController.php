<?php


namespace App\Http\Controllers\Api;


class ApiController
{
    public function success($data, $msg)
    {
        return $this->compact(200, $data, $msg);
    }

    public function error($data, $msg)
    {
        return $this->compact(400, $data, $msg);
    }

    private function compact($code, $data, $msg)
    {
        if (!$data) $data = [];
        return response()->json([
            'status' => $code,
            'data' => $data,
            'message' => $msg
        ]);
    }
}
