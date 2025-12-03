@include('admin.layouts.head')

<style>
.card-title {
    font-size: 23px !important;
}

#dataTables_length{
  margin-bottom: 20px;
  }
  
#employeeTable_filter {
  margin-bottom: 20px;
  }
  
  #dataTables_info{
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
                                    Leave Requests
                                  </h2>
                                  <h2 class="card-title fw-bold text-primary"></h2>
                                </div>
                                <br>
                                <div class="container">
                                    <ul class="nav nav-tabs" id="leaveTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab"
                                                data-bs-target="#pending" type="button" role="tab"
                                                aria-controls="pending" aria-selected="true">Requests</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="approved-tab" data-bs-toggle="tab"
                                                data-bs-target="#approved" type="button" role="tab"
                                                aria-controls="approved" aria-selected="false">Approved</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab"
                                                data-bs-target="#cancelled" type="button" role="tab"
                                                aria-controls="cancelled" aria-selected="false">Cancelled</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="leaveTabsContent">
                                        <div class="tab-pane fade show active" id="pending" role="tabpanel"
                                            aria-labelledby="pending-tab">
                                            <br>
                                            {{-- <h5>Pending Leaves</h5> --}}
                                            <!-- Responsive Table Wrapper -->
                                           <div class="table-responsive">
                                                  <table id="employeeTable" class="table table-hover table-bordered align-middle text-left text-nowrap">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col" class="text-left text-nowrap">Employee Name</th>
                                                        <th scope="col" class="text-left text-nowrap">From Date</th>
                                                        <th scope="col" class="text-left text-nowrap">To Date</th>
                                                        <th scope="col" class="text-left text-nowrap">Type</th>
                                                        <th scope="col" class="text-left text-nowrap">Duration</th>
                                                        <th scope="col" class="text-left text-nowrap">Reason</th>
                                                        <th scope="col" class="text-left text-nowrap">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pendingLeaves as $leave)
                                                        <tr>
                                                            <td class="text-left text-nowrap">{{ $leave->user->name }}</td>
                                                            {{-- <td class="text-left text-nowrap">{{ $leave->from_date }}</td> --}}
                                                            <td class="text-left text-nowrap">
                                                                {{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}
                                                            </td>
                                                            {{-- <td class="text-left text-nowrap">{{ $leave->to_date }}</td> --}}
                                                            <td class="text-left text-nowrap">
                                                                {{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="text-left text-nowrap">{{ $leave->leave_type }}</td>
                                                            <td class="text-left text-nowrap">{{ $leave->leave_duration }}</td>
                                                            <td class="text-left" style="max-width: 300px; white-space: normal; word-wrap: break-word;">{{ $leave->reason }}</td>
                                                            <td class="text-left text-nowrap">
                                                                <form action="{{ route('approveLeave', $leave->id) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm">Approve</button>
                                                                </form>
                                                                <form action="{{ route('cancelLeave', $leave->id) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm">Cancel</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </table>
                                            </div>
                                            {{-- <ul>
                                                @foreach ($pendingLeaves as $leave)
                                                    <li>{{ $leave->from_date }} to {{ $leave->to_date }} -
                                                        {{ $leave->reason }}</li>
                                                @endforeach
                                            </ul> --}}
                                        </div>
                                        <div class="tab-pane fade" id="approved" role="tabpanel"
                                            aria-labelledby="approved-tab">
                                            <br>
                                            {{-- <h5>Approved Leaves</h5> --}}
                                            <!-- Responsive Table Wrapper -->
                                           <div class="table-responsive">
                                             <table id="employeeTable" class="table table-hover table-bordered align-middle text-left text-nowrap">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col" class="text-start text-nowrap">Employee Name</th>
                                                        <th scope="col" class="text-start text-nowrap">From Date</th>
                                                        <th scope="col" class="text-start text-nowrap">To Date</th>
                                                        <th scope="col" class="text-start text-nowrap">Type</th>
                                                        <th scope="col" class="text-start text-nowrap">Duration</th>
                                                        <th scope="col" class="text-start text-nowrap">Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($approvedLeaves as $leave)
                                                        <tr>
                                                            <td class="text-start text-nowrap">{{ $leave->user->name }}</td>
                                                            {{-- <td class="text-start text-nowrap">{{ $leave->from_date }}</td> --}}
                                                            <td class="text-start text-nowrap">
                                                                {{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}
                                                            </td>
                                                            {{-- <td class="text-start text-nowrap">{{ $leave->to_date }}</td> --}}
                                                            <td class="text-start text-nowrap">
                                                                {{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="text-start text-nowrap">{{ $leave->leave_type }}</td>
                                                            <td class="text-start text-nowrap">{{ $leave->leave_duration }}</td>
                                                            <td class="text-start" style="max-width: 300px; white-space: normal; word-wrap: break-word;">{{ $leave->reason }}</td>
                                                        </tr>
                                                    @endforeach
                                            </table>
                                           </div>
                                            {{-- <ul>
                                                @foreach ($approvedLeaves as $leave)
                                                    <li>{{ $leave->from_date }} to {{ $leave->to_date }} -
                                                        {{ $leave->reason }}</li>
                                                @endforeach
                                            </ul> --}}
                                        </div>
                                        <div class="tab-pane fade" id="cancelled" role="tabpanel"
                                            aria-labelledby="cancelled-tab">
                                            <br>
                                            {{-- <h5>Cancelled Leaves</h5> --}}
                                            <!-- Responsive Table Wrapper -->
                                           <div class="table-responsive">
                                             <table id="employeeTable" class="table table-hover table-bordered align-middle text-left text-nowrap">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col" class="text-left text-nowrap">Employee Name</th>
                                                        <th scope="col" class="text-left text-nowrap">From Date</th>
                                                        <th scope="col" class="text-left text-nowrap">To Date</th>
                                                        <th scope="col" class="text-left text-nowrap">Type</th>
                                                        <th scope="col" class="text-left text-nowrap">Duration</th>
                                                        <th scope="col" class="text-left text-nowrap">Reason</th>
                                                     {{-- <th scope="col" class="text-left text-nowrap">Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cancelledLeaves as $leave)
                                                        <tr>
                                                            <td class="text-left text-nowrap">{{ $leave->user->name }}</td>
                                                            {{-- <td class="text-left text-nowrap">{{ $leave->from_date }}</td> --}}
                                                            <td class="text-left text-nowrap">
                                                                {{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}
                                                            </td>
                                                            {{-- <td class="text-left text-nowrap">{{ $leave->to_date }}</td> --}}
                                                            <td class="text-left text-nowrap">
                                                                {{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="text-left text-nowrap">{{ $leave->leave_type }}</td>
                                                            <td class="text-left text-nowrap">{{ $leave->leave_duration }}</td>
                                                            <td class="text-left " style="max-width: 300px; white-space: normal; word-wrap: break-word;">{{ $leave->reason }}</td>
                                                        </tr>
                                                    @endforeach
                                            </table>
                                            </div>
                                            {{-- <ul>
                                                @foreach ($cancelledLeaves as $leave)
                                                    <li>{{ $leave->from_date }} to {{ $leave->to_date }} -
                                                        {{ $leave->reason }}</li>
                                                @endforeach
                                            </ul> --}}
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
@include('admin.layouts.footer')
