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
                                <div class="form-container">
                                    <div class="mb-4">
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
    Create Tasks
  </h2>
  <h2 class="card-title fw-bold text-primary"></h2>
</div>
                                    </div>
                                    <form action="{{ route('storetasks', $id) }}" method="POST" id="employee-form">
                                        @csrf
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Task for Date</label>
                                                <input type="date" name="task_date" id="task_date"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <Label for="name" class="form-label">Assign to </Label>
                                                <select name="assigned_to" class="form-select">
                                                    <option value="">---Select Employee---</option>
                                                    @foreach ($user as $users)
                                                        <option value="{{ $users->id }}">{{ $users->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="name" class="form-label">Task Title</label>
                                            <div><input type="text" id="title" class="form-control"
                                                    name="title" placeholder="Enter task title" required></div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="email" class="form-label">Description</label>
                                            <textarea name="description" class="form-control" id="description" placeholder="Enter task Description" cols="30"
                                                rows="10"></textarea>
                                        </div>
                                        <div class="mb-4"> 
                                            <label for="email" class="form-label">Estimated Time</label>
                                            <select class="form-control" id="expected_time" name="expected_time" required>
                                                <!-- Options generated dynamically -->
                                                <option value="" disabled selected>Select Time</option>
                                                @for ($minutes = 10; $minutes <= 480; $minutes += 10)
                                                    @php
                                                        $hours = floor($minutes / 60);
                                                        $remainingMinutes = $minutes % 60;
                                                        $label = ($hours > 0 ? $hours . ' hr' : '') . 
                                                                 ($hours > 0 && $remainingMinutes > 0 ? ' ' : '') . 
                                                                 ($remainingMinutes > 0 ? $remainingMinutes . ' min' : '');
                                                    @endphp
                                                    <option value="{{ $minutes }}">{{ $label }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <br>

                                        <div cadmin="form-actions">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-primary">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
