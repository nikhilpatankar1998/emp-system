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
    Employee List
  </h2>
  <h2 class="card-title fw-bold text-primary"></h2>
</div>
                              <!-- Responsive Table Wrapper -->
                                           <div class="table-responsive">
                                <!-- Employee Table -->
                               <table class="table table-hover table-bordered align-middle text-left">
                                <thead class="table-light">
                                  <tr>
                                    <th scope="col" class="text-left text-nowrap">ID</th>
                                    <th scope="col" class="text-left text-nowrap">Name</th>
                                    <th scope="col" class="text-left text-nowrap">Mail</th>
                                    <th scope="col" class="text-left text-nowrap">Password</th>
                                    {{--
                                    <th scope="col" class="text-left text-nowrap">Status</th>
                                    --}}
                                    <th scope="col" class="text-left text-nowrap">Department</th>
                                    <th scope="col" class="text-left text-nowrap">Date of Joining</th>
                                    <th scope="col" class="text-left text-nowrap">Birthday</th>
                                    <th scope="col" class="text-left text-nowrap">Action</th>
                                  </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                  @foreach ($data as $item)
                                  <tr>
                                    <td class="text-left text-nowrap fw-medium">{{ $item->id }}</td>
                                    <td class="text-left text-nowrap fw-medium">{{ $item->name }}</td>
                                    <td class="text-left text-nowrap fw-medium">{{ $item->email }}</td>
                                    <td class="text-left text-nowrap fw-medium">{{ $item->password }}</td>
                                    {{--
                                    <td class="text-left text-nowrap fw-medium">Active</td>
                                    --}}
                                    <td class="text-left text-nowrap fw-medium">{{ $item->department }}</td>
                                    <td class="text-left text-nowrap fw-medium">
                                      {{ $item->date_of_joining }}
                                    </td>
                                    <td class="text-left text-nowrap fw-medium">
                                      {{ $item->date_of_birth }}
                                    </td>
                                    <td class="text-left text-nowrap fw-medium">
                                      <a
                                        href="{{ route('employee.edit', $item->id) }}"
                                        style="border-radius: 5px;"
                                        class="btn btn-primary"
                                        ><i class="ti ti-edit"></i
                                      ></a>
                                      <a
                                        href="{{ route('employee.delete', $item->id) }}"
                                        style="border-radius: 5px;"
                                        class="btn btn-primary"
                                        onclick="return confirm('Are you sure you want to delete this employee?');"
                                        ><i class="ti ti-trash"></i
                                      ></a>
                                    </td>
                                    {{--
                                    <td class="text-left text-nowrap fw-medium">
                                      <input type="checkbox" name="" id="" />
                                    </td>
                                    --}}
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
