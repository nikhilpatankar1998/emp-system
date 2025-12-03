@include('hr.layouts.head')

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('hr.layouts.sidebar')

        <div class="body-wrapper">

            @include('hr.layouts.header')

            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-container">
                                        <div class="mb-4">
                                            <h2>Update Employee Details</h2>
                                        </div>
                                        <form action="{{ route('hr.employee.update', $employee->id) }}" method="POST"
                                            id="employee-form">
                                            @csrf
                                            @method('POST')

                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" id="name" class="form-control"
                                                        name="name" value="{{ old('name', $employee->name) }}"
                                                        placeholder="Enter employee's name" required>
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" value="{{ old('email', $employee->email) }}"
                                                        placeholder="Enter employee's email" required>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label for="role" class="form-label">Role</label>
                                                    <select id="role" class="form-select" name="role" required>
                                                        <option value="">Select Role</option>
                                                        <option value="0"
                                                            {{ $employee->role == 0 ? 'selected' : '' }}>
                                                            Admin</option>
                                                        <option value="1"
                                                            {{ $employee->role == 1 ? 'selected' : '' }}>
                                                            User</option>
                                                        <option value="2"
                                                            {{ $employee->role == 2 ? 'selected' : '' }}>
                                                            Project Manager</option>
                                                        <option value="3"
                                                            {{ $employee->role == 3 ? 'selected' : '' }}>
                                                            HR</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <label for="department" class="form-label">Department</label>
                                                    <select id="department" class="form-select" name="department"
                                                        required>
                                                        <option value="">Select Department</option>

                                                        <optgroup label="👤 User Departments">
                                                            <option value="IT"
                                                                {{ old('department', $employee->department) == 'IT' ? 'selected' : '' }}>
                                                                IT</option>
                                                            <option value="Developer"
                                                                {{ old('department', $employee->department) == 'Developer' ? 'selected' : '' }}>
                                                                Developer</option>
                                                            <option value="QA/Testing"
                                                                {{ old('department', $employee->department) == 'QA/Testing' ? 'selected' : '' }}>
                                                                QA/Testing</option>
                                                            <option value="Finance"
                                                                {{ old('department', $employee->department) == 'Finance' ? 'selected' : '' }}>
                                                                Finance</option>
                                                            <option value="Customer Support"
                                                                {{ old('department', $employee->department) == 'Customer Support' ? 'selected' : '' }}>
                                                                Customer Support</option>
                                                            <option value="Marketing"
                                                                {{ old('department', $employee->department) == 'Marketing' ? 'selected' : '' }}>
                                                                Marketing</option>
                                                            <option value="Design"
                                                                {{ old('department', $employee->department) == 'Design' ? 'selected' : '' }}>
                                                                Design</option>
                                                            <option value="Content"
                                                                {{ old('department', $employee->department) == 'Content' ? 'selected' : '' }}>
                                                                Content</option>
                                                        </optgroup>

                                                        <optgroup label="🧑‍💼 HR Departments">
                                                            <option value="Human Resources"
                                                                {{ old('department', $employee->department) == 'Human Resources' ? 'selected' : '' }}>
                                                                Human Resources</option>
                                                            <option value="Recruitment"
                                                                {{ old('department', $employee->department) == 'Recruitment' ? 'selected' : '' }}>
                                                                Recruitment</option>
                                                            <option value="Training & Development"
                                                                {{ old('department', $employee->department) == 'Training & Development' ? 'selected' : '' }}>
                                                                Training & Development</option>
                                                            <option value="Administration"
                                                                {{ old('department', $employee->department) == 'Administration' ? 'selected' : '' }}>
                                                                Administration</option>
                                                        </optgroup>

                                                        <optgroup label="📋 Project Manager Departments">
                                                            <option value="Operations"
                                                                {{ old('department', $employee->department) == 'Operations' ? 'selected' : '' }}>
                                                                Operations</option>
                                                            <option value="Business Development"
                                                                {{ old('department', $employee->department) == 'Business Development' ? 'selected' : '' }}>
                                                                Business Development</option>
                                                            <option value="Product Management"
                                                                {{ old('department', $employee->department) == 'Product Management' ? 'selected' : '' }}>
                                                                Product Management</option>
                                                            <option value="Quality Assurance"
                                                                {{ old('department', $employee->department) == 'Quality Assurance' ? 'selected' : '' }}>
                                                                Quality Assurance</option>
                                                            <option value="IT"
                                                                {{ old('department', $employee->department) == 'IT' ? 'selected' : '' }}>
                                                                IT</option>
                                                            <option value="Developer"
                                                                {{ old('department', $employee->department) == 'Developer' ? 'selected' : '' }}>
                                                                Developer</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label for="date_of_joining" class="form-label">Date of
                                                        Joining</label>
                                                    <input type="date" id="date_of_joining" class="form-control"
                                                        name="date_of_joining"
                                                        value="{{ old('date_of_joining', $employee->date_of_joining) }}"
                                                        required>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label for="date_of_birth" class="form-label">Birthday</label>
                                                    <input type="date" id="date_of_birth" class="form-control"
                                                        name="date_of_birth"
                                                        value="{{ old('date_of_birth', $employee->date_of_birth) }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <label for="password" class="form-label">New Password
                                                        (Optional)</label>
                                                    <input type="password" id="password" class="form-control"
                                                        name="password"
                                                        placeholder="Leave blank if you don't want to change the password">
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label for="conform_password" class="form-label">Confirm
                                                        Password</label>
                                                    <input type="password" id="conform_password" class="form-control"
                                                        name="conform_password"
                                                        placeholder="Leave blank if you don't want to change the password">
                                                </div>

                                                <div class="col-md-4 mb-4 d-flex align-items-end">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                    <button type="reset"
                                                        class="btn btn-secondary ms-2">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@include('hr.layouts.footer')
