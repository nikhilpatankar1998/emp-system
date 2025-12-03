<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {

        return view('user.welcome');
    }
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('email', $request->email)->first();


    //     if ($user && $request->password === $user->password) {

    //         Auth::login($user);

    //         if ($user->role == 0) {
    //             return redirect()->route('admin.dashboard');
    //         } else {
    //             return redirect()->route('user.dashboard');
    //         }
    //     } else {

    //         return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    //     }
    // }

    // **************************************************
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && $request->password === $user->password) {
        Auth::login($user);

        // Create Sanctum token
        $token = $user->createToken('screenshot-token')->plainTextToken;
        Session::put('screenshot_token', $token);
        // Return JSON if expecting API login (e.g., from Postman, Python, React, etc.)
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user_id' => $user->id,
                'role' => $user->role,
            ]);
        }
        // dd($token);

        // Handle regular web redirect
         // return $user->role == 0
        //     ? redirect()->route('admin.dashboard')
        //     : redirect()->route('user.dashboard');
            if ($user->role == 0) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 1) {
            return redirect()->route('user.dashboard');
        } elseif ($user->role == 2) {
            return redirect()->route('projectmanager-dashboard');
        } elseif ($user->role == 3) {
            return redirect()->route('hr.dashboard');
        } else {
            Auth::logout();
            return back()->withErrors(['email' => 'Invalid role'])->withInput();
        }
    } else {
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }
}
// *****************************************************
//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required',
//         ]);

//         $user = User::where('email', $request->email)->first();

//         if ($user && $request->password === $user->password) {
//             Auth::login($user);

//             // ✅ User ID ko cache me store karein (logout tak)
//             Cache::forever('current_logged_in_user', $user->id);
//             Log::info("User ID stored in cache: " . Cache::get('current_logged_in_user'));
//             // ✅ Agar admin nahi hai to screenshot command run karein
//             if ($user->role != 0) {
//                 $output = [];
//                 $result = null;
               
//             // chdir("C:\\xampp\\htdocs\\DAILY-LOGS");
             
//             // pclose(popen("start /B C:\\xampp\\php\\php.exe artisan schedule:work", "r"));
//             //     Log::info("Scheduler Started: Result Code - " . $result);
//             //     Log::info("Output: " . implode("\n", $output));
//             }

//             return $user->role == 0 ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
//         } else {
//             return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
//         }
//     }

  
// // ******************************************


//     public function register()
//     {
//         $data = Project::get();
//         return view('user.register', compact('data'));
//     }

    // public function logout(Request $request)
    // {

    //     // ✅ User ID cache se remove karein
    //     Cache::forget('current_logged_in_user');

    //     $output = shell_exec('wmic process where "commandline like \'%schedule:work%\'" get ProcessId 2>&1');
    //     preg_match_all('/\d+/', $output, $matches);

    //     if (!empty($matches[0])) {
    //         foreach ($matches[0] as $pid) {
    //             shell_exec("taskkill /F /PID $pid");
    //         }
    //     }

    //     Auth::logout();
    //     $request->session()->flush();
    //     return redirect('/');
    // }


    public function logout(Request $request)
{
    $userId = Cache::get('current_logged_in_user');
    Cache::forget('current_logged_in_user'); // ✅ Remove user ID from cache

    // ✅ Stop running screenshot process (only for non-admin users)
    if ($userId) {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // ✅ Windows: Stop background process
            $output = shell_exec('wmic process where "commandline like \'%schedule:work%\'" get ProcessId 2>&1');
            preg_match_all('/\d+/', $output, $matches);
            if (!empty($matches[0])) {
                foreach ($matches[0] as $pid) {
                    shell_exec("taskkill /F /PID $pid");
                }
            }
        } else {
            // ✅ Linux/macOS: Stop background process
            exec("pkill -f 'php artisan schedule:work'");
        }

        Log::info("🛑 Screenshot tracking stopped for User ID: $userId");
    }

    Auth::logout();
    $request->session()->flush();
    return redirect('/');
}

}
