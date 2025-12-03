@include('hr.layouts.head')
<style>
.card-title {
    font-size: 23px !important;
  margin-bottom: 20px
}

#dataTables_length{
  margin-bottom: 20px;
  }
  
#clientTable_filter {
  margin-bottom: 20px;
  }
  
  #clientTable_info{
  margin-top: 20px;
  }


#clientTable_paginate{
  margin-top: 20px;
  }
</style>
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
                                <h2 class="card-title">Check in Report</h2>
                                <!-- Employee Table -->
                                <form action="{{ route('hr.getCheckInData.fetch') }}" method="POST" id="employee-form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row col mb-6">
                                        <div class="col-md-4">
                                            <label for="start_date" class="form-label">Select Date</label>
                                            <div><input type="date" id="start_date" class="form-control"
                                                    name="start_date" value="{{ old('start_date', $startDate ?? '')}}" required  ></div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="end_date" class="form-label">To Date</label>
                                            <div>
                                                <input type="date" id="end_date" class="form-control" name="end_date" 
                                                       value="{{ old('end_date', $endDate ?? '') }}">
                                            </div>
                                        </div>

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

                                {{-- @if ($tasks->isNotEmpty()) --}}
                                    <h3 class="card-title">Filtered Tasks</h3>
                                 <!-- Responsive Table Wrapper -->
                                           <div class="table-responsive">
                                    <table class="table table-hover table-bordered align-middle text-left ">
                                                <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-left text-nowrap">ID</th>
                                              <th scope="col" class="text-left text-nowrap">Date</th>
                                                <th scope="col" class="text-left text-nowrap">Name</th>
                                                <th scope="col" class="text-left text-nowrap">Check In</th>
                                                <th scope="col" class="text-left text-nowrap">Check Out</th>
                                                <th scope="col" class="text-left text-nowrap">Total Time</th>
                                                {{-- <th scope="col" class="text-left text-nowrap">Desc. by user</th> --}}
                                                {{-- <th scope="col" class="text-left text-nowrap">Time </th> --}}
                                                {{-- <th scope="col" class="text-left text-nowrap">Status</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $task)
                                                <tr>
                                                    <td class="text-left text-nowrap">{{ $task->id }}</td>
                                                    <td class="text-left text-nowrap">{{ \Carbon\Carbon::parse($task->created_at)->format('d M Y') }}</td>
                                                    <td class="text-left text-nowrap">{{ $task->name }}</td>
                                                    <td class="text-center"
                                                    @if ($task->chek_in_time && \Carbon\Carbon::parse($task->chek_in_time)->gt(\Carbon\Carbon::parse('10:15'))) style="color: red;" @endif>
                                                    {{-- {{ $task->chek_in_time ?? '-- : --' }} --}}
                                                        {{ $task->chek_in_time ? \Carbon\Carbon::parse($task->chek_in_time)->format('h:i A') : '-- : --' }}

                                                </td>
                                                    <td class="text-left text-nowrap">{{ $task->check_out_time ?? "-- : --" }}</td>
                                                    {{-- <td class="text-left text-nowrap">{{ $task->total_time ?? "Not Working"}}</td> --}}
                                                    <td class="text-left text-nowrap">
                                                        @php
                                                        $seconds = $task->total_time ?? 0;
                                                        $hours = floor($seconds / 3600);
                                                        $minutes = floor(($seconds % 3600) / 60);
                                                        $remainingSeconds = $seconds % 60;
                                                    @endphp
                                                    
                                                    @if ($seconds == 0)
                                                        Working
                                                    @else
                                                        @if ($hours > 0)
                                                            {{ $hours }}hr
                                                        @endif
                                                        @if ($minutes > 0)
                                                            {{ $minutes }}min
                                                        @endif
                                                        @if ($remainingSeconds > 0)
                                                            {{ $remainingSeconds }}sec
                                                        @endif
                                                    @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                              </div>
                                {{-- @else --}}
                                    {{-- @if (request()->isMethod('post'))
                                        <p class="text-center mt-4">No tasks found for the given filters.</p>
                                    @endif
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('hr.layouts.footer')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let startDateInput = document.getElementById("start_date");
                let endDateInput = document.getElementById("end_date");
        
                // Function to update end date's min value
                function updateEndDateMin() {
                    let selectedStartDate = new Date(startDateInput.value);
                    let minEndDate = new Date(selectedStartDate);
                    minEndDate.setDate(selectedStartDate.getDate() + 1); // End date must be after start date
        
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