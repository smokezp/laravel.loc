<?php


namespace App\Http\Controllers\Api;


class ApiController
{
    public function success($data = [])
    {
        return $this->compact(200, $data);
    }

    public function error($data = [])
    {
        return $this->compact(400, $data);
    }

    private function compact($code, $data)
    {
        return response()->json($data, $code);
    }
}
