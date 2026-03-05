<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Handles user registration by validating input, creating a new user, and hashing the password.
     * Redirects to login with a success message upon successful registration.
     * Returns back with validation errors or exception messages if registration fails.
     */
    public function registerUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if ($user) {
                return redirect('/login')->with('success', 'User registered successfully. Please login.');
            }
            return back()->with('error', 'Something went wrong. Please try again.');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Handles user login by validating credentials and attempting authentication.
     * Regenerates session on successful login and redirects to the dashboard.
     * Returns back with an error message if authentication fails.
     */
    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $validator->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Successfully logged out.');
    }

    public function dashboard()
    {
        $user = auth()->user();
        return view('dashboard', compact('user'));
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'status'       => 1,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user'         => auth('api')->user()
        ]);
    }
}
