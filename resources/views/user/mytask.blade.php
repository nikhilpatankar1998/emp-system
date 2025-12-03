@include('user.layouts.head')

<style>
 .card-title {
    font-size: 22px !important;
    margin-bottom: 30px !important;
}

#employeeTable_wrapper{
  margin-bottom: 20px;
  }
  
#employeeTable_length {
  margin-bottom: 20px;
  }
  
  #employeeTable_info{
  margin-top: 20px;
  }


#employeeTable_paginate{
  margin-top: 20px;
  }
  
  @media screen and (max-width: 640px) {
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter {
        float: none;
        text-align: left !important;
    }
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

        @include('user.layouts.sidebar')

        <div class="body-wrapper">

            @include('user.layouts.header')

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

                                <div class="d-flex justify-content-between align-items-center mb-3" style="
                                    background: #dde2e8;
                                    padding: 10px;
                                    border-radius: 5px;
                                ">
                                <a href={{ url()->previous() }} class="btn btn-primary">
                                    <i class="fa-solid fa-angle-left" style="margin-right: 3px"></i>
                                    Back
                                </a>
                                <h2 class="card-title fw-bold text-primary mb-0" style="margin-bottom: 0px !important">
                                Assigned Tasks
                                </h2>
                                <h2 class="card-title fw-bold text-primary">
                                    
                                </h2>
                                </div>
                              <div class="table-responsive">
                                <!-- Employee Table -->
                                <table id="employeeTable" class="table table-hover table-bordered align-middle text-left">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-left">ID</th>
                                            <th scope="col" class="text-left text-normal">Project</th>
                                            <th scope="col" class="text-left text-nowrap">Tittle</th>
                                            <th scope="col" class="text-left text-nowrap">Description</th>
                                            <th scope="col" class="text-left text-nowrap">Expected Time</th>
                                            <th scope="col" class="text-left text-nowrap">Time Taken</th>
                                            <th scope="col" class="text-left text-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        @foreach ($tasks as $item)
                                            <tr>
                                                <td class="text-left fw-medium">{{ $item->id }}</td>
                                                <td class="text-left fw-medium text-normal" style="width: 15%; white-space: normal; word-wrap: break-word;">{{ $item->project_name }}</td>
                                                <td class="text-left fw-medium text-normal" style="width: 20%; white-space: normal; word-wrap: break-word;">{{ $item->title }}</td>
                                                {{-- <td class="text-left fw-medium text-normal">{{ $item->description }}</td> --}}
                                                <td class="text-left text-nowrap">
                                                    <div class="tooltip-container">
                                                        {{ Str::limit($item->description, 50, '...') }}
                                                        <span class="tooltip-text" style="width: 50%; white-space: normal; word-wrap: break-word;">{{ $item->description }}</span>
                                                    </div>
                                                </td>
                                                {{-- <td class="text-left fw-medium">{{ $item->expected_time }}</td> --}}
                                                <td class="text-left fw-medium text-nowrap">
                                                    @php
                                                        $hours = floor($item->expected_time / 60);
                                                        $minutes = $item->expected_time % 60;
                                                        $readableTime = ($hours > 0 ? $hours . ' hr' : '') . 
                                                                        ($hours > 0 && $minutes > 0 ? ' ' : '') . 
                                                                        ($minutes > 0 ? $minutes . ' min' : '');
                                                    @endphp
                                                    {{ $readableTime }}
                                                </td>
                                                {{-- <td class="text-left fw-medium">{{ $item->time_taken }}</td> --}}
                                                <td class="text-left fw-medium text-nowrap">
                                                    @php
                                                        $hours = floor($item->time_taken / 60);
                                                        $minutes = $item->time_taken % 60;
                                                        $readableTime = ($hours > 0 ? $hours . ' hr' : '') . 
                                                                        ($hours > 0 && $minutes > 0 ? ' ' : '') . 
                                                                        ($minutes > 0 ? $minutes . ' min' : '');
                                                    @endphp
                                                    {{ $readableTime !== '' ? $readableTime : '-- : --' }}
                                                </td>
                                                <td class="text-left fw-medium text-nowrap">
                                                    @if (is_null($item->status))
                                                        <a class="btn btn-primary"
                                                            href="{{ url('/addtask/' . $item->id) }}">Add
                                                            Logs</a>
                                                    @else
                                                        <span class="badge bg-success">{{ $item->status }}</span>
                                                        <a class="btn btn-primary" href="{{ url('/updatetask/' . $item->id) }}">Update</a>
                                                    @endif

                                                </td>
                                                {{-- <td class="text-left fw-medium">
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#viewModal" data-id="{{ $item->id }}">
                                                        View
                                                    </button>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Task Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="taskDetails">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
        <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
        <script src="../assets/js/sidebarmenu.js"></script>
        <script src="../assets/js/app.min.js"></script>
        <script src="../assets/js/dashboard.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    </div>
</body>

<script>
   $(document).ready(function() {
    $('#viewModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);  // Button that triggered the modal
        var taskId = button.data('id');  // Extract the task ID from the data-id attribute

        // Fetch task details via AJAX
        $.ajax({
            url: '/task-details/' + taskId,
            method: 'GET',
            success: function(response) {
                $('#taskDetails').html(response);  // Load the task details into the modal body
            }
        });
    });
});
</script>

</html>

