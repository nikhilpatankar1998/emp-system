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
                                Apply For Leave
                                </h2>
                                <h2 class="card-title fw-bold text-primary">
                                    
                                </h2>
                                </div>
                                <br>
                                <div class="container">
                                    {{-- @foreach ($tasks as $item) --}}
                                    <form action="{{ route('postLeave') }}" method="POST" id="employee-form">
                                        @csrf

                                        <div class="row">
                                            <!-- Birthday -->
                                            <div class="col mb-3">
                                                <label for="date_of_birth" class="form-label">From Date</label>
                                                <input type="date" id="from_date" class="form-control"
                                                    name="from_date"  required>
                                            </div>

                                            <div class="col mb-3">
                                                <label for="date_of_joining" class="form-label">To date</label>
                                                <input type="date" id="to_date" class="form-control" name="to_date"
                                                     required>
                                            </div>
                                            <div class="col mb-3">
                                                <label for="leave_type" class="form-label">Select Type</label>
                                                <select id="leave_type" class="form-select" name="leave_type" required>
                                                    <option value="">------- Select leave type -------</option>
                                                    <option value="Casual leave">Casual leave</option>
                                                    <option value="Sick leave">Sick leave</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3">
                                                <label class="form-label d-block mb-3">Leave Duration</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="leave_duration" id="full_day" value="Full Day" checked>
                                                    <label class="form-check-label" for="full_day">Full Day</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="leave_duration" id="half_day" value="Half Day">
                                                    <label class="form-check-label" for="half_day">Half Day</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Department -->
                                            <div class="col-md-12 mb-4">
                                                <label for="department" class="form-label">Reason for Leave.</label>
                                                <textarea class="form-control" name="reason" id="reason" cols="20" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <!-- Actions -->
                                        <div style="padding-top: 20px;" class="col-md-6 mb-4">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                      </form>
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
