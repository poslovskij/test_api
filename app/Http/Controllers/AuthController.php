<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
	public function register(Request $request)
	{
		// Валідація вхідних даних
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:8|confirmed',
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		// Створення нового користувача
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);

		// Генерація токена
		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json([
			'message' => 'User registered successfully',
			'token' => $token,
			'user' => $user,
		], 201);
	}

	public function login(Request $request)
	{
		// Валідація вхідних даних
		$validator = Validator::make($request->all(), [
			'email' => 'required|string|email',
			'password' => 'required|string',
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		// Перевірка користувача
		$user = User::where('email', $request->email)->first();

		if (!$user || !Hash::check($request->password, $user->password)) {
			return response()->json(['message' => 'Invalid credentials'], 401);
		}

		// Генерація токена
		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json([
			'message' => 'Login successful',
			'token' => $token,
			'user' => $user,
		], 200);
	}

	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();

		return response()->json([
			'message' => 'Logged out successfully',
		], 200);
	}
}
