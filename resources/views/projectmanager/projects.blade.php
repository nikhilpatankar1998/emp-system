@include('projectmanager.layouts.head')

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

    @media screen and (max-width: 420px) {

        .datacol-md-4 {

            margin-bottom: 15px;
            width: 100%;
        }
    }


    @media screen and (max-width: 768px) {

        .datacol-md-4 {

            margin-bottom: 15px;
            width: 100%;
        }
    }


    @media screen and (max-width: 1200px) {

        .datacol-md-4 {

            margin-bottom: 15px;
            width: 100%;
        }
    }
</style>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('projectmanager.layouts.sidebar')

        <div class="body-wrapper d-flex flex-column justify-content-between">
            @include('projectmanager.layouts.header')

            <div class="container-fluid" style="padding: 30px !important; height: 100vh">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 0px; margin-top: 80px">
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif @if ($errors->any())
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
                                            <h2 class="text-left card-title">Add Project</h2>
                                        </div>
                                        <form action="{{ route('storeproject') }}" method="POST" id="employee-form"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-md-4 datacol-md-4">
                                                    <label for="status" class="form-label">Company / Contact person
                                                        Name</label>
                                                    <select id="client_id" class="form-select" name="client_id"
                                                        required>
                                                        <option value="">
                                                            Select Company / Contact person name
                                                        </option>
                                                        @foreach ($clients as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->company_name }} / {{ $item->full_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!-- Project Name -->
                                                <div class="col-md-4 datacol-md-4">
                                                    <label for="name" class="form-label">Project Name</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-briefcase" style="color: #686464"></i>
                                                        </span>
                                                        <input type="text" id="name" class="form-control"
                                                            name="name" placeholder="Enter project's name"
                                                            required />
                                                    </div>
                                                </div>

                                                <!-- Start Date -->
                                                <div class="col-md-4 datacol-md-4">
                                                    <label for="start_date" class="form-label">Start Date</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-calendar-alt" style="color: #686464"></i>
                                                        </span>
                                                        <input type="date" id="start_date" class="form-control"
                                                            name="start_date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <!-- End Date -->
                                                <div class="col-md-3 datacol-md-4">
                                                    <label for="end_date" class="form-label">End Date</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-calendar-check" style="color: #686464"></i>
                                                        </span>
                                                        <input type="date" id="end_date" class="form-control"
                                                            name="end_date" required />
                                                    </div>
                                                </div>

                                                <!-- Status -->
                                                <div class="col-md-3 datacol-md-4">
                                                    <label for="status" class="form-label">Status</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-tasks" style="color: #686464"></i>
                                                        </span>
                                                        <select id="status" class="form-select" name="status"
                                                            required>
                                                            <option value="">Select Status</option>
                                                            <option value="Active">Active</option>
                                                            <option value="Inactive">Inactive</option>
                                                            <option value="Completed">Completed</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Server URL -->
                                                <div class="col-md-3 datacol-md-4">
                                                    <label for="server_url" class="form-label">Server URL</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-server" style="color: #686464"></i>
                                                        </span>
                                                        <input type="url" id="server_url" class="form-control"
                                                            name="server_url" placeholder="Enter URL" />
                                                    </div>
                                                </div>

                                                <!-- Client URL -->
                                                <div class="col-md-3 datacol-md-4">
                                                    <label for="client_url" class="form-label">Client URL</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-globe" style="color: #686464"></i>
                                                        </span>
                                                        <input type="url" id="client_url" class="form-control"
                                                            name="client_url" placeholder="Enter URL" />
                                                    </div>
                                                </div>
                                                <!-- project manager -->
                                                <div class="col-md-3 datacol-md-4">
                                                    <label for="client_url" class="form-label">Select Project Manager</label>
                                                    <select name="project_manager_id" id="project_manager_id"
                                                        class="form-select">
                                                        <option value="">---- Select ----</option>
                                                        @foreach ($projectManager as $employee)
                                                            <option value="{{ $employee->id }}" {{ $employee->id == auth()->id() ? 'selected' : '' }} >{{ $employee->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <!-- Assign Employees -->
                                                <div class="col-md-12 mb-3">
                                                    <label for="employees" class="form-label">Assign Employees</label>
                                                    <div class="row">
                                                        @foreach ($employees as $employee)
                                                            <div class="col-md-3 datacol-md-4 col-sm-6 col-12 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="employees[]" value="{{ $employee->id }}"
                                                                        id="employee_{{ $employee->id }}" />
                                                                    <label class="form-check-label"
                                                                        for="employee_{{ $employee->id }}">
                                                                        {{ $employee->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <!-- Description -->
                                                <div class="col-md-12">
                                                    <label for="description" class="form-label">Description</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-align-left" style="color: #686464"></i>
                                                        </span>
                                                        <textarea name="description" id="description" class="form-control" cols="30" placeholder="Description"
                                                            rows="5" required></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary"
                                                    style="border-radius: 8px">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-primary"
                                                    style="border-radius: 8px">
                                                    Reset
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('projectmanager.layouts.footer')
    </div>
</body>
