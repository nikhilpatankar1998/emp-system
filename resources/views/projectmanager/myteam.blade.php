@include('projectmanager.layouts.head')

<style>
    #employeeTable_wrapper {
        margin-bottom: 20px;
    }

    #employeeTable_length {
        margin-bottom: 20px;
    }

    #employeeTable_info {
        margin-top: 20px;
    }


    #employeeTable_paginate {
        margin-top: 20px;
    }

    @media screen and (max-width: 640px) {

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            float: none;
            text-align: left !important;
        }
    }

    @media screen and (max-width: 640px) {
        div.dt-buttons {
            float: none !important;
            text-align: start !important;
        }
    }
</style>

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
                                {{-- <h2 class="text-left" style="font-size:23px; margin-bottom:25px">My Team Members</h2> --}}
                                <h2 class="text-left mb-4">Team Members and Projects</h2>
                                <div class="row">
                                    @foreach ($data as $project)
                                        <div class="col-md-6 mb-4">
                                            <div class="card shadow-sm border">
                                                <div class="card-header bg-secondary text-white">
                                                    <h4 class="mb-2">{{ $project->name }}</h4>
                                                    <div>
                                                        <span class="badge bg-light text-dark me-2">Start:
                                                            {{ $project->start_date }}</span>
                                                        <span class="badge bg-light text-dark">End:
                                                            {{ $project->end_date }}</span>
                                                        <span class="badge bg-light text-dark">Status:
                                                            {{ ucfirst($project->status) }}</span>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        {{-- <div class="col-md-4">
                                                            <p><strong>Start Date:</strong> {{ $project->start_date }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p><strong>End Date:</strong> {{ $project->end_date }}</p>
                                                        </div> --}}
                                                        {{-- <div class="col-md-4">
                                                            <p><strong>Status:</strong> {{ ucfirst($project->status) }}
                                                            </p>
                                                        </div> --}}
                                                        <div class="col-md-12">
                                                            <p><strong>Client url:</strong> {{ $project->client_url }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p><strong>Server url:</strong> {{ $project->server_url }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p><strong>Description: </strong>
                                                                {{ $project->description }}</p>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <h6 class="text-muted">Team Members</h6>
                                                    @php
                                                        $employeeIds = json_decode($project->employees, true);
                                                        $employees = \App\Models\User::whereIn(
                                                            'id',
                                                            $employeeIds,
                                                        )->get();
                                                    @endphp

                                                    <div class="row">
                                                        @forelse ($employees as $employee)
                                                            {{-- <div class="col-md-6 col-sm-12 mb-2">
                                                                <div class="border rounded p-2">
                                                                    <strong>{{ $employee->name }}</strong><br>
                                                                    <small
                                                                        class="text-muted">{{ $employee->email }}</small>
                                                                </div>
                                                            </div> --}}
                                                            <div class="col-md-6 col-sm-12 mb-2">
                                                                <div class="border rounded p-3 employee-card"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#employeeModal"
                                                                    data-name="{{ $employee->name }}"
                                                                    data-email="{{ $employee->email }}"
                                                                    data-department="{{ $employee->department }}"
                                                                    data-dob="{{ $employee->date_of_birth }}"
                                                                    data-doj="{{ $employee->date_of_joining }}"
                                                                    data-role="{{ ucfirst($employee->role) }}">
                                                                    <strong>{{ $employee->name }}</strong><br>
                                                                    <small
                                                                        class="text-muted">{{ $employee->email }}</small>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <p class="text-danger">No team members assigned.</p>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Modal -->
                                <!-- Employee Detail Modal -->
                                <div class="modal fade" id="employeeModal" tabindex="-1"
                                    aria-labelledby="employeeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="employeeModalLabel">Team Member Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <hr>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Name:</strong> <span id="empName"></span></p>
                                                        <p><strong>Email:</strong> <span id="empEmail"></span></p>
                                                        <p><strong>Department:</strong> <span id="empDepartment"></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Date of Birth:</strong> <span id="empDOB"></span>
                                                        </p>
                                                        <p><strong>Date of Joining:</strong> <span
                                                                id="empDOJ"></span></p>
                                                        <p><strong>Role:</strong> <span id="empRole"></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
@include('projectmanager.layouts.footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.employee-card');

        cards.forEach(card => {
            card.addEventListener('click', function() {
                document.getElementById('empName').textContent = this.dataset.name;
                document.getElementById('empEmail').textContent = this.dataset.email;
                document.getElementById('empDepartment').textContent = this.dataset.department;
                document.getElementById('empDOB').textContent = this.dataset.dob;
                document.getElementById('empDOJ').textContent = this.dataset.doj;
                document.getElementById('empRole').textContent = this.dataset.role;
            });
        });
    });
</script>
