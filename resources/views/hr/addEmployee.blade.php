@include('admin.layouts.head')

<style>
    .card-title {
        font-size: 23px !important;
    }

    #dataTables_length {
        margin-bottom: 20px;
    }

    #clientTable_filter {
        margin-bottom: 20px;
    }

    #clientTable_info {
        margin-top: 20px;
    }


    #clientTable_paginate {
        margin-top: 20px;
    }
</style>

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('hr.layouts.sidebar')

        <div class="body-wrapper ">

            @include('hr.layouts.header')

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            <div class="card-body">
                                <div class="form-container">
                                    <div class="mb-4">
                                        <h2 class="card-title">Add New Employee</h2>
                                    </div>
                                    <form action="/hr-postemployee" method="POST" id="employee-form">
                                        @csrf

                                        <div class="row">
                                            <!-- Name -->
                                            <div class="col-md-4 mb-4">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                    placeholder="Enter employee's name" required>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-4 mb-4">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Enter employee's email" required>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <label for="role" class="form-label">Role</label>
                                                <select id="role" class="form-select" name="role" required>
                                                    <option value="">Select Role</option>
                                                    <option value="0">Admin</option>
                                                    <option value="1">User</option>
                                                    <option value="2">Project Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>

                                            <div class="row">
                                                <!-- Department -->
                                                <div class="col-md-4 mb-4">
                                                    <label for="department" class="form-label">Department</label>
                                                    <select id="department" class="form-select" name="department"
                                                        required>
                                                        <option value="">Select Department</option>

                                                        <optgroup label="👤 User Departments">
                                                            <option value="IT">IT</option>
                                                            <option value="Developer">Developer</option>
                                                            <option value="QA/Testing">QA/Testing</option>
                                                            <option value="Finance">Finance</option>
                                                            <option value="Customer Support">Customer Support</option>
                                                            <option value="Marketing">Marketing</option>
                                                            <option value="Design">Design</option>
                                                            <option value="Content">Content</option>
                                                        </optgroup>

                                                        <optgroup label="🧑‍💼 HR Departments">
                                                            <option value="Human Resources">Human Resources</option>
                                                            <option value="Recruitment">Recruitment</option>
                                                            <option value="Training & Development">Training &
                                                                Development</option>
                                                            <option value="Administration">Administration</option>
                                                        </optgroup>

                                                        <optgroup label="📋 Project Manager Departments">
                                                            <option value="Operations">Operations</option>
                                                            <option value="Business Development">Business Development
                                                            </option>
                                                            <option value="Product Management">Product Management
                                                            </option>
                                                            <option value="Quality Assurance">Quality Assurance</option>
                                                            <option value="IT">IT</option>
                                                            <option value="Developer">Developer</option>
                                                        </optgroup>

                                                    </select>
                                                </div>


                                                <!-- Date of Joining -->
                                                <div class="col-md-4 mb-4">
                                                    <label for="date_of_joining" class="form-label">Date of
                                                        Joining</label>
                                                    <input type="date" id="date_of_joining" class="form-control"
                                                        name="date_of_joining" required>
                                                </div>
                                                <!-- Birthday -->
                                                <div class="col-md-4 mb-4">
                                                    <label for="date_of_birth" class="form-label">Birthday</label>
                                                    <input type="date" id="date_of_birth" class="form-control"
                                                        name="date_of_birth" required>
                                                </div>
                                            </div>


                                            <div class="row">

                                                <!-- Password -->
                                                <div class="col-md-4 mb-4">
                                                    <label for="password" class="form-label">Create Password</label>
                                                    <input type="password" id="password" class="form-control"
                                                        name="password" placeholder="Enter a secure password" required>
                                                </div>
                                                <!-- Confirm Password -->
                                                <div class="col-md-4 mb-4">
                                                    <label for="conform_password" class="form-label">Confirm
                                                        Password</label>
                                                    <input type="password" id="conform_password" class="form-control"
                                                        name="conform_password" placeholder="Confirm password"
                                                        required>
                                                </div>

                                                <!-- Actions -->
                                                <div style="padding-top: 24px;" class="col-md-4 mb-4">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
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

        @include('hr.layouts.footer')
        <script>
            function formatDate(input) {
                const value = input.value;

                if (value) {
                    const dateParts = value.split('-');
                    const day = dateParts[2];
                    const month = dateParts[1];
                    const year = dateParts[0];

                    // Format to dd/mm/yyyy
                    input.value = `${day}/${month}/${year}`;
                }
            }
        </script>
