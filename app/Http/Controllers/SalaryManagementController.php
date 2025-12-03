<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;

class SalaryManagementController extends Controller
{
    public function salaryuserlist()
    {
        $user = User::get()->where("role", 1);
        return view('admin.salaryuserlist', compact('user'));
    }
    public function genratesalary($id)
    {
        $user = User::findOrFail($id);

        return view('admin.genratesalary', compact('id', 'user'));
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
        return view('admin.genratesalarytemplate', compact('user', 'salary'));
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
            ->route('getsalaryusers', ['id' => $id])
            ->with('success', 'Salary generated successfully for '
                . date('F', mktime(0, 0, 0, $data['month'], 1))
                . ' ' . $data['year'] . '.');
    }

    public function showAllPayslips()
    {

        $id = auth()->id(); // Get the authenticated user's ID
        $user = User::findOrFail($id);
        $salaries = Salary::where('user_id', $id)->orderByDesc('month')->get();
        return view('user.payslip_list', compact('id', 'salaries', 'user'));
    }

    public function viewPayslip($userId, $salaryId)
    {
        $user = User::findOrFail($userId);
        $salary = Salary::where('id', $salaryId)->where('user_id', $userId)->firstOrFail();

        return view('admin.genratesalarytemplate', compact('user', 'salary'));
    }

    public function showAllUsersPayslips($id)
    {
        $user = User::findOrFail($id);
        $salaries = Salary::where('user_id', $id)
            ->orderByDesc('month')
            ->get();
        return view('admin.payslip_list', compact('salaries', 'user'));
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
