<?php

namespace App\Http\Controllers;
// namespace App\Console\Commands;

use App\Models\client;
use App\Models\Leave;
use App\Models\Project;
use App\Models\Screenshot;
use App\Models\Task;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Broadcast;
use App\Models\Document;


class AdminController extends Controller
{


    public function formatDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function dashboard()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $today = Carbon::today();
      
        $employee = User::get()->where("role", 1)->count();
        $projects = Project::get()->count();
        $tasks = Task::get()->where('task_date', date('Y-m-d'))->count();
        $completedtasks = Task::get()->where('task_date', date('Y-m-d'))->where("status", "completed")->count();
        // dd($employee, $projects,$tasks);
        $log_time = TimeLog::join('users', 'time_log.user_id', '=', 'users.id')
            ->whereDate('time_log.created_at', Carbon::today())
            // ->whereTime('time_log.chek_in_time', '>', '10:15:00')
            ->select('time_log.*', 'users.name')
            ->get();

        // dd($log_time);
        $data = Task::get()->where('task_date', date('Y-m-d'));
        $data = Task::join('users', 'tasks.assigned_to', '=', 'users.id')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->where('task_date', date('Y-m-d'))
            //    ->select('users.*','projects.*','tasks.*')
            ->select(
                'tasks.id as task_id',
                'tasks.task_date',
                'tasks.time_taken',
                'tasks.title',
                'tasks.expected_time',
                'tasks.status as task_status',
                'users.id as user_id',
                'users.*',
                'projects.id as project_id',
                'projects.name as project_name',
                'projects.status as project_status'
            )
            ->get();

        // 📊 Project Progress Graph Data
        // $projectsData = Project::select('name', 'start_date', 'end_date')->get();
        // $chartData = [];

        // foreach ($projectsData as $project) {
        //     $chartData[] = [
        //         'name' => $project->name,
        //         'start' => Carbon::parse($project->start_date)->timestamp * 1000, // Convert to JS timestamp
        //         'end' => Carbon::parse($project->end_date)->timestamp * 1000,
        //     ];
        // }
        //  dd($data);

        $projectss = Project::select('name', 'start_date', 'end_date')->get();

        $chartData = [];
        foreach ($projectss as $project) {
            // अगर start_date और end_date NULL है तो ignore करें
            if (!$project->start_date || !$project->end_date) {
                continue;
            }

            $startDate = Carbon::parse($project->start_date);
            $endDate = Carbon::parse($project->end_date);
            $today = Carbon::now();

            // यदि End Date बीत चुकी है, तो इसे 100% करें
            if ($today > $endDate) {
                $progress = 100;
            } elseif ($today < $startDate) {
                $progress = 0;
            } else {
                $totalDays = $startDate->diffInDays($endDate);
                $daysPassed = $startDate->diffInDays($today);
                $progress = round(($daysPassed / $totalDays) * 100, 2);
            }

            $chartData[] = [
                'name' => $project->name,
                'progress' => $progress,
            ];
        }
        $taskschart = DB::table('tasks')
            ->join('users', 'tasks.assigned_to', '=', 'users.id')
            ->select(
                'users.name as user_name',
                DB::raw('COUNT(tasks.id) as total_tasks'),
                DB::raw('SUM(CASE WHEN tasks.status = "completed" THEN 1 ELSE 0 END) as completed_tasks')
            )
            ->whereDate('tasks.task_date', $today)
            ->groupBy('users.name')
            ->get();

          $leave = Leave::select('user_id', DB::raw('SUM(DATEDIFF(to_date, from_date) + 1) as leave_count'))
            ->where('status', 'approved')
            ->whereMonth('from_date', Carbon::now()->month)
            ->whereYear('from_date', Carbon::now()->year)
            ->groupBy('user_id')
            ->with('user')
            ->get();
      

        // Debugging
        // dd($leave);
      $today = Carbon::today()->toDateString();
      $broadcast = Broadcast::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->latest()
            ->first();

        $broadcasts = Broadcast::latest()->get();
               $employees = User::where('role', 1)
            ->with(['timeLogsToday', 'timeLogsThisMonth', 'leavesThisMonth'])
            ->get()
            ->map(function ($employee) {
                $checkInToday = optional($employee->timeLogsToday->first())->chek_in_time;
                $createdAtToday = optional($employee->timeLogsToday->first())->created_at;

                $totalMinutes = $employee->timeLogsThisMonth->sum('total_time');

                $leaveCount = 0;
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();
                foreach ($employee->leavesThisMonth as $leave) {
                    $leaveStart = Carbon::parse($leave->from_date)->greaterThan($startOfMonth)
                        ? Carbon::parse($leave->from_date)
                        : $startOfMonth;

                    $leaveEnd = Carbon::parse($leave->to_date)->lessThan($endOfMonth)
                        ? Carbon::parse($leave->to_date)
                        : $endOfMonth;

                    if ($leave->leave_duration === 'Half Day') {
                        $leaveCount += 0.5;
                    } else {
                        $leaveCount += $leaveEnd->diffInDays($leaveStart) + 1;
                    }
                }

                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'check_in_today' => $checkInToday ?? null,
                    'created_at_today' => $createdAtToday,
                    'total_leave_days' => $leaveCount,
                    'total_working_minutes' => $totalMinutes,
                ];
            });
        return view('admin.admindashboard', compact('employee', 'projects', 'tasks', 'data', 'completedtasks', 'log_time', 'projectss', 'chartData', 'taskschart', 'leave','broadcast','broadcasts','employees'));
    }

    public function editEmployee($id)
    {
        // Fetch the employee by ID
        $employee = User::findOrFail($id);

        // Load the edit view and pass the employee data
        return view('admin.editEmployee', compact('employee'));
    }
  
   public function deleteEmployee($id)
    {
        // Fetch the employee by ID
        $employee = User::findOrFail($id);

        // Delete the employee
        $employee->delete();
        return redirect('/employee')->with('success', 'Employee deleted successfully!');
    }
  
    public function postemployee(Request $request)
    {

        $ValidatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'department' => 'required|',
            'date_of_joining' => 'required|date',
            'date_of_birth' => 'required|date',
            // 'role' => 1,
            'role' => 'required|in:0,1,2,3', // Admin=0, User=1, PM=2, HR=3
            'password' => 'required|string|min:6',
            'conform_password' => 'required|string|same:password',
        ], [
            'confirm_password.same' => 'The confirm password must match the password.',
        ]);

        $ValidatedData['role'] = 1;
        User::create($ValidatedData);
        return redirect('/employee');

        // return view('admin.employee');
    }

    public function updateEmployee(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'department' => 'required',
            'role' => 'required|in:0,1,2,3',
            'date_of_joining' => 'required|date',
            'date_of_birth' => 'required|date',
            'password' => 'nullable|string|min:6', // Password is optional
            'confirm_password' => 'nullable|string|same:password',
        ], [
            'confirm_password.same' => 'The confirm password must match the password.',
        ]);

        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Update user data
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->department = $validatedData['department'];
        $user->date_of_joining = $validatedData['date_of_joining'];
        $user->date_of_birth = $validatedData['date_of_birth'];

        // If password is provided, hash and update it
        if (!empty($validatedData['password'])) {
            $user->password = $validatedData['password'];
        }

        // Save the changes
        $user->save();

        // Redirect back to the employee listing or desired page
        return redirect('/employee')->with('success', 'Employee updated successfully!');
    }

    public function employee()
    {
        $data = User::where('role', 1)->get();

        return view('admin.employee', compact('data'));
    }

    public function adduser()
    {

        return view('admin.addEmployee');
    }

    public function addproject()
    {
        $clients = client::all();
        $employees = User::get()->where("role", 1);

        return view('admin.projects', compact('employees', 'clients'));
    }

    public function postproject(Request $request)
    {
        $employee = User::get()->where("role", 1);
        $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'server_url' => 'nullable|url',
            'client_url' => 'nullable|url',
            // 'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'description' => 'required|string',
            'employees' => 'required|array',
        ]);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $originalName = $request->file('document')->getClientOriginalName();

            // Extract the file name and extension
            $name = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $request->file('document')->getClientOriginalExtension();

            // Generate a unique name with current date and time
            $timestamp = now()->format('Ymd_His'); // e.g., 20241130_153045
            $newFileName = $name . '_' . $timestamp . '.' . $extension;
            $documentPath = $request->file('document')->storeAs('documents', $newFileName, 'public');
        }
        $project = Project::create([
            'name' => $request->input('name'),
            'client_id' => $request->input('client_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => $request->input('status'),
            'server_url' => $request->input('server_url'),
            'client_url' => $request->input('client_url'),
            // 'document' => $documentPath,
            'description' => $request->input('description'),
            // 'employees' => $request->input('employees'),
            'employees' => json_encode($request->input('employees')),
        ]);
        // $project->employees()->attach($request->input('employees'));
        return redirect('/projectlist')->with('success', 'Project created successfully!');
    }

    public function projectlist()
    {
        $data = Project::get();

        return view('admin.projectlist', compact('data'));
    }


    // public function editproject(Request $request,$id){
    //     // $data = Project::get('id',$id);
    //     $data = Project::findOrFail($id);
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date|after_or_equal:start_date',
    //         'status' => 'required|string',
    //         'server_url' => 'nullable|url',
    //         'client_url' => 'nullable|url',
    //         'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    //         'description' => 'required|string',
    //     ]);

    //     $data->update($request->all());

    //     return view('admin.editProject',compact('data'));
    // }

    public function editproject($id)
    {
        // Fetch project data
        $employees = User::get()->where("role", 1);
        // $data = Project::findOrFail($id);
        $data = Project::join('clients', 'projects.client_id', '=', 'clients.id')
            ->select('projects.*', 'clients.full_name as client_name')
            ->where('projects.id', $id)
            ->firstOrFail();
            // dd($data);
        $clients = client::get();
        return view('admin.editProject', compact('data', 'employees', 'clients'));
    }
    // viewproject
    public function viewproject($id)
    {
        // Fetch project data
        $employees = User::get()->where("role", 1);
        $data = Project::findOrFail($id);
        // dd($data);
        return view('admin.viewproject', compact('data', 'employees'));
    }

    public function update(Request $request, $id)
    {
        // Fetch the project by ID
        $data = Project::findOrFail($id);

        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'server_url' => 'nullable|url',
            'client_url' => 'nullable|url',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'description' => 'required|string',
            'employees' => 'nullable|array',
        ]);

        // Handle document upload if provided
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = time() . '_' . $document->getClientOriginalName();
            $documentPath = $document->storeAs('documents', $documentName, 'public');

            // Delete old document if exists
            if ($data->document && file_exists(storage_path('app/public/' . $data->document))) {
                unlink(storage_path('app/public/' . $data->document));
            }

            // Add the document path to the validated data
            $validatedData['document'] = $documentPath;
        }

        $validatedData['employees'] = $request->input('employees') ? json_encode($request->input('employees')) : null;
        // Update the project with the validated data
        $data->update($validatedData);
        // dd($request->all());

        // Redirect back with success message
        return redirect('/projectlist')
            // ->back()
            // ->route('projectlist', ['id' => $id])
            ->with('success', 'Project Details updated successfully!');
    }

    public function projecttask($id)
    {
        $project = Project::find($id);
        $assignedEmployees = json_decode($project->employees, true);
        // $user = User::get()->where('role', 1);
        $user = User::whereIn('id', $assignedEmployees)->get();
        // dd($user);
        return view('admin.projectTask', compact('project', 'id', 'user'));
    }

    public function storetasks(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|integer',
            'expected_time' => 'nullable|integer',
            'task_date' => 'nullable|date'

        ]);

        // Create a new task and save it to the database
        $task = new Task();
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->project_id = $id; // Assuming tasks are associated with a user
        $task->assigned_to = $validated['assigned_to'];
        $task->expected_time = $validated['expected_time'];
        $task->task_date = $validated['task_date']; // Assuming tasks are associated with a user
        $task->save();

        return redirect('/tasks-list/' . $id)->with('success', 'Task created successfully!');
    }

    public function tasklist($id)
    {

        $tasks = Task::where('project_id', $id)->get();

        return view('admin.tasklist', compact('tasks'));
    }
    // public function taskreport(Request $request)
    // {

    //     $user = User::get()->where("role", 1);

    //     $data =
    //         $tasks = collect(); // Initialize an empty collection for tasks
    //     $startDate = $request->start_date; // Store the submitted start_date
    //     $selectedUser = $request->status; // Store the submitted user ID

    //     // Check if the form is submitted with filters
    //     // if ($request->has('start_date') || $request->has('status')) {
    //     if ($startDate || $selectedUser) {
    //         $query = DB::table('tasks')
    //             ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
    //             ->leftJoin('users', 'tasks.assigned_to', '=', 'users.id')
    //             ->select(
    //                 'tasks.*',
    //                 'projects.name as project_name',
    //                 'users.name as assigned_user_name'
    //             );

    //         // Apply filters based on request inputs
    //         if ($request->has('start_date') && $request->start_date) {
    //             $query->whereDate('tasks.task_date', '=', $request->start_date);
    //         }

    //         if ($request->has('status') && $request->status) {
    //             $query->where('tasks.assigned_to', '=', $request->status);
    //         }

    //         $tasks = $query->get(); // Fetch filtered results
    //     }
    //     return view('admin.taskreport', compact('user', 'tasks', 'startDate', 'selectedUser'));
    // }

    public function taskreport(Request $request)
    {
        $user = User::get()->where("role", 1);

        $startDate = $request->start_date ?? date('Y-m-d');
        $endDate = $request->end_date ?? null;
        $selectedUser = $request->status;

        $query = DB::table('tasks')
            ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
            ->leftJoin('users', 'tasks.assigned_to', '=', 'users.id')
            ->select(
                'tasks.*',
                'projects.name as project_name',
                'users.name as assigned_user_name'
            );

        // Apply filters based on request inputs
        // if ($request->has('start_date') && $request->start_date) {
        //     $query->whereDate('tasks.task_date', '=', $request->start_date);
        // } else {
        //     $query->whereDate('tasks.task_date', '=', $startDate); // Default to today's date
        // }

        // Apply date range filter
        if ($startDate && $endDate) {
            $query->whereBetween('tasks.task_date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('tasks.task_date', '>=', $startDate);
        }

        if ($request->has('status') && $request->status) {
            $query->where('tasks.assigned_to', '=', $request->status);
        }

        $tasks = $query->get(); // Fetch filtered results
        return view('admin.taskreport', compact('user', 'tasks', 'startDate', 'endDate', 'selectedUser'));
    }

    public function profile()
    {
        return view('admin.myprofile');
    }
     public function getCheckInData(Request $request)
{
    $user = User::where("role", 1)->get(); // Get only users with role = 1

    // Get filter inputs or default values
    $startDate = $request->start_date ?? date('Y-m-d');
    $endDate = $request->end_date ?? $startDate;
    $selectedUser = $request->status;

    // Start building the query
    $query = DB::table('time_log')
        ->join('users', 'users.id', '=', 'time_log.user_id')
        ->select('time_log.*', 'users.name')
        ->when($selectedUser, function ($q) use ($selectedUser) {
            return $q->where('time_log.user_id', $selectedUser);
        })
        ->whereBetween(DB::raw('DATE(time_log.created_at)'), [$startDate, $endDate])
        ->orderBy('time_log.created_at', 'desc')
        ->get();

    return view('admin.checkinrecord', compact('startDate', 'endDate', 'query', 'selectedUser', 'user'));
}

    public function leaveRequests()
    {
        $pendingLeaves = Leave::with('user')->where('status', 'pending')->get();
        $approvedLeaves = Leave::with('user')->where('status', 'approved')->get();
        $cancelledLeaves = Leave::with('user')->where('status', 'cancelled')->get();
        $pendingCount = $pendingLeaves->count();
        return view('admin.leaveRequest', compact('pendingLeaves', 'approvedLeaves', 'cancelledLeaves', 'pendingCount'));
    }
    public function approveLeave($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = 'approved';
        $leave->save();

        return redirect()->back()->with('success', 'Leave approved successfully');
    }

    public function cancelLeave($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = 'cancelled';
        $leave->save();

        return redirect()->back()->with('success', 'Leave cancelled successfully');
    }

    public function screenActivity()
    {

        // $users = User::get()->where('role', 1);
        $users = DB::table('users')
            ->where('role', 1)
            ->get()
            ->map(function ($user) {
                $user->latest_screenshot = DB::table('screenshots')
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                return $user;
            });
        // dd($users);
        return view('admin.screenActivity', compact('users'));
    }
  
  public function userActivity()
    {

        // $users = User::get()->where('role', 1);
        $users = DB::table('users')
            ->where('role', 1)
            ->get()
            ->map(function ($user) {
                $user->latest_screenshot = DB::table('screenshots')
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                return $user;
            });
        // dd($users);
        return view('admin.userActivity', compact('users'));
    }
    // public function showScreenshot($id)
    // {
    //     $user = User::findOrFail($id);
    //     $screenshots = Screenshot::where('user_id', $id)
    //         ->whereDate('created_at', Carbon::today())
    //         ->orderBy('created_at', 'desc')
    //         ->get();


    //     return view('admin.screenshots', compact('user', 'screenshots'));
    // }

    public function showScreenshot(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $selectedDate = $request->input('date') ?? Carbon::today()->toDateString(); // Default: today

        $screenshots = Screenshot::where('user_id', $id)
            ->whereDate('created_at', $selectedDate)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.screenshots', compact('user', 'screenshots', 'selectedDate'));
    }
    public function showUserActivity(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $selectedDate = $request->input('date') ?? Carbon::today()->toDateString(); // Default: today

        $screenshots = Screenshot::where('user_id', $id)
            ->whereDate('created_at', $selectedDate)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.userscreenshots', compact('user', 'screenshots', 'selectedDate'));
    }

    public function profilepage()
    {
        $user = auth()->user();
        $data = User::find($user->id);
        // dd($data);
        return view('admin.profile', compact('user', "data"));
    }

    //  public function updateProfile(Request $request)
    // {
    //     $user = auth()->user();

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => "required|email|unique:users,email,{$user->id}",
    //         'department' => 'required|string',
    //         'date_of_joining' => 'required|date',
    //         'date_of_birth' => 'required|date',
    //         'password' => 'nullable|string|min:6',
    //         'confirm_password' => 'nullable|string|same:password',
    //     ], [
    //         'confirm_password.same' => 'The confirm password must match the password.',
    //     ]);

    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->department = $request->department;
    //     $user->date_of_joining = $request->date_of_joining;
    //     $user->date_of_birth = $request->date_of_birth;

    //     if ($request->filled('password')) {
    //         $user->password = $request->password; // Not hashed
    //     }

    //     $user->save();


    //     return redirect()->back()->with('success', 'Profile updated successfully.');
    // }
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'department' => 'required|string',
            'date_of_joining' => 'required|date',
            'date_of_birth' => 'required|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
      
      // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profile_pictures', $filename);

            // Optional: delete old picture
            if ($user->profile_picture) {
                Storage::delete('public/profile_pictures/' . $user->profile_picture);
            }

            $user->profile_picture = $filename;
        }

        // Add password validation only if password field is filled
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6';
            $rules['confirm_password'] = 'required|string|same:password';
        }

        $validatedData = $request->validate($rules, [
            'confirm_password.same' => 'The confirm password must match the password.',
        ]);

        // Update profile fields
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->department = $validatedData['department'];
        $user->date_of_joining = $validatedData['date_of_joining'];
        $user->date_of_birth = $validatedData['date_of_birth'];

        if (!empty($validatedData['password'])) {
            $user->password = $validatedData['password'];
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function clientpage()
    {
        $clients = client::all();
        return view('admin.client', compact('clients'));
    }

    public function addclient()
    {
        return view('admin.addclient');
    }

    public function postclient(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_website_url' => 'required',
            'full_name' => 'required|string|max:255',
            'official_email' => 'required|email|unique:clients,official_email',
            'personal_email' => 'nullable|email',
            'official_contact_name' => 'nullable|string|max:255',
            'personal_contact_name' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'full_address' => 'required|string|max:255',
        ]);

        // Create a new client
        $client = new client();
        $client->fill($validatedData);
        $client->save();

        return redirect('/client-list')->with('success', 'Client created successfully!');
    }
    public function clientlist()
    {
        $clients = client::all();
        return view('admin.clientlist', compact('clients'));
    }

    public function editclient($id)
    {
        // Fetch the client by ID
        $client = client::findOrFail($id);
        return view('admin.editclient', compact('client'));
    }

    public function updateclient(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_website_url' => 'required',
            'full_name' => 'required|string|max:255',
            'official_email' => 'required|email|unique:clients,official_email,' . $id,
            'personal_email' => 'nullable|email',
            'official_contact_name' => 'nullable|string|max:255',
            'personal_contact_name' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'full_address' => 'required|string|max:255',
        ]);

        // Fetch the client by ID
        $client = client::findOrFail($id);

        // Update client data
        $client->fill($validatedData);
        $client->save();

        // Redirect back to the client listing or desired page
        return redirect('/client-list')->with('success', 'Client updated successfully!');
    }

    // public function viewclient($id)
    // {
    //     // Fetch the client by ID
    //     $client = client::findOrFail($id);
    //     return view('admin.viewclient',compact('client'));
    // }
   public function storeBroadcast(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'required|string|max:1000',
        ]);

        // Store the broadcast message
        Broadcast::create([
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'message'    => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Broadcast notification sent successfully.');
    }
    //function for delete broadcast.
    public function destroy($id)
{
    Broadcast::findOrFail($id)->delete();
    return back()->with('success', 'Broadcast deleted successfully.');
}
   public function getleavepage(Request $request)
    { 
        $user = User::get()->where("role", 1);
        $data =  Leave::with('user')->get();
        // dd($data);
          $startDate = $request->start_date ?? now()->toDateString();
    $endDate = $request->end_date ?? now()->toDateString();
    $selectedUser = $request->status;
    $selectedMonth = $request->month;

    // Build the query
    $leaveData = DB::table('leave_record')
        ->join('users', 'users.id', '=', 'leave_record.user_id')
        ->select('leave_record.*', 'users.name')
        ->when($selectedUser, function ($q) use ($selectedUser) {
            return $q->where('leave_record.user_id', $selectedUser);
        })
        // ->when($selectedMonth, function ($q) use ($selectedMonth) {
        //     return $q->whereMonth('leave_record.from_date', $selectedMonth);
        // })
        ->whereBetween(DB::raw('DATE(leave_record.from_date)'), [$startDate, $endDate])
        ->orderBy('leave_record.from_date', 'desc')
        ->get();
        
        return view('admin.leavereports',compact('data','user','leaveData'));
    }
   public function getLeaveReport(Request $request)
{
    // Get all users with role = 1
    $user = User::where("role", 1)->get();

    // Default to today's date if not provided
    $startDate = $request->start_date ?? now()->toDateString();
    $endDate = $request->end_date ?? now()->toDateString();
    $selectedUser = $request->status;
    $selectedMonth = $request->month;

    // Build the query
    $leaveData = DB::table('leave_record')
        ->join('users', 'users.id', '=', 'leave_record.user_id')
        ->select('leave_record.*', 'users.name')
        ->when($selectedUser, function ($q) use ($selectedUser) {
            return $q->where('leave_record.user_id', $selectedUser);
        })
        // ->when($selectedMonth, function ($q) use ($selectedMonth) {
        //     return $q->whereMonth('leave_record.from_date', $selectedMonth);
        // })
        ->whereBetween(DB::raw('DATE(leave_record.from_date)'), [$startDate, $endDate])
        ->orderBy('leave_record.from_date', 'desc')
        ->get();
        // dd($query);

    return view('admin.leavereports', compact(
        'startDate',
        'endDate',
        'leaveData',
        'selectedUser',
        'selectedMonth',
        'user',
        'leaveData'
    ));
}
   public function leaveDashboard(){
         $leave = Leave::with('user')
            ->where('status', 'approved')
            ->whereMonth('from_date', Carbon::now()->month)
            ->whereYear('from_date', Carbon::now()->year)
            ->get();
        return view('admin.leave-dashboard',compact('leave'));
    }
       public function documents()
    {
        $user = User::get()->where("role", 1);

        return view('admin.document', compact('user'));
    }

    public function uploadDocuments($id)
    {
        $documents = Document::where('user_id', $id)
        ->with('uploadedBy')
        ->latest()->get();
        // dd($documents);
        return view('admin.uploadDocument', compact('id','documents'));
    }

    public function storeDocument(Request $request)
    {
        $loginUser = auth()->user()->id;
        $request->validate([
            'user_id' => 'required|exists:users,id',
            // 'uploaded_by' =>  $loginUser,
            'document_name' => 'required|string',
            'document_path' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        // Store uploaded file in public storage
        $path = $request->file('document_path')->store('documents', 'public');

        // Save info to DB
        Document::create([
            'user_id' => $request->user_id,
            'uploaded_by' => $loginUser,
            'document_name' => $request->document_name,
            'document_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully!');
    }
     public function asktoai(){
        return view('admin.asktoai');
    }

}
