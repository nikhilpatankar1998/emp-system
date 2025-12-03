<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ScreenshotController extends Controller
{


public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    // if ($user && Hash::check($request->password, $user->password)) {
        if ($user && $request->password === $user->password) {
        Auth::login($user);

        // Create Sanctum token
        $token = $user->createToken('screenshot-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user_id' => $user->id,
        ]);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
}


// public function login(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     $user = User::where('email', $request->email)->first();

//     // NOTE: Use Hash::check if passwords are hashed
//     if ($user && $request->password === $user->password) {
//         Auth::login($user);

//         // Optional: Create token, even if you're not going to use it
//         $token = $user->createToken('screenshot-token')->plainTextToken;
//         // Session::put('screenshot_token', $token);
//         session(['screenshot_token' => $token]);

//         // Always return JSON (for API usage like Python or Postman)
//         return response()->json([
//             'message' => 'Login successful',
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//             'user_id' => $user->id,
//             'role' => $user->role,
//             'name' => $user->name,
//         ]);
//     } else {
//         return response()->json([
//             'message' => 'Invalid credentials',
//         ], 401);
//     }
// }


public function storeScreenshot(Request $request)
{
    try {
        $request->validate([
            'screenshot' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $user = Auth::user();  // This will work based on session authentication
        $emp_id = optional($user)->id;
        \Log::info('Screenshot upload API hit', [
            'user_id' => $emp_id,
            'timestamp' => $request->timestamp
        ]);

        if (!$emp_id) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        if (!$request->hasFile('screenshot')) {
            return response()->json(['error' => 'No screenshot uploaded'], 400);
        }
        $file = $request->file('screenshot');
        $timestamp = now()->format('Ymd_His');
        $filename = 'screenshot_' . $emp_id . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
        // $path = $request->file('screenshot')->storeAs('public/screenshots', $filename);
        $file->storeAs('public/screenshots', $filename);
        $emp_id = Auth::id();
        $screenshotId = DB::table('screenshots')->insertGetId([
            'user_id' => $emp_id,
            'filename' => $filename,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \Log::info('Screenshot uploaded', [
            'user' => $user,
            'has_file' => $request->hasFile('screenshot'),
            'file' => $request->file('screenshot')->getClientOriginalName(),
        ]);

        return response()->json([
            'message' => 'Screenshot uploaded successfully.',
            'screenshot_id' => $screenshotId,
            'file_path' => $filename,
        ], 200);
    } catch (\Exception $e) {
        \Log::error('Screenshot upload failed', [
            'error' => $e->getMessage(),
        ]);
        return response()->json([
            'error' => 'Server error occurred during screenshot upload.',
            'message' => $e->getMessage()
        ], 500);
    }
}

}
