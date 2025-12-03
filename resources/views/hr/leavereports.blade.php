<style>
 @media screen and (max-width: 640px) {
    div.dt-buttons {
        float: none !important;
        text-align: start !important;
    }
}
</style>

@include('hr.layouts.head')

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('hr.layouts.sidebar')

        <div class="body-wrapper">

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
                                <h2>Leave Report</h2>
                                <!-- Employee Table -->
                                <form action="{{ route('hr.leavereport') }}" method="POST" id="employee-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row col mb-6">
                                        <div class="col-md-4">
                                            <label for="start_date" class="form-label">Select Date</label>
                                            <div><input type="date" id="start_date" class="form-control"
                                                    name="start_date"
                                                    valu e="{{ old('start_date', \Carbon\Carbon::today()->toDateString()) }}"
                                                    required></div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="end_date" class="form-label">To Date</label>
                                            <div>
                                                <input type="date" id="end_date" class="form-control"
                                                    name="end_date"
                                                    value="{{ old('end_date', \Carbon\Carbon::today()->toDateString()) }}">

                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <label for="month" class="form-label">Select Month</label>
                                            <select id="month" name="month" class="form-select">
                                                <option value="">-- Select Month --</option>
                                                @foreach (range(1, 12) as $m)
                                                    <option value="{{ $m }}"
                                                        {{ old('month') == $m ? 'selected' : '' }}>
                                                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        <div class="col-md-4">
                                            <label for="status" class="form-label">Select Employee</label>
                                            <div><select id="status" class="form-select" name="status" required>
                                                    @foreach ($user as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('status', $selectedUser ?? '') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary mt-4">Search</button>
                                        </div>
                                    </div>
                                </form>
                                <br>

                                {{-- @if ($query->isNotEmpty()) --}}
                                    {{-- <h3>Filtered Tasks</h3> --}}
                              <div class="table-responsive">
                                    <table id="employeeTable" class="table table-bordered text-nowrap align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-start">Employee Name</th>
                                                <th scope="col" class="text-start">From Date</th>
                                                <th scope="col" class="text-start">To Date</th>
                                                <th scope="col" class="text-start">Type</th>
                                                <th scope="col" class="text-start">Duration</th>
                                                <th scope="col" class="text-start">Reason</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($leaveData as $task)
                                                <tr>
                                                    <td class="text-start">{{ $task->name }}</td>
                                                    <td class="text-start">{{ $task->from_date }}</td>
                                                    <td class="text-start">{{ $task->to_date }}</td>
                                                    <td class="text-start">{{ $task->leave_type}}</td>
                                                    <td class="text-start">{{ $task->leave_duration }} </td>
                                                    <td class="text-start" style={width: 80px;}>{{ $task->reason }} </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                              </div>
                                {{-- @else
                                    @if (request()->isMethod('post'))
                                        <p class="text-center mt-4">No tasks found for the given filters.</p>
                                    @endif
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
        <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Enlarged modal -->
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="taskModalLabel">Task Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
