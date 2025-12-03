@include('projectmanager.layouts.head')

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('projectmanager.layouts.sidebar')

        <div class="body-wrapper">

            @include('projectmanager.layouts.header')

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
                                <div class="form-container">
                                    <div class="mb-4">
                                        <h2>Update Details</h2>
                                    </div>
                                    <form action="{{ route('update-projects', $data->id) }}" method="POST"
                                        id="employee-form" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $data->id }}">

                                        <div class="row">
                                            <div class="col-md-4 mb-4">
                                                <label for="status" class="form-label">Client Name</label>
                                                <select id="client_id" class="form-select" name="client_id" required>
                                                    @foreach ($clients as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('client_id', $data->client_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->full_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Project Name -->
                                            <div class="col-md-4 mb-4">
                                                <label for="name" class="form-label">Project Name</label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                    value="{{ $data->name }}" required>
                                            </div>

                                            <!-- Start Date -->
                                            <div class="col-md-4 mb-4">
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="date" id="start_date" class="form-control"
                                                    name="start_date" value="{{ $data->start_date }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- End Date -->
                                            <div class="col-md-4 mb-4">
                                                <label for="end_date" class="form-label">End Date</label>
                                                <input type="date" id="end_date" class="form-control"
                                                    name="end_date" value="{{ $data->end_date }}" required>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-4 mb-4">
                                                <label for="status" class="form-label">Status</label>
                                                <select id="status" class="form-select" name="status" required>
                                                    <option value="{{ $data->status }}">{{ $data->status }}</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="project_manager_id" class="form-label">Select Project
                                                    Manager</label>
                                                <select name="project_manager_id" id="project_manager_id"
                                                    class="form-select">
                                                    <option value="">---- Select ----</option>
                                                    @foreach ($projectManager as $employee)
                                                        <option value="{{ $employee->id }}"
                                                            {{ $employee->id == $data->project_manager_id ? 'selected' : '' }}>
                                                            {{ $employee->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Assign Employees -->
                                        <div class="mb-4">
                                            <label for="employees" class="form-label">Assign Employees</label>
                                            <div class="row">
                                                @foreach ($employees as $employee)
                                                    <div class="col-md-3 col-sm-6 col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="employees[]" value="{{ $employee->id }}"
                                                                id="employee_{{ $employee->id }}"
                                                                {{ in_array($employee->id, json_decode($data->employees) ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="employee_{{ $employee->id }}">
                                                                {{ $employee->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- URLs -->
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label for="server_url" class="form-label">Server URL</label>
                                                <input type="url" id="server_url" class="form-control"
                                                    name="server_url" value="{{ $data->server_url }}"
                                                    placeholder="Enter URL">
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="client_url" class="form-label">Client URL</label>
                                                <input type="url" id="client_url" class="form-control"
                                                    name="client_url" value="{{ $data->client_url }}"
                                                    placeholder="Enter URL">
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-4">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" class="form-control" cols="30" rows="5" required>{{ $data->description }}</textarea>
                                        </div>

                                        <!-- Actions -->
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
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
</body>
@include('projectmanager.layouts.footer')
