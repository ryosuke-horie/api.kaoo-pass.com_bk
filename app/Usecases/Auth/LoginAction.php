<?php

namespace App\Usecases\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function __construct()
    {
    }

    /**
     * ログイン
     *
     * @return string $token
     */
    public function __invoke(LoginRequest $request): string
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // ログイン処理
        if (! Auth::attempt(['email' => $email, 'password' => $password])) {
            return '';
        }
        $user = Auth::user();
        if ($user === null) {
            return '';
        }

        /**
         * @var string $tokenName
         */
        $tokenName = $request->has('token_name') ? $request->token_name : 'AccessToken';

        return $user->createToken($tokenName)->plainTextToken;
    }
}
