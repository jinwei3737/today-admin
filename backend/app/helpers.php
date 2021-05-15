<?php

if (!function_exists('apiReturn')) {
    /**
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return object
     */
    function apiReturn(array $data = [], string $msg = "success", int $code = 200): object
    {
        return response()->json(compact('code', 'msg', 'data'));
    }
}