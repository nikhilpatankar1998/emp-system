<?php

use App\Http\Controllers\AuthController;
use App\Models\Screenshot;
use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Http\Controllers\ScreenshotController;

// Route::middleware('auth:sanctum')->post('/upload-screenshot', [ScreenshotController::class, 'storeScreenshot']);
// Route::post('/upload-screenshot', [ScreenshotController::class, 'storeScreenshot']);
// Route::middleware('auth')->post('/upload-screenshot', [ScreenshotController::class, 'storeScreenshot']);
Route::post('/login', [ScreenshotController::class, 'login'])->name('api.login');
// Route::middleware('web')->post('/upload-screenshot', [ScreenshotController::class, 'storeScreenshot']);

// Route::post('/upload-screenshot', function (Request $request) {
//     Log::info('Incoming Screenshot Upload Request', [
//         'form_data' => $request->all(),
//         'files' => $request->file(),
//     ]);
//     $file = $request->file('screenshot');

//     $originalName = $file->getClientOriginalName();
//     $filename = $originalName;

//     preg_match('/_(\d+)\.jpg$/', $filename, $matches);

//     $user_id = isset($matches[1]) ? (int)$matches[1] : 0;

//     // echo $user_id;
//     \Log::info('Uploaded Screenshot Filename: ' . $originalName);
    
   
//     $file = $request->file('screenshot');
//     // $path = $file->store('screenshots',$originalName, 'public');
//     //$path = $file->storeAs('screenshots', $originalName, 'public');
//     $path = $file->storeAs('public/screenshots', $originalName);


//     $screenshotId = DB::table('screenshots')->insertGetId([
//                     'user_id' => $user_id,
//                     'filename' => $filename,
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);

//     return response()->json(['message' => 'Upload successful', 'data' => $screenshotId]);
// });

Route::post('/upload-screenshot', function (Request $request) {
    Log::info('Incoming Screenshot Upload Request', [
        'form_data' => $request->all(),
        'files' => $request->file(),
    ]);

    $file = $request->file('screenshot');
    $originalName = $file->getClientOriginalName();
    $filename = basename($originalName); // ✅ get only the name

    // Extract user id from filename suffix
    preg_match('/_(\d+)\.jpg$/', $filename, $matches);
    $user_id = isset($matches[1]) ? (int)$matches[1] : 0;

    // Detect type
    $type = Str::startsWith($filename, 'webcam_') ? 'webcam' : 'screenshot';

    \Log::info("Uploaded {$type} Filename: " . $filename);

    // Store file
    $path = $file->storeAs('screenshots', $filename, 'public');

    // Save in DB
    $screenshotId = DB::table('screenshots')->insertGetId([
        'user_id'   => $user_id,
        'filename'  => $filename,
        'type'      => $type,
        'created_at'=> now(),
        'updated_at'=> now(),
    ]);

    return response()->json([
        'message' => ucfirst($type) . ' upload successful',
        'data'    => $screenshotId,
        'type'    => $type,
    ]);
});


Route::middleware('auth:sanctum')->get('/get-screenshot-token', function () {
    $user = Auth::user();
    if ($user) {
        return response()->json([
            'token' => $user->createToken('screenshot-token')->plainTextToken,
            'user_id' => $user->id,
        ]);
    }

    return response()->json(['error' => 'Unauthenticated'], 401);
});
