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
                                <div class="d-flex justify-content-between align-items-center mb-3"
                                    style="background: #dde2e8; padding: 10px; border-radius: 5px">
                                    <a href="{{ url()->previous() }}" class="btn btn-primary">
                                        <i class="fa-solid fa-angle-left" style="margin-right: 3px"></i>
                                        Back
                                    </a>
                                    <h2 class="card-title fw-bold text-primary mb-0">Task Report</h2>
                                    <h2 class="card-title fw-bold text-primary mb-0"></h2>
                                </div>
                                {{-- <h2 class="card-title">Task Report</h2> --}}
                                <form action="{{ route('taskreport.search') }}" method="POST" id="employee-form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="project_id">Select Project:</label>
                                            <select name="project_id" id="project_id" class="form-control"
                                                onchange="this.form.submit()">
                                                <option value="">-- All Projects --</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}"
                                                        {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                                        {{ $project->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="status">Select Employee:</label>
                                            <select name="status" id="status" class="form-control"
                                                onchange="this.form.submit()">
                                                <option value="">-- All Employees --</option>
                                                @foreach ($user as $u)
                                                    <option value="{{ $u->id }}"
                                                        {{ request('status') == $u->id ? 'selected' : '' }}>
                                                        {{ $u->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="start_date">From:</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ $startDate }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label for="end_date">To:</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ $endDate }}">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Search</button>

                                </form>
                                <br>

                                @if ($tasks->isNotEmpty())
                                    <h3 class="card-title">Filtered Tasks</h3>
                                    <!-- Responsive Table Wrapper -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered align-middle text-left">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col" class="text-left text-nowrap">ID</th>
                                                    <th scope="col" class="text-left text-nowrap">Project</th>
                                                    <th scope="col" class="text-left text-nowrap">Title</th>
                                                    <th scope="col" class="text-left text-nowrap">Description</th>
                                                    <th scope="col" class="text-left text-nowrap">Time </th>
                                                    <th scope="col" class="text-left text-nowrap">Status</th>
                                                    <th scope="col" class="text-left text-nowrap">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tasks as $task)
                                                    <tr>
                                                        <td class="text-left text-nowrap">{{ $task->id }}</td>
                                                        <td class="text-left text-nowrap">{{ $task->project_name }}
                                                        </td>
                                                        <td class="text-left text-nowrap">{{ $task->title }}</td>
                                                        {{-- <td class="text-left text-nowrap">{{ $task->description }}</td> --}}
                                                        {{-- <td class="text-left text-nowrap">{{ $task->descriptionbyuser }}</td> --}}
                                                        <td class="text-left text-nowrap">
                                                            <div class="tooltip-container">
                                                                {{ Str::limit($task->descriptionbyuser, 50, '...') }}
                                                                <span
                                                                    class="tooltip-text">{{ $task->descriptionbyuser }}</span>
                                                            </div>
                                                        </td>
                                                        {{-- <td class="text-left text-nowrap">{{ $task->time_taken ?? "-- : --" }}</td> --}}
                                                        <td class="text-left text-nowrap fw-medium">
                                                            @php
                                                                $hours = floor($task->time_taken / 60);
                                                                $minutes = $task->time_taken % 60;
                                                                $readableTime =
                                                                    ($hours > 0 ? $hours . ' hr' : '') .
                                                                    ($hours > 0 && $minutes > 0 ? ' ' : '') .
                                                                    ($minutes > 0 ? $minutes . ' min' : '');
                                                            @endphp
                                                            {{ $readableTime !== '' ? $readableTime : '-- : --' }}
                                                        </td>
                                                        <td class="text-left text-nowrap">
                                                            {{ $task->status ?? 'Not Worked' }} </td>
                                                        <td class="text-left text-nowrap">
                                                            <!-- View Button with Data Attributes -->
                                                            <button class="btn btn-primary viewTaskBtn px-1 py-1"
                                                                data-id="{{ $task->id }}"
                                                                data-title="{{ $task->title }}"
                                                                data-description="{{ $task->descriptionbyuser }}"
                                                                data-time="{{ $readableTime !== '' ? $readableTime : '-- : --' }}"
                                                                data-status="{{ $task->status }}"
                                                                data-project="{{ $task->project_name }}"
                                                                data-bs-toggle="modal" data-bs-target="#taskModal">
                                                                View
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    @if (request()->isMethod('post'))
                                        <p class="text-center mt-4">No tasks found for the given filters.</p>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('projectmanager.layouts.footer')

        <!-- Bootstrap Modal for Task Details -->
        <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Enlarged modal -->
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white text-center" id="taskModalLabel">Task Details</h5>
                        <div class="closeDataButton">
                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">Project</th>
                                    <td><span id="taskProject"></span></td>
                                </tr>
                                <tr>
                                    <th>Title</th>
                                    <td><span id="taskTitle"></span></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td><span id="taskDescription"></span></td>
                                </tr>
                                <tr>
                                    <th>Time Taken</th>
                                    <td><span id="taskTime"></span></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><span id="taskStatus"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- JavaScript to Populate Modal Data -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.viewTaskBtn').forEach(button => {
                    button.addEventListener('click', function() {
                        document.getElementById('taskProject').textContent = this.getAttribute(
                            'data-project');
                        document.getElementById('taskTitle').textContent = this.getAttribute(
                            'data-title');
                        document.getElementById('taskDescription').textContent = this.getAttribute(
                            'data-description');
                        document.getElementById('taskTime').textContent = this.getAttribute(
                            'data-time') || '-- : --';
                        document.getElementById('taskStatus').textContent = this.getAttribute(
                            'data-status') || 'Not Worked';
                    });
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let startDateInput = document.getElementById("start_date");
                let endDateInput = document.getElementById("end_date");

                // Function to update end date's min value
                function updateEndDateMin() {
                    let selectedStartDate = new Date(startDateInput.value);
                    let minEndDate = new Date(selectedStartDate);
                    minEndDate.setDate(selectedStartDate.getDate()); // End date must be after start date

                    let minEndDateFormatted = minEndDate.toISOString().split('T')[0];
                    endDateInput.setAttribute("min", minEndDateFormatted);

                    // If end date is earlier than allowed min date, update it
                    if (endDateInput.value < minEndDateFormatted) {
                        endDateInput.value = minEndDateFormatted;
                    }
                }

                // Run on page load
                updateEndDateMin();

                // When start date changes, update end date's min value
                startDateInput.addEventListener("change", updateEndDateMin);
            });
        </script>
