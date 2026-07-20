<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiAccessToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string'], 'name' => ['nullable', 'string', 'max:100']]);
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Kredensial tidak valid.'], 422);
        }
        $plain = Str::random(64);
        $token = ApiAccessToken::create(['user_id' => $user->id, 'name' => $data['name'] ?? 'frontend', 'token_hash' => hash('sha256', $plain), 'expires_at' => now()->addDays(30)]);
        return response()->json(['data' => ['token' => $plain, 'token_type' => 'Bearer', 'expires_at' => $token->expires_at->toIso8601String()]], 201);
    }
}
