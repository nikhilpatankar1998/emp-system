@include('admin.layouts.head')
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

.btn-close.white-close {
    filter: invert(1) !important;
}

  .closeDataButton {
        background-color: white;
        border-radius: 5px;
    }

    .closeDataButton .btn-close {
        filter: none; /* ensures image is visible if previously altered */
        opacity: 1;
        margin: 0 auto;
    }
  
.tooltip-text {
    
  }
  
  .table-responsive {
    overflow-x: visible !important;
  }
  
  .tooltip-texts {
  visibility: hidden;
  background-color: #093862;
  color: #fff;
  text-align: center;
  border-radius: 5px;
  padding: 8px;
  position: absolute;
   z-index: 999999; /* ensure it's above all elements */
  top: calc(100% + 8px);
  left: 0%;
  transform: translateX(-50%);
  opacity: 0;
  transition: opacity 0.3s;
  white-space: normal !important;
  width: 600px;
    z-index: 999999 !important;
  background-color: #093862 !important;
  color: #fff !important;
  text-align: left;
    padding: 20px;
}

.tooltip-container:hover .tooltip-texts {
  visibility: visible;
  opacity: 1;
}


.modal-content {
    max-height: 90vh;
  }

.modal-body {
    overflow-y: auto;
    flex: 1;
}
  
.titlewidth{
  width: 300px;
  }

.body-wrapper .app-header{
  width: calc(100% - 270px) !important;
  }

.body-wrapper.collapsed-sidebar .app-header{
  width: calc(100% - 80px) !important;
  }


 #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper .app-header {
    width: calc(100% - 270px) !important;
    transition: all 0.3s ease !important;
  }

  #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper.collapsed-sidebar .app-header {
    width: calc(100% - 80px) !important;
    transition: all 0.3s ease !important;
  }

 /* Header when sidebar collapsed */
    #main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .body-wrapper.collapsed-sidebar .app-header {
    width: calc(100% - 270px) !important;
  }
  

  /* Header when sidebar collapsed */
    #main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .app-header {
    width: calc(100% - 270px) !important;
  }

  /* Body wrapper default */
  .body-wrapper {
    margin-left: 270px !important;
    transition: all 0.3s ease !important;
  }

  /* Body wrapper when sidebar collapsed */
  .body-wrapper.collapsed-sidebar {
    margin-left: 80px !important;
  }

/* Small screens (below 1200px) */
@media (max-width: 1199px) {
  /* Sidebar hidden by default */
  #main-wrapper[data-layout=vertical] .left-sidebar {
    left: -100% !important;
    transition: all 0.3s ease !important;
  }

  /* Sidebar shown (mobile toggle) */
  #main-wrapper[data-layout=vertical].show-sidebar .left-sidebar {
    left: 0 !important;
  }
  
  .body-wrapper {
    margin-left: auto !important;
    transition: all 0.3s ease !important;
  }
  .app-header{
  width: 100% !important;
  }

   #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper .app-header {
    width: 100% !important;
    transition: all 0.3s ease !important;
  }

  #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper.collapsed-sidebar .app-header {
    width: 100% !important;
    transition: all 0.3s ease !important;
  }

  

  /* Header when sidebar collapsed */
    #main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .app-header {
    width: 100% !important;
  }

.body-wrapper .app-header{
  width: 100% !important;
  }

.body-wrapper.collapsed-sidebar .app-header{
  width: 100% !important;
  }

.body-wrapper {
    margin-left: auto !important;
    transition: all 0.3s ease !important;
  }

  /* Body wrapper when sidebar collapsed */
  .body-wrapper.collapsed-sidebar {
    margin-left: auto !important;
  }

#main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .body-wrapper.collapsed-sidebar .app-header {
    width: 100% !important; 
}

.left-sidebar.collapsed {
    width: 100% !important;
}

}
</style>
<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('admin.layouts.sidebar')

        <div class="body-wrapper">

            @include('admin.layouts.header')

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
                               
<div
  class="d-flex justify-content-between align-items-center mb-3"
  style="background: #dde2e8; padding: 10px; border-radius: 5px"
>
  <a href={{ url()->previous() }} class="btn btn-primary">
    <i class="fa-solid fa-angle-left" style="margin-right: 3px"></i>
    Back
  </a>
  <h2
    class="card-title fw-bold text-primary mb-0"
    style="margin-bottom: 0px !important"
  >
    Task Report
  </h2>
  <h2 class="card-title fw-bold text-primary"></h2>
</div>
                                <!-- Employee Table -->
                                <form action="{{ route('taskreport.fetch') }}" method="POST" id="employee-form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <label for="start_date" class="form-label">Select Date</label>
                                            <div><input type="date" id="start_date"  class="form-control"
                                                    name="start_date" value="{{ old('start_date', $startDate ?? '')}}" required  ></div>
                                        </div>
                                        
                                        <div class="col">
                                            <label for="end_date" class="form-label">To Date</label>
                                            <div>
                                                <input type="date" id="end_date"  class="form-control" name="end_date" 
                                                 value="{{ old('end_date', $endDate ?? '') }}">
                
                                            </div>
                                        </div>

                                        <div class="col">
                                            <label for="status" class="form-label">Select Employee</label>
                                            <div><select id="status" class="form-select" name="status" required>
                                                    @foreach ($user as $item)
                                                        {{-- <option value="{{ $item->id }}">{{ $item->name }}</option> --}}
                                                        <option value="{{ $item->id }}"
                                                            {{ old('status', $selectedUser ?? '') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>
                                <br>

                                @if ($tasks->isNotEmpty())
                                 
<div class="d-flex justify-content-center align-items-center mb-3" style="
                                    background: #dde2e8;
                                    padding: 8px 10px;
                                    border-radius: 5px;
                                ">
                                
                                <h2 class="card-title fw-bold text-primary mb-0" style="margin-bottom: 0px !important">
                                Filtered Tasks
                                </h2>
                                </div>
                                    <!-- Responsive Table Wrapper -->
                                           <div class="table-responsive">
  <table class="table table-hover table-bordered align-middle text-left">
                                                <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-left text-nowrap">ID</th>
                                                <th scope="col" class="text-left text-nowrap">Project</th>
                                                <th scope="col" class="text-left text-nowrap titlewidth">Title</th>
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
                                                    <td class="text-left text-nowrap">{{ $task->project_name }}</td>
                                                    <td class="text-left text-normal">{{ $task->title }}</td>
                                                    {{-- <td class="text-left text-nowrap">{{ $task->description }}</td> --}}
                                                    {{-- <td class="text-left text-nowrap">{{ $task->descriptionbyuser }}</td> --}}
                                                    {{--<td class="text-left text-normal">
                                                        <div class="tooltip-container">
                                                            {{ Str::limit($task->descriptionbyuser, 45, '...') }}
                                                            <span class="tooltip-text">{{ $task->descriptionbyuser }}</span>
                                                        </div>
                                                    </td>--}}
                                                    <td class="text-left text-normal">
                                                        <div class="tooltip-container">
                                                            {{ Str::limit($task->descriptionbyuser, 45, '...') }}

                                                            @php
                                                                $wordCount = str_word_count($task->descriptionbyuser);
                                                            @endphp

                                                            <span class="tooltip-texts">
                                                                 {{--  {!! nl2br(e(str_replace('- ', '• ', $task->descriptionbyuser))) !!}--}}
                                                              {{ $task->descriptionbyuser }}
                                                            </span>
                                                        </div>
                                                    </td>

                                                    {{-- <td class="text-left text-nowrap">{{ $task->time_taken ?? "-- : --" }}</td> --}}
                                                    <td class="text-left text-nowrap fw-medium">
                                                        @php
                                                            $hours = floor($task->time_taken / 60);
                                                            $minutes = $item->task % 60;
                                                            $readableTime = ($hours > 0 ? $hours . ' hr' : '') . 
                                                                            ($hours > 0 && $minutes > 0 ? ' ' : '') . 
                                                                            ($minutes > 0 ? $minutes . ' min' : '');
                                                        @endphp
                                                        {{ $readableTime !== '' ? $readableTime : '-- : --' }}
                                                    </td>
                                                    <td class="text-left text-nowrap">{{ $task->status ?? "Not Worked"}} </td>
                                                    <td class="text-left text-nowrap">
                                                        <!-- View Button with Data Attributes -->
                                                        <button class="btn btn-primary viewTaskBtn" 
                                                            data-id="{{ $task->id }}"
                                                            data-title="{{ $task->title }}"
                                                            data-description="{{ $task->descriptionbyuser }}"
                                                            data-time="{{ $readableTime !== '' ? $readableTime : '-- : --' }}"
                                                            data-status="{{ $task->status }}"
                                                            data-project="{{ $task->project_name }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#taskModal">
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
        @include('admin.layouts.footer')
        <!-- Bootstrap Modal for Task Details -->
<!-- Bootstrap Modal for Task Details -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Enlarged modal -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white text-center" id="taskModalLabel">Task Details</h5>
                <div class="closeDataButton">
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button></div>
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
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.viewTaskBtn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('taskProject').textContent = this.getAttribute('data-project');
                document.getElementById('taskTitle').textContent = this.getAttribute('data-title');
                document.getElementById('taskDescription').innerHTML = formatDescription(this.getAttribute('data-description'));
                document.getElementById('taskTime').textContent = this.getAttribute('data-time') || '-- : --';
                document.getElementById('taskStatus').textContent = this.getAttribute('data-status') || 'Not Worked';
            });
        });
    });
</script>
<script>
function formatDescription(description) {
    if (!description) return '';
    
    // Replace new lines with <br> and `-` with bullet point
    return description
        .split('\n')
        .map(line => {
            line = line.trim();
            if (line.startsWith('-')) {
                return '• ' + line.substring(1).trim();
            }
            return line;
        })
        .join('<br>');
}
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
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
