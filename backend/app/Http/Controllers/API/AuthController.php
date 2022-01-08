<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login api
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->token = $user->createToken('uwdc')->accessToken;

            return response()->json(['message' => 'User successfully logged in!', 'data' => $user], 200);
        }


        return response()->json(['message' => 'Email or password not correct'], 403);
    }


}
