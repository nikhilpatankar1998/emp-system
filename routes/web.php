<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalaryManagementController;
use App\Http\Controllers\UserController;
use App\Mail\LoginMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\HrController;
use App\Http\Controllers\ProjectManagerController;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\LoginMail;
use App\Http\Controllers\AIController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('user.welcome');
// });

Route::get('/download-app', function () {
    $userId = auth()->id();
    $sourceFile = public_path('download/ScreenshotApp.exe');

    if (file_exists($sourceFile)) {
        $customFileName = 'ScreenshotApp_' . $userId . '.exe';
        return response()->download($sourceFile, $customFileName);
    }

    abort(404, 'EXE file not found.');
})->middleware('auth'); // Only for logged-in users

Route::get('/download-app-v1', function () {
    $userId = auth()->id();
    $sourceFile = public_path('download/ScreenshotApp_v1.exe');

    if (file_exists($sourceFile)) {
        $customFileName = 'ScreenshotApp_v1' . $userId . '.exe';
        return response()->download($sourceFile, $customFileName);
    }

    abort(404, 'EXE file not found.');
})->middleware('auth'); // Only for logged-in users

Route::get('/', [AuthController::class, 'index'])->name('/');
Route::post('/loginpost', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout']);


//users routes.
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/addtask/{id}', [UserController::class, 'addtasks'])->name('addtasks');
    Route::get('/project-task/{id}', [UserController::class, 'projecttask'])->name('projecttask');
    Route::get('/updatetask/{id}', [UserController::class, 'updatetask'])->name('projecttask');
    Route::post('/task/update/{id}', [UserController::class, 'updateMyTask'])->name('updatemytask');
    Route::get('/addnew-task/{id}', [UserController::class, 'addNewTask'])->name('addnew-task');
    Route::post('/storetask/{id}', [UserController::class, 'storetask'])->name('storetask');
    Route::put('/task/update/{id}', [UserController::class, 'update'])->name('task.update');
    Route::get("/mytask", [UserController::class, 'mytask'])->name('mytask');
    Route::post('/check-in', [UserController::class, 'storeCheckIn']);
    Route::get('/check-in-status', [UserController::class, 'checkInStatus']);
    Route::post('/pause-time', [UserController::class, 'updatePausedTime']);
    Route::post('/checkout', [UserController::class, 'storeCheckOut']);
    Route::get('/dailyreports', [UserController::class, 'dailyreport']);
    Route::get('/applyleave', [UserController::class, 'applyleave']);
    Route::get('/leaveRecord', [UserController::class, 'leaveRecord']);
    Route::post('/postLeave', [UserController::class, 'postLeave'])->name('postLeave');
    Route::get('/monthlyreports', [UserController::class, 'monthlyreport']);
    Route::get('/my-profile-page', [UserController::class, 'profilepage'])->name('profile-page');
    Route::get('/chat-user-page', [ChatController::class, 'getuserchatpage'])->name('user.chat');
    Route::get('/chat-list', [ChatController::class, 'getuserchatlist'])->name('user.chatlist');
    Route::get('/getdocuments', [UserController::class, 'documentspage'])->name('getdocuments');
    Route::get('/getsalaryusers', [SalaryManagementController::class, 'salaryuserlist'])->name('getsalaryusers');
    Route::get('/genratesalary/{id}', [SalaryManagementController::class, 'genratesalary'])->name('genratesalary');
    // Route::get('/user/{id}/generate-salary', [SalaryManagementController::class, 'showGenerateForm'])
    //     ->name('salary.form');
    Route::post('/user/{id}/generate-salary', [SalaryManagementController::class, 'store'])
        ->name('salary.store');
    Route::get('/payslips', [SalaryManagementController::class, 'showAllPayslips'])->name('salary.list');
    Route::get('/employee/{id}/payslip/{salary_id}', [SalaryManagementController::class, 'viewPayslip'])->name('salary.view');
});

//admin routes
// Route::group(['middleware' => ['auth']], function () {
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/addemployee', [AdminController::class, 'adduser']);
    Route::post('/postemployee', [AdminController::class, 'postemployee']);
    Route::get('/addproject', [AdminController::class, 'addproject']);
    Route::post('/postprojects', [AdminController::class, 'postproject'])->name('post.project');
    Route::get('/employee', [AdminController::class, 'employee']);
    Route::get('/getCheckInData', [AdminController::class, 'getCheckInData']);
    Route::post('/getCheckInData/fetch', [AdminController::class, 'getCheckInData'])->name('getCheckInData.fetch');
    Route::get('/projectlist', [AdminController::class, 'projectlist']);
    Route::get('/editproject/{id}', [AdminController::class, 'editproject'])->name('editproject');
    Route::get('/viewproject/{id}', [AdminController::class, 'viewproject'])->name('viewproject');
    Route::post('/updateproject/{id}', [AdminController::class, 'updateproject'])->name('update.project');
    Route::put('/projects/{id}', [AdminController::class, 'update'])->name('updateproject');
    Route::get('/project-tasks/{id}', [AdminController::class, 'projecttask'])->name('projecttask');
    Route::get('/tasks-list/{id}', [AdminController::class, 'tasklist'])->name('tasklist');
    Route::post('/storetasks/{id}', [AdminController::class, 'storetasks'])->name('storetasks');
    Route::get('/taskreport', [AdminController::class, 'taskreport'])->name('taskreport');
    Route::post('/taskreport/fetch', [AdminController::class, 'taskreport'])->name('taskreport.fetch');
    Route::post('/update/{id}', [AdminController::class, 'updateEmployee'])->name('employee.update');
    Route::get('/edit/{id}', [AdminController::class, 'editEmployee'])->name('employee.edit');
    Route::get('/delete/{id}', [AdminController::class, 'deleteEmployee'])->name('employee.delete');
    Route::get('/leaveRequests', [AdminController::class, 'leaveRequests'])->name('leaveRequests');
    // Route::get('/viewTaskDetail', [AdminController::class, 'viewTaskDetail'])->name('viewTaskDetail');
    Route::get('/screenActivity', [AdminController::class, 'screenActivity'])->name('screenActivity');
    Route::get('/userActivity', [AdminController::class, 'userActivity'])->name('userActivity');
    Route::get('/screenshots/{id}', [AdminController::class, 'showScreenshot'])->name('user.activity');
    Route::get('/showUserActivity/{id}', [AdminController::class, 'showUserActivity'])->name('showUserActivity');
    Route::get('/screenshots-date/{id}', [AdminController::class, 'showScreenshot'])->name('admin.screenshots');
    Route::get('/profile-page', [AdminController::class, 'profilepage'])->name('profile-page');
    // Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::patch('/leaveRequests/approve/{id}', [AdminController::class, 'approveLeave'])->name('approveLeave');
    Route::patch('/leaveRequests/cancel/{id}', [AdminController::class, 'cancelLeave'])->name('cancelLeave');
    Route::get('/client-list', [AdminController::class, 'clientpage'])->name('clientlist');
    Route::get('/add-client', [AdminController::class, 'addclient'])->name('add-client');
    Route::post('/add-client', [AdminController::class, 'postclient'])->name('add-client');
    Route::get('/edit-client/{id}', [AdminController::class, 'editclient'])->name('edit-client');
    Route::post('/update-client/{id}', [AdminController::class, 'updateclient'])->name('update-client');
    Route::get('/chat', [ChatController::class, 'chatpage'])->name('chat');
    Route::post('/broadcast/store', [AdminController::class, 'storeBroadcast'])->name('broadcast.store');
    Route::delete('/broadcast/{id}', [AdminController::class, 'destroy'])->name('broadcast.destroy');
    Route::get('/leave-report', [AdminController::class, 'getleavepage'])->name('leave-report');
    Route::post('/leave-report/fetch', [AdminController::class, 'getLeaveReport'])->name('leavereport');
    Route::post('/allleave', [AdminController::class, 'get'])->name('allleave');
    Route::get('/get-leave-data', [AdminController::class, 'leaveDashboard'])->name('getLeaveData');
    Route::get('/documents', [AdminController::class, 'documents'])->name('documents');
    Route::get('/uploadDocument/{id}', [AdminController::class, 'uploadDocuments'])->name('uploadDocument');
    // Route::post('/postdocument', [AdminController::class, 'storeDocument'])->name('document.store');
    Route::get('/{id}/payslips', [SalaryManagementController::class, 'showAllUsersPayslips'])->name('user.payslips');
   // Route::get('/asktoai', [AdminController::class, 'asktoai'])->name('asktoai');

});


//HR ROUTES.
Route::middleware(['auth', 'hr'])->group(function () {
    Route::get('/hr-dashboard', [HrController::class, 'index'])->name('hr.dashboard');
    Route::get('/hr-addemployee', [HrController::class, 'adduser']);
    Route::post('/hr-postemployee', [HrController::class, 'postemployee']);
    Route::get('/hr-addproject', [HrController::class, 'addproject']);
    Route::post('/hr-postprojects', [HrController::class, 'postproject'])->name('hr.post.project');
    Route::get('/hr-employees', [HrController::class, 'employees']);
    Route::get('/hr-edit/{id}', [HrController::class, 'editEmployees'])->name('hr.employee.edit');
    Route::post('/hr-update/{id}', [HrController::class, 'updateEmployee'])->name('hr.employee.update');
    Route::post('/hr-postemployee', [HrController::class, 'postemployee']);
    Route::get('/hr-delete/{id}', [HrController::class, 'deleteEmployee'])->name('hr.employee.delete');
    Route::get('/hr-leave-report', [HrController::class, 'getleavepage'])->name('hr.leave-report');
    Route::post('/hr-leave-report/fetch', [HrController::class, 'getLeaveReport'])->name('hr.leavereport');
    Route::post('/hr-allleave', [HrController::class, 'get'])->name('allleave');
    Route::get('/hr-get-leave-data', [HrController::class, 'leaveDashboard'])->name('hr.getLeaveData');
    // Route::get('/chat', [ChatController::class, 'chatpage'])->name('chat');
    Route::get('/hr-leaveRequests', [HrController::class, 'leaveRequests'])->name('hr.leaveRequests');
    Route::patch('/hr-leaveRequests/approve/{id}', [HrController::class, 'approveLeave'])->name('hr.approveLeave');
    Route::patch('/hr-leaveRequests/cancel/{id}', [HrController::class, 'cancelLeave'])->name('hr.cancelLeave');
    Route::get('/hr-documents', [HrController::class, 'documents'])->name('hr.documents');
    Route::get('/hr-uploadDocument/{id}', [HrController::class, 'uploadDocuments'])->name('hr.uploadDocument');
    Route::get('/hr-getCheckInData', [HrController::class, 'getCheckInData']);
    Route::post('/hr-getCheckInData/fetch', [HrController::class, 'getCheckInData'])->name('hr.getCheckInData.fetch');
    Route::get('/hr-getsalaryusers', [HrController::class, 'salaryuserlist'])->name('hr.getsalaryusers');
    Route::get('/hr-genratesalary/{id}', [HrController::class, 'genratesalary'])->name('hr.genratesalary');
    // Route::get('/user/{id}/generate-salary', [SalaryManagementController::class, 'showGenerateForm'])
    //     ->name('salary.form');
    Route::post('/hr-user/{id}/generate-salary', [HrController::class, 'store'])
        ->name('hr.salary.store');
    Route::get('/hr-payslips', [HrController::class, 'showAllPayslips'])->name('hr.salary.list');
    Route::get('/hr-employee/{id}/payslip/{salary_id}', [HrController::class, 'viewPayslip'])->name('hr.salary.view');
    Route::get('/{id}/payslips', [HrController::class, 'showAllUsersPayslips'])->name('hr.payslips');
});

//Project manager routes.
Route::middleware(['auth', 'project_manager'])->group(function () {
    Route::get('/projectmanager-dashboard', [ProjectManagerController::class, 'index'])->name('projectmanager-dashboard');
    Route::get('/add-project', [ProjectManagerController::class, 'add-project'])->name('add-project');
    // Route::get('/project-list', [ProjectManagerController::class, 'viewProject'])->name('project-list');
    Route::get('/project-list', [ProjectManagerController::class, 'projectlists'])->name('project-list');
    Route::get('/addprojects', [ProjectManagerController::class, 'addprojects'])->name('addprojects');
    Route::post('/storeproject', [ProjectManagerController::class, 'storeproject'])->name('storeproject');
    Route::get('/viewprojects/{id}', [ProjectManagerController::class, 'viewprojects'])->name('viewprojects');
    Route::get('/editprojects/{id}', [ProjectManagerController::class, 'editprojects'])->name('editprojects');
    Route::post('/updateprojects/{id}', [ProjectManagerController::class, 'updateprojects'])->name('update.projects');
    Route::put('/project-update/{id}', [ProjectManagerController::class, 'updateProject'])->name('update-projects');
    Route::get('/myteam', [ProjectManagerController::class, 'myteam'])->name('myteam');
    Route::get('/projectTask', [ProjectManagerController::class, 'projectTask'])->name('projectTask');
    Route::post('/taskreport/search', [ProjectManagerController::class, 'taskreportsearch'])->name('taskreport.search');

});


// chat controller Routes.
Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages']);
Route::post('/chat/send', [ChatController::class, 'sendMessage']);
Route::get('/chat/unread-counts', [ChatController::class, 'getUnreadCounts']);
Route::post('/chat/mark-as-read/{senderId}', [ChatController::class, 'markAsRead']);
Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount']);
Route::get('/chat/group/messages', [ChatController::class, 'getGroupMessages']);
Route::post('/chat/group/send', [ChatController::class, 'sendGroupMessage']);
Route::get('/chat/latest-message', [ChatController::class, 'latestMessage']);
Route::post('/postdocument', [AdminController::class, 'storeDocument'])->name('document.store');

Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
Route::get('/user/{id}/generate-salary', [SalaryManagementController::class, 'showGenerateForm'])->name('salary.form');
Route::get('/salary/{userId}/{salaryId}/download', [SalaryManagementController::class, 'downloadPayslip'])->name('salary.download');

Route::get('/asktoai', [AIController::class, 'asktoai'])->name('asktoai');
Route::post('/ai/send-text', [AIController::class, 'sendText'])->name('ai.sendText');
Route::post('/send-voice', [AIController::class, 'sendVoice'])->name('ai.sendVoice');

Route::get('/check-mail-config', function () {
    return [
        'env' => env('MAIL_HOST'),
        // 'env' => env('MAIL_PORT'),
        'config' => config('mail.mailers.smtp.host'),
        'Default Mailer' => config('mail.default')
    ];
});
Route::get('/check-full-mail-config', function () {
    return config('mail');
});

Route::get('/check-env-file', function () {
    return file_get_contents(base_path('.env'));
});
Route::get('/check-env', function () {
    return [
        'env_value' => config('app.test_key'),
    ];
});

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Database is connected.";
    } catch (\Exception $e) {
        return "❌ Database is NOT connected. Error: " . $e->getMessage();
    }
});
Route::get('/env-debug', function () {
    return [
        'MAIL_HOST' => env('MAIL_HOST'),
        'MAIL_PORT' => env('MAIL_PORT'),
        'MAIL_USERNAME' => env('MAIL_USERNAME'),
        'MAIL_PASSWORD' => env('MAIL_PASSWORD') ? 'set' : 'not set',
    ];
});
Route::get('/send-test-mail1', function () {
    Mail::raw('This is a test email from DreamHost SMTP.', function ($message) {
        $message->to('nikhil02.1998@gmail.com')
            ->subject('Test Email');
    });

    return 'Mail sent!';
});
