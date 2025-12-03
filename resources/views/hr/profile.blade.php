@include('admin.layouts.head')

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('admin.layouts.sidebar')

        <div class="body-wrapper">

            @include('admin.layouts.header')

            <div class="container-fluid">
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-container">
                                        <div class="mb-4">
                                            <h2>My Profile</h2>
                                        </div>
                                        <form action="{{ route('admin.profile.update') }}" method="POST"
                                            id="employee-form">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" id="name" class="form-control"
                                                        name="name" value="{{ old('name', $data->name) }}"
                                                        placeholder="Enter employee's name" required>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" value="{{ old('email', $data->email) }}"
                                                        placeholder="Enter employee's email" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="department" class="form-label">Department</label>
                                                    <select id="department" class="form-select" name="department"
                                                        required>
                                                        <option value="">Select Department</option>
                                                        <option value="IT"
                                                            {{ old('department', $data->department) == 'IT' ? 'selected' : '' }}>
                                                            IT</option>
                                                        <option value="Human Resources"
                                                            {{ old('department', $data->department) == 'Human Resources' ? 'selected' : '' }}>
                                                            Human Resources</option>
                                                        <option value="Developer"
                                                            {{ old('department', $data->department) == 'Developer' ? 'selected' : '' }}>
                                                            Developer</option>
                                                        <option value="Marketing"
                                                            {{ old('department', $data->department) == 'Marketing' ? 'selected' : '' }}>
                                                            Marketing</option>
                                                        <option value="Finance"
                                                            {{ old('department', $data->department) == 'Finance' ? 'selected' : '' }}>
                                                            Finance</option>
                                                        <option value="Operations"
                                                            {{ old('department', $data->department) == 'Operations' ? 'selected' : '' }}>
                                                            Operations</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label for="date_of_joining" class="form-label">Date of
                                                        Joining</label>
                                                    <input type="date" id="date_of_joining" class="form-control"
                                                        name="date_of_joining"
                                                        value="{{ old('date_of_joining', $data->date_of_joining) }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="date_of_birth" class="form-label">Birthday</label>
                                                    <input type="date" id="date_of_birth" class="form-control"
                                                        name="date_of_birth"
                                                        value="{{ old('date_of_birth', $data->date_of_birth) }}"
                                                        required>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label for="password" class="form-label">New Password
                                                        (Optional)</label>
                                                    <input type="password" id="password" class="form-control"
                                                        name="password"
                                                        placeholder="Leave blank if you don't want to change the password">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="conform_password" class="form-label">Confirm
                                                        Password</label>
                                                    <input type="password" id="confirm_password" class="form-control"
                                                        name="confirm_password"
                                                        placeholder="Leave blank if you don't want to change the password">
                                                </div>

                                                <div class="col-md-6 mb-4 d-flex align-items-end">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                    <button type="reset" class="btn btn-secondary ms-2">Reset</button>
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
@include('admin.layouts.footer')
