@include('admin.layouts.head')

<style>
 

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
  
  @media screen and (max-width: 640px) {
    div.dt-buttons {
        float: none !important;
        text-align: start !important;
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
    Project List
  </h2>
  <h2 class="card-title fw-bold text-primary"></h2>
</div>

 <!-- Responsive Table Wrapper -->
                                           <div class="table-responsive">
                                <!-- Employee Table -->
                               <table id="employeeTable" class="table table-bordered text-nowrap align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-center">ID</th>
                                        <th scope="col" class="text-left">Project Name</th>
                                        <th scope="col" class="text-center">Start Date</th>
                                        <th scope="col" class="text-center">End Date</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center fw-medium">{{ $item->id }}</td>
                                            <td class="text-left fw-medium">{{ $item->name }}</td>
                                            <td class="text-center fw-medium">{{ $item->start_date }}</td>
                                            <td class="text-center fw-medium">{{ $item->end_date }}</td>
                                            <td class="text-center fw-medium">
                                                <a href="{{ url('/project-tasks/' . $item->id) }}" class="btn btn-primary me-1" style="border-radius: 5px;">
                                                    <i class="fas fa-plus"></i> Add Tasks
                                                </a>

                                                <a href="{{ url('/tasks-list/' . $item->id) }}" class="btn btn-primary me-1" style="border-radius: 5px;">
                                                    <i class="fas fa-tasks"></i> Task List
                                                </a>

                                                <a href="{{ url('/editproject/' . $item->id) }}" class="btn btn-primary me-1" style="border-radius: 5px;">
                                                    <i class="ti ti-edit"></i> 
                                                </a>

                                                <a href="{{ url('/viewproject/' . $item->id) }}" class="btn btn-primary" style="border-radius: 5px;">
                                                    <i class="ti ti-eye"></i> 
                                                </a>
                                            </td>
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
    </div>
</body>
@include('admin.layouts.footer')
