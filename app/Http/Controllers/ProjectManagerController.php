<?php

namespace App\Http\Controllers;

use App\Models\Broadcast;
use App\Models\client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectManagerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = auth()->id();
        $projectCount = Project::where('project_manager_id', $userId)->count();
        $tasks = Task::get()->where('task_date', date('Y-m-d'))->where('assigned_to', $userId)->count();
        $completedtasks = Task::get()->where('task_date', date('Y-m-d'))->where('status', 'completed')->where('assigned_to', $userId)->count();
        $incompleteTasks  = Task::get()->where('task_date', date('Y-m-d'))->where('status', '!=', 'completed')->where('assigned_to', $userId)->count();
        // dd($completedtasks);
        $projects = Project::where('project_manager_id', $user->id)->get();
        // dd($projects,$user);
        //for broadcaste.
        $today = Carbon::today()->toDateString();
        $broadcast = Broadcast::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->latest()
            ->first();
        return view('projectmanager.dashboard', compact('projects', 'user', 'projectCount', 'tasks', 'completedtasks', 'incompleteTasks', 'broadcast'));
    }
    public function addprojects()
    {
        $clients = client::all();
        $employees = User::get()->where("role", 1);
        $projectManager = User::get()->where("role", 2);

        return view('projectmanager.projects', compact('employees', 'clients', 'projectManager'));
    }

    public function storeproject(Request $request)
    {
        $employee = User::get()->where("role", 2);
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
            'project_manager_id' => 'required|exists:users,id',
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
            'project_manager_id' => $request->input('project_manager_id'),
        ]);
        // $project->employees()->attach($request->input('employees'));
        return redirect('/project-list')->with('success', 'Project created successfully!');
    }
    public function projectlists()
    {
        $user = auth()->id();
        $data = Project::where('project_manager_id', $user)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('projectmanager.projectlist', compact('data'));
    }
    public function viewprojects($id)
    {
        // Fetch project data
        $employees = User::get()->where("role", 1);
        $data = Project::findOrFail($id);
        // dd($data);
        return view('projectmanager.viewproject', compact('data', 'employees'));
    }
    public function editprojects($id)
    {
        // Fetch project data
        $employees = User::get()->where("role", 1);
        $projectManager = User::get()->where("role", 2);
        // $data = Project::findOrFail($id);
        $data = Project::join('clients', 'projects.client_id', '=', 'clients.id')
            ->select('projects.*', 'clients.full_name as client_name')
            ->where('projects.id', $id)
            ->firstOrFail();
        // dd($data);
        $clients = client::get();
        return view('projectmanager.editProject', compact('data', 'employees', 'clients', 'projectManager'));
    }
    public function updateProject(Request $request, $id)
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
            'project_manager_id' => 'required|exists:users,id', // Ensure project manager exists
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
        return redirect('/project-list')
            ->with('success', 'Project Details updated successfully!');
    }
    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projectmanager.dashboard')->with('success', 'Project deleted successfully.');
    }

    public function myteam()
    {
        $user = auth()->id();
        $data = Project::where('project_manager_id', $user)
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($data);
        return view('projectmanager.myteam', compact('data'));
    }

    public function projectTask(Request $request)
    {
         $userId = auth()->id();

    // Get only projects under this project manager
    $projects = Project::where('project_manager_id', $userId)->get();

    $selectedProject = $request->project_id;
    $selectedUser = $request->status;

    // Filter users (employees) based on project if selected
    $user = collect(); // default empty
    if ($selectedProject) {
        $project = Project::find($selectedProject);
        if ($project && $project->employees) {
            $employeeIds = json_decode($project->employees, true);
            $user = User::whereIn('id', $employeeIds)->get();
        }
    } else {
        $user = User::where("role", 1)->get(); // fallback: all users with role = 1
    }

    // Handle date filtering
    $startDate = $request->start_date ?? date('Y-m-d');
    $endDate = $request->end_date ?? null;

    $query = DB::table('tasks')
        ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
        ->leftJoin('users', 'tasks.assigned_to', '=', 'users.id')
        ->select(
            'tasks.*',
            'projects.name as project_name',
            'users.name as assigned_user_name'
        );

    if ($startDate && $endDate) {
        $query->whereBetween('tasks.task_date', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->whereDate('tasks.task_date', '>=', $startDate);
    }

    if ($selectedUser) {
        $query->where('tasks.assigned_to', '=', $selectedUser);
    }

    if ($selectedProject) {
        $query->where('tasks.project_id', '=', $selectedProject);
    }

    $tasks = $query->get();
        // dd($tasks);
        return view('projectmanager.projectTask', compact('user', 'projects', 'tasks', 'startDate', 'endDate', 'selectedUser', 'selectedProject'));
    }
    public function taskreportsearch(Request $request)
{
    $userId = auth()->id();

    // Get only projects under this project manager
    $projects = Project::where('project_manager_id', $userId)->get();

    $selectedProject = $request->project_id;
    $selectedUser = $request->status;

    // Filter users (employees) based on project if selected
    $user = collect(); // default empty
    if ($selectedProject) {
        $project = Project::find($selectedProject);
        if ($project && $project->employees) {
            $employeeIds = json_decode($project->employees, true);
            $user = User::whereIn('id', $employeeIds)->get();
        }
    } else {
        $user = User::where("role", 1)->get(); // fallback: all users with role = 1
    }

    // Handle date filtering
    $startDate = $request->start_date ?? date('Y-m-d');
    $endDate = $request->end_date ?? null;

    $query = DB::table('tasks')
        ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
        ->leftJoin('users', 'tasks.assigned_to', '=', 'users.id')
        ->select(
            'tasks.*',
            'projects.name as project_name',
            'users.name as assigned_user_name'
        );

    if ($startDate && $endDate) {
        $query->whereBetween('tasks.task_date', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->whereDate('tasks.task_date', '>=', $startDate);
    }

    if ($selectedUser) {
        $query->where('tasks.assigned_to', '=', $selectedUser);
    }

    if ($selectedProject) {
        $query->where('tasks.project_id', '=', $selectedProject);
    }

    $tasks = $query->get();

    return view('projectmanager.projectTask', compact('user', 'projects', 'tasks', 'startDate', 'endDate', 'selectedUser', 'selectedProject'));
}

}
