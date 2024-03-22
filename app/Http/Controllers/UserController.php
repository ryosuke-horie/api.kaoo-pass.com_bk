<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * ユーザー情報一覧を返すAPI
     */
    public function index(): JsonResponse
    {
        return response()->json(['message' => 'hello']);
    }
}
