<?php

namespace App\Http\Controllers;
use App\Mail\CheckInNotification;
use App\Mail\CheckOutNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\Leave;
use App\Models\Project;
use App\Models\Task;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Broadcast;
use App\Models\Document;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = auth()->id();
        $projectCount = Project::whereJsonContains('employees', (string)$userId)->count();
        $tasks = Task::get()->where('task_date', date('Y-m-d'))->where('assigned_to', $userId)->count();
        $completedtasks = Task::get()->where('task_date', date('Y-m-d'))->where('status', 'completed')->where('assigned_to', $userId)->count();
        $incompleteTasks  = Task::get()->where('task_date', date('Y-m-d'))->where('status', '!=', 'completed')->where('assigned_to', $userId)->count();
        // dd($completedtasks);
        // $projects = Project::get();
        // $projects = Project::whereJsonContains('employees', $user->id)->get();
        $projects = Project::whereJsonContains('employees', (string) $user->id)->get();
        // dd($projects,$user);
      //for broadcaste.
        $today = Carbon::today()->toDateString();
        $broadcast = Broadcast::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->latest()
            ->first();
      
        return view('user.dashboard', compact('projects', 'user', 'projectCount', 'tasks', 'completedtasks', 'incompleteTasks','broadcast'));
    }
    public function addtasks($id)
    {

        $tasks = Task::where('id', $id)->get();
        // dd($tasks);

        return view('user.addtask', compact('tasks'));
    }
    public function mytask()
    {
        // $tasks = Task::with(['project', 'user'])->get();
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();
        $tasks = DB::table('tasks')
            ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
            ->leftJoin('users', 'tasks.assigned_to', '=', 'users.id')
            ->select(
                'tasks.*',
                'projects.name as project_name',
                'users.name as assigned_user_name'
            )
            ->where('tasks.assigned_to', $userId)
            ->whereDate('tasks.task_date', $today)
            ->get();
        //  dd($tasks);
        return view("user.mytask", compact("tasks"));
    }

    public function projecttask($id)
    {
        // $tasks = Task::where('project_id', $id)->get();
        $userId = auth()->id(); 
        $tasks = Task::where('project_id', $id)
                     ->where('assigned_to', $userId)
                     ->orderBy('created_at', 'desc')
                     ->get();
        //  dd($tasks);
        return view('user.projecttask', compact('tasks'));
    }

    public function taskDetails($id)
    {
        $task = DB::table('tasks')
            ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
            ->leftJoin('users', 'tasks.assigned_to', '=', 'users.id')
            ->select(
                'tasks.*',
                'projects.name as project_name',
                'users.name as assigned_user_name'
            )
            ->where('tasks.id', $id)
            ->first();  // Fetch the task based on the ID

        return view('user.taskDetailsModal', compact('task'));  // Pass the task data to the modal view
    }

    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            // 'time_taken' => 'required|string|max:255',
            'time_taken' => 'required|integer|min:10|max:480',
            'status' => 'required|string',
            'descriptionbyuser' => 'nullable|string',
        ]);

        // Find the task by ID
        $task = Task::findOrFail($id);

        // Update task fields
        $task->time_taken = $request->time_taken;
        $task->status = $request->status;
        $task->descriptionbyuser = $request->descriptionbyuser;

        // Save the task
        $task->save();

        // Redirect back with success message
        return redirect('/mytask')->with('success', 'Task Added successfully.');
    }

    public function updatetask($id){

        $update = Task::findOrFail($id);
// dd($update);
        return view('user.edittask',compact('update'));
    }

    public function updateMyTask(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'time_taken' => 'required|integer|min:10|max:480',
            'status' => 'required|string|in:inprogress,active,completed',
            'descriptionbyuser' => 'nullable|string',
        ]);

       
        $task = Task::findOrFail($id);

        $task->time_taken = $request->time_taken;
        $task->status = $request->status;
        $task->descriptionbyuser = $request->descriptionbyuser;

        $task->save();

        // Redirect with success message
        return redirect('/mytask')->with('success', 'Task updated successfully!');
    }


    // public function storeCheckIn(Request $request)
    // {
    //     $this->validate($request, [
    //         'task_description' => 'required|string'
    //     ]);

    //     $timeLog = TimeLog::create([
    //         'in_description' => $request->task_description,
    //         'chek_in_time' => now(),
    //     ]);

    //     return response()->json(['message' => 'Check-in successful', 'timeLog' => $timeLog]);
    // }
    public function storeCheckIn5(Request $request)
    {
        $this->validate($request, [
            'task_description' => 'required|string'
        ]);

        $timeLog = TimeLog::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($timeLog) {
            return response()->json(['error' => 'Already checked in'], 400);
        }

        $timeLog = TimeLog::create([
            'user_id' => auth()->id(),
            'in_description' => $request->task_description,
            'chek_in_time' => now(),
            'paused_time' => 0, // ✅ New field for paused duration
            'status' => 'active'
        ]);

        session(['checked_in' => true]);
        return response()->json(['message' => 'Check-in successful', 'timeLog' => $timeLog]);
    }
    public function checkInStatus0()
    {
        $timeLog = TimeLog::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($timeLog) {
            return response()->json([
                'checked_in' => true,
                'check_in_time' => $timeLog->chek_in_time
            ]);
        } else {
            return response()->json(['checked_in' => false]);
        }
    }
    public function checkInStatus1()
    {
        $timeLog = TimeLog::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($timeLog) {
            $checkInTime = strtotime($timeLog->chek_in_time);
            $currentTime = time();
            $elapsedTime = $currentTime - $checkInTime; // Calculate elapsed time in seconds

            return response()->json([
                'checked_in' => true,
                'check_in_time' => $timeLog->chek_in_time,
                'elapsed_time' => $elapsedTime
            ]);
        } else {
            return response()->json(['checked_in' => false]);
        }
    }
    public function checkInStatus5()
    {
        $timeLog = TimeLog::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($timeLog) {
            $checkInTime = strtotime($timeLog->chek_in_time);
            $currentTime = time();
            $elapsedTime = $currentTime - $checkInTime; // ✅ Total elapsed time in seconds

            // Add paused time to the elapsed time
            $totalElapsedTime = $elapsedTime + $timeLog->paused_time; // Including paused time from DB

            return response()->json([
                'checked_in' => true,
                'check_in_time' => $timeLog->chek_in_time,
                'elapsed_time' => $totalElapsedTime
            ]);
        } else {
            return response()->json(['checked_in' => false]);
        }
    }
    public function updatePausedTime5(Request $request)
    {
        $this->validate($request, [
            'paused_time' => 'required|integer'
        ]);

        // Get the active time log for the user
        $timeLog = TimeLog::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($timeLog) {
            // Update the paused time in the database
            $timeLog->paused_time = $request->paused_time;
            $timeLog->save();

            return response()->json(['message' => 'Paused time updated']);
        }

        return response()->json(['error' => 'No active check-in found'], 400);
    }
    // Store Check-in
  
      public function storeCheckIn(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'task_description' => 'required|string'
        ]);

        // Check if user already has an active time log
        $timeLog = TimeLog::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($timeLog) {
            return response()->json(['error' => 'Already checked in'], 400);
        }

        // Create new time log
        $timeLog = TimeLog::create([
            'user_id' => auth()->id(),
            'in_description' => $request->task_description,
            'chek_in_time' => now(),
            'paused_time' => 0,
            'status' => 'active'
        ]);
        
        try {
    $user = auth()->user()->name;
    $description = $request->task_description;
    $checkInTime = now()->format('Y-m-d H:i:s');

    Mail::to('contactus@idicesystem.com')->cc('nikhil02.1998@gmail.com')
    ->send(new CheckInNotification(
        $user,
        $description,
        $checkInTime
    ));
} catch (\Exception $e) {
    \Log::error('Check-in mail failed: ' . $e->getMessage());
}

        return response()->json(['message' => 'Check-in successful'], 200);
    }

    // Check-in Status
    public function checkInStatus()
    {
        $timeLog = TimeLog::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($timeLog) {
            $checkInTime = strtotime($timeLog->chek_in_time);
            $currentTime = time();
            $elapsedTime = $currentTime - $checkInTime;

            $totalElapsedTime = $elapsedTime + $timeLog->paused_time;

            return response()->json([
                'checked_in' => true,
                'in_description' => $timeLog->in_description,
                'elapsed_time' => $totalElapsedTime
            ]);
        } else {
            return response()->json(['checked_in' => false]);
        }
    }

    // Update Paused Time
    public function updatePausedTime(Request $request)
    {
        $this->validate($request, [
            'paused_time' => 'required|integer'
        ]);

        $timeLog = TimeLog::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($timeLog) {
            $timeLog->paused_time = $request->paused_time;
            $timeLog->save();

            return response()->json(['message' => 'Paused time updated']);
        }

        return response()->json(['error' => 'No active check-in found'], 400);
    }

    // Checkout
    public function storeCheckOut(Request $request)
    {
        $this->validate($request, [
            'task_description' => 'required|string'
        ]);

        $timeLog = TimeLog::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($timeLog) {
            $checkInTime = strtotime($timeLog->chek_in_time);
            $currentTime = time();
            $elapsedTime = $currentTime - $checkInTime;

            $totalTime = $elapsedTime + $timeLog->paused_time;

            $timeLog->status = 'completed'; // Mark as checked out
            $timeLog->check_out_time = now();
            $timeLog->out_description = $request->task_description;
            $timeLog->total_time = $totalTime;
            $timeLog->save();
            try {
            $user = auth()->user()->name;
            $description = $request->task_description;
            $checkOutTime = now()->format('Y-m-d H:i:s');
            $workedHours = gmdate('H:i:s', $totalTime);

        Mail::to('contactus@idicesystem.com')->cc('nikhil02.1998@gmail.com')
->send(new CheckOutNotification(
            $user,
            $description,
            $checkOutTime,
            $workedHours
       ));
       } catch (\Exception $e) {
       \Log::error('Check-out mail failed: ' . $e->getMessage());
        }

            // return redirect('/dashboard')->with('success', 'Checked out  successfully');
            return redirect()->back()->with('success', 'Checked out successfully');
        }
        return redirect()->back()->with('error', 'No active check-in found');
        // return response()->json(['error' => 'No active check-in found'], 400);
    }

    public function dailyreport()
    {
        $today = Carbon::today()->toDateString();
        $querys = DB::table('tasks')
            ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
            ->leftJoin('users', 'tasks.assigned_to', '=', 'users.id')
            ->select(
                'tasks.*',
                'projects.name as project_name',
                'users.name as assigned_user_name'
            )
            ->where('tasks.assigned_to', Auth::id())
            ->whereDate('tasks.task_date', $today)
            ->get();
        // dd($querys);
        return view('user.dailyreports', compact('querys'));
    }
    public function monthlyreport()
    {
        //    $report = DB::table('tasks')
        // return view('user.monthlyreport');
    }

    public function addNewTask($id)
    {
        $project = Project::find($id);
        $assignedEmployees = json_decode($project->employees, true);
        // $user = User::get()->where('role', 1);
        $user = User::whereIn('id', $assignedEmployees)->where('id', auth()->id())->get();
        // dd($user);
        // return view('admin.projectTask', compact('project', 'id', 'user'));
        return view('user.createtask', compact('project', 'id', 'user'));
    }

    public function storetask(Request $request, $id)
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

        return redirect('/project-task/' . $id)->with('success', 'Task created successfully!');
        // return redirect()->back()->with ('success','Task created successfully');
    }

    public function applyleave()
    {

        return view('user.applyleave');
    }

    public function postLeave(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'leave_type' => 'required',
            'reason' => 'required|string',
            'leave_duration' => 'required',
        ]);

        $user_id = auth()->id();

        Leave::create([
            'user_id' => $user_id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
            'status' => 'pending',
            'leave_duration' => $request->leave_duration,
          
        ]);
        return redirect('/leaveRecord')->with('success', 'Leave applied successfully wait for Approved');
    }

    public function leaveRecord()
    {
        $user_id = auth()->id();
        //$pendingLeaves = Leave::where('status', 'pending')->get();
        //$approvedLeaves = Leave::where('status', 'approved')->get();
        //$cancelledLeaves = Leave::where('status', 'cancelled')->get();
      $pendingLeaves = Leave::where('user_id', $user_id)
            ->where('status', 'pending')
            ->get();

        $approvedLeaves = Leave::where('user_id', $user_id)
            ->where('status', 'approved')
            ->get();

        $cancelledLeaves = Leave::where('user_id', $user_id)
            ->where('status', 'cancelled')
            ->get();
        return view('user.leaveRecord',compact('pendingLeaves','approvedLeaves','cancelledLeaves'));
    }
    public function profilepage(){
        $user = auth()->user();
        $data = User::find($user->id);
        // dd($data);
        return view('user.profile', compact('user',"data"));
     }
  
     public function documentspage()
    {
        $id = auth()->user()->id;
        $documents = Document::where('user_id', $id)
        ->with('uploadedBy')
        ->latest()->get();
        // dd($documents);
        return view('user.document',compact('id','documents'));
    }
}
