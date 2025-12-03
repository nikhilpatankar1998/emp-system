<?php

namespace App\Http\Controllers;

use App\Models\Broadcast;
use App\Models\Document;
use App\Models\Leave;
use App\Models\Project;
use App\Models\Salary;
use App\Models\Task;
use App\Models\TimeLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HrController extends Controller
{
    public function index()
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
    //     return view('admin.admindashboard', compact('employee', 'projects', 'tasks', 'data', 'completedtasks', 'log_time', 'projectss', 'chartData', 'taskschart', 'leave','broadcast','broadcasts','employees'));
    // }
        return view('hr.hrdashboard',compact('employee', 'projects', 'tasks', 'data', 'completedtasks', 'log_time', 'projectss', 'chartData', 'taskschart', 'leave','broadcast','broadcasts','employees'));
    }
     public function adduser()
    {

        return view('hr.addEmployee');
    }

        public function editEmployees($id)
    {
        // Fetch the employee by ID
        $employee = User::findOrFail($id);

        // Load the edit view and pass the employee data
        return view('hr.editEmployee', compact('employee'));
    }
  
   public function deleteEmployee($id)
    {
        // Fetch the employee by ID
        $employee = User::findOrFail($id);

        // Delete the employee
        $employee->delete();
        return redirect('/employees')->with('success', 'Employee deleted successfully!');
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

        // $ValidatedData['role'] = 1;
        User::create($ValidatedData);
        return redirect('/hr-employees')->with('success', 'Employee added successfully.');

        // return view('admin.employee');
    }

    public function updateEmployee(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:0,1,2,3',
            'department' => 'required',
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
        $user->role = $validatedData['role'];
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
        return redirect('/hr-employees')->with('success', 'Employee updated successfully!');
    }  
     public function employees()
    {
        $data = User::get();
        return view('hr.employee', compact('data'));
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
        
        return view('hr.leavereports',compact('data','user','leaveData'));
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

    return view('hr.leavereports', compact(
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

        return view('hr.document', compact('user'));
    }

    public function uploadDocuments($id)
    {
        $documents = Document::where('user_id', $id)
        ->with('uploadedBy')
        ->latest()->get();
        // dd($documents);
        return view('hr.uploadDocument', compact('id','documents'));
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
        public function leaveRequests()
    {
        $pendingLeaves = Leave::with('user')->where('status', 'pending')->get();
        $approvedLeaves = Leave::with('user')->where('status', 'approved')->get();
        $cancelledLeaves = Leave::with('user')->where('status', 'cancelled')->get();
        $pendingCount = $pendingLeaves->count();
        return view('hr.leaveRequest', compact('pendingLeaves', 'approvedLeaves', 'cancelledLeaves', 'pendingCount'));
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
      public function documentspage()
    {
        $id = auth()->user()->id;
        $documents = Document::where('user_id', $id)
        ->with('uploadedBy')
        ->latest()->get();
        // dd($documents);
        return view('hr.document',compact('id','documents'));
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

    return view('hr.checkinrecord', compact('startDate', 'endDate', 'query', 'selectedUser', 'user'));
}

 public function salaryuserlist()
    {
        $user = User::get()->where("role", 1);
        return view('hr.salaryuserlist', compact('user'));
    }
    public function genratesalary($id)
    {
        $user = User::findOrFail($id);

        return view('hr.genratesalary', compact('id', 'user'));
    }
    public function showGenerateForm($id)
    {
        // 1. Fetch the User
        $user = User::findOrFail($id);

        // 2. Fetch existing salary records for this user, ordered latest first
        $salary = Salary::where('user_id', $id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->firstOrFail();

        // 3. Return view with both $user and $salaryRecords
        return view('hr.genratesalarytemplate', compact('user', 'salary'));
    }

    public function store(Request $request, $id)
    {
        // Validate inputs
        $data = $request->validate([
            'month'             => 'required|integer|min:1|max:12',
            'year'              => 'required|integer|min:2000|max:3000',
            'basic_salary'      => 'required|numeric|min:0',
            'other_allowances'  => 'required|numeric|min:0',
            'incentive_pay'     => 'required|numeric|min:0',
            'provident_fund'    => 'required|numeric|min:0',
            'professional_tax'  => 'required|numeric|min:0',
            'other_deduction'   => 'required|numeric|min:0',
            'total_allowances'  => 'required|numeric|min:0',
            'total_deduction'   => 'required|numeric|min:0',
            'net_salary'        => 'required|numeric|min:0',
        ]);

        // Ensure the user exists
        $user = User::findOrFail($id);

        // Check for duplicate month+year for this user
        $exists = Salary::where('user_id', $id)
            ->where('month', $data['month'])
            ->where('year', $data['year'])
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withErrors([
                    'duplicate' => 'Salary for '
                        . date('F', mktime(0, 0, 0, $data['month'], 1))
                        . ' ' . $data['year']
                        . ' has already been generated.'
                ])
                ->withInput();
        }

        // Merge user_id into data
        $data['user_id'] = $id;

        // Create the record
        Salary::create($data);

        // Redirect back with success
        return redirect()
            ->route('hr.getsalaryusers', ['id' => $id])
            ->with('success', 'Salary generated successfully for '
                . date('F', mktime(0, 0, 0, $data['month'], 1))
                . ' ' . $data['year'] . '.');
    }

    public function showAllPayslips()
    {

        $id = auth()->id(); // Get the authenticated user's ID
        $user = User::findOrFail($id);
        $salaries = Salary::where('user_id', $id)->orderByDesc('month')->get();
        return view('hr.payslip_list', compact('id', 'salaries', 'user'));
    }

    public function viewPayslip($userId, $salaryId)
    {
        $user = User::findOrFail($userId);
        $salary = Salary::where('id', $salaryId)->where('user_id', $userId)->firstOrFail();

        return view('hr.genratesalarytemplate', compact('user', 'salary'));
    }

    public function showAllUsersPayslips($id)
    {
        $user = User::findOrFail($id);
        $salaries = Salary::where('user_id', $id)
            ->orderByDesc('month')
            ->get();
        return view('hr.payslip_list', compact('salaries', 'user'));
    }

    public function downloadDocument($filename)
    {
        $filePath = storage_path('app/public/' . $filename);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath);
    }
}
