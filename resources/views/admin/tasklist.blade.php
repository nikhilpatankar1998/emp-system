@include('admin.layouts.head')


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
                                    Task List
                                  </h2>
                                  <h2 class="card-title fw-bold text-primary"></h2>
                                </div>
                                <!-- Employee Table -->
                                <div class="table-responsive">
                                <!-- Employee Table -->
                                <table id="employeeTable" class="table table-hover table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-center">ID</th>
                                            <th scope="col" class="text-center">Task title</th>
                                            <th scope="col" class="text-center">Expected time</th>
                                            <th scope="col" class="text-center">Task description</th>
                                            {{-- <th scope="col" class="text-center">End Date</th>
                                            <th scope="col" class="text-center">Actions</th> --}}
                                           
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        @foreach ($tasks as $item)
                                        <tr>
                                            <td class="text-center fw-medium">{{$item->id}}</td>
                                            <td class="text-center fw-medium">{{$item->title}}</td>
                                            {{-- <td class="text-center fw-medium">{{$item->expected_time}}</td> --}}
                                            <td class="text-center fw-medium">
                                                @php
                                                    $hours = floor($item->expected_time / 60);
                                                    $minutes = $item->expected_time % 60;
                                                    $readableTime = ($hours > 0 ? $hours . ' hr' : '') . 
                                                                    ($hours > 0 && $minutes > 0 ? ' ' : '') . 
                                                                    ($minutes > 0 ? $minutes . ' min' : '');
                                                @endphp
                                                {{ $readableTime }}
                                            </td>
                                            <td class="text-center">
                                                <div class="tooltip-container">
                                                    {{ Str::limit($item->description, 70, '...') }}
                                                    <span class="tooltip-text">{{ $item->description }}</span>
                                                </div>
                                            </td>
                                            {{-- <td class="text-center fw-medium">{{$item->end_date}}</td>
                                            <td class="text-center fw-medium"><a class="btn btn-primary" href="{{ url('/project-tasks/'.$item->id)}}">Add Tasks</a>
                                                <a class="btn btn-primary" href="{{ url('/project-tasks/'.$item->id)}}">Task List</a>
                                            <a class="btn btn-secondary" href={{ url('/editproject/'.$item->id) }}><i class="ti ti-edit"></i> Edit</a></td> --}}
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
        @include('admin.layouts.footer')
