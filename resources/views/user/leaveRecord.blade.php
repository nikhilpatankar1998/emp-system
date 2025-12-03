@include('user.layouts.head')

<style>

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
                                Leave Record
                                </h2>
                                <h2 class="card-title fw-bold text-primary">
                                    
                                </h2>
                                </div>
                                <br>
                                <div class="container">
                                    <ul class="nav nav-tabs" id="leaveTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab"
                                                data-bs-target="#pending" type="button" role="tab"
                                                aria-controls="pending" aria-selected="true">Pending</button>
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
                                            <h5>Pending Requests</h5>
                                            <table class="table text-nowrap align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-start">From Date</th>
                                                        <th scope="col" class="text-start">To Date</th>
                                                        <th scope="col" class="text-start">Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pendingLeaves as $leave)
                                                        <tr>
                                                            <td class="text-start">{{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}</td>
                                                            <td class="text-start">{{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}</td>
                                                            <td class="text-start" style="max-width: 300px; white-space: normal; word-wrap: break-word;">{{ $leave->reason }}</td>
                                                        </tr>
                                                    @endforeach
                                            </table>
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
                                            <h5>Approved Leaves</h5>
                                            <table class="table text-nowrap align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-start">From Date</th>
                                                        <th scope="col" class="text-start">To Date</th>
                                                        <th scope="col" class="text-start">Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($approvedLeaves as $leave)
                                                        <tr>
                                                            <td class="text-start">{{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}</td>
                                                            <td class="text-start">{{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}</td>
                                                            <td class="text-start" style="max-width: 300px; white-space: normal; word-wrap: break-word;">
                                                             {{ $leave->reason }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </table>
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
                                            <h5>Cancelled Leaves</h5>
                                            <table class="table text-nowrap align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-start">From Date</th>
                                                        <th scope="col" class="text-start">To Date</th>
                                                        <th scope="col" class="text-start">Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cancelledLeaves as $leave)
                                                        <tr>
                                                            {{-- <td class="text-start">{{ $leave->from_date }}</td> --}}
                                                            <td class="text-start">{{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}</td>
                                                            {{-- <td class="text-start">{{ $leave->to_date }}</td> --}}
                                                            <td class="text-start">{{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}</td>
                                                            <td class="text-start" style="max-width: 300px; white-space: normal; word-wrap: break-word;">{{ $leave->reason }}</td>
                                                        </tr>
                                                    @endforeach
                                            </table>
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
</body>
@include('user.layouts.footer')
