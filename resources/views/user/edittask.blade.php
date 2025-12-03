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
                            <div class="card-body">
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
                                Update Task Detail
                                </h2>
                                <h2 class="card-title fw-bold text-primary">
                                    
                                </h2>
                                </div>
                                <div class="container">
                                    {{-- @foreach ($tasks as $item) --}}
                                        <form action="{{ route('updatemytask', $update->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            {{-- @method('PUT') --}}
                                            <table class="table text-nowrap align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">Task Title</th>
                                                        <th scope="col" class="text-center">Time Taken</th>
                                                        <th scope="col" class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" value="{{ $update->title }}" disabled >
                                                        </td>
                                                        
                                                        <td>
                                                            <select class="form-control" id="time_taken" name="time_taken" >
                                                                {{-- <option value="" disabled selected>Select Time</option> --}}
                                                                
                                                                @php
                                                                    $hours = floor($update->time_taken / 60);
                                                                    $minutes = $update->time_taken % 60;
                                                                    $readableTime = ($hours > 0 ? $hours . ' hr' : '') . 
                                                                                    ($hours > 0 && $minutes > 0 ? ' ' : '') . 
                                                                                    ($minutes > 0 ? $minutes . ' min' : '');
                                                                @endphp
                                                                
                                                                {{-- <option value="{{ $readableTime }}" >{{ $readableTime }}</option> --}}
                                                                <option value="{{ $update->time_taken }}" selected>{{ $readableTime }}</option>
                                                        
                                                                @for ($time = 10; $time <= 480; $time += 10)
                                                                    @php
                                                                        $loopHours = floor($time / 60);
                                                                        $loopMinutes = $time % 60;
                                                                        $label = ($loopHours > 0 ? $loopHours . ' hr' : '') . 
                                                                                 ($loopHours > 0 && $loopMinutes > 0 ? ' ' : '') . 
                                                                                 ($loopMinutes > 0 ? $loopMinutes . ' min' : '');
                                                                    @endphp
                                                                    <option value="{{ $time }}">{{ $label }}</option>
                                                                @endfor
                                                            </select>
                                                        </td>
                                                        
                                                       
                                                        <td>
                                                            <select name="status"  class="form-select" required>
                                                                <option value="{{ $update->status }}">{{ $update->status }}</option>
                                                                <option value="inprogress">In Progress</option>
                                                                <option value="active">Active</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <textarea class="form-control" id="descriptionbyuser"  name="descriptionbyuser" placeholder="Enter description">{{ $update->descriptionbyuser }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-between mt-3">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="reset" class="btn btn-warning">Reset</button>
                                            </div>
                                        </form>
                                    {{-- @endforeach --}}
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