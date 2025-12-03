@include('admin.layouts.head')

<style>
  .card-title {
    font-size: 23px !important;
  }

  #dataTables_length {
    margin-bottom: 20px;
  }

  #clientTable_filter {
    margin-bottom: 20px;
  }

  #clientTable_info {
    margin-top: 20px;
  }

  #clientTable_paginate {
    margin-top: 20px;
  }

 @media screen and (max-width: 420px){
    
    .datacol-md-4 {
        
        margin-bottom : 15px;
        width: 100%;
    }
  }


@media screen and (max-width: 768px){
  
  .datacol-md-4 {
        
    margin-bottom : 15px;
        width: 100%;
    }
  }


@media screen and (max-width: 1200px){
  
  .datacol-md-4 {
        
    margin-bottom : 15px;
        width: 100%;
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
  <div
    class="page-wrapper"
    id="main-wrapper"
    data-layout="vertical"
    data-navbarbg="skin6"
    data-sidebartype="full"
    data-sidebar-position="fixed"
    data-header-position="fixed"
  >
    @include('admin.layouts.sidebar')

    <div class="body-wrapper d-flex flex-column justify-content-between">
      @include('admin.layouts.header')

      <div
        class="container-fluid"
        style="padding: 30px !important; height: 100vh"
      >
        <div class="row">
          <div class="col-lg-12">
            <div class="card" style="margin-bottom: 0px; margin-top: 80px">
              <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif @if ($errors->any())
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
    Add Project
  </h2>
  <h2 class="card-title fw-bold text-primary"></h2>
</div>
                  </div>
                   <form
                    action="{{ route('post.project') }}"
                    method="POST"
                    id="employee-form"
                    enctype="multipart/form-data"
                  >
                    @csrf
                    <div class="row mb-3">
                      <div class="col-md-4 datacol-md-4">
                        <label for="status" class="form-label"
                          >Company / Contact person Name</label
                        >
                        <select
                          id="client_id"
                          class="form-select"
                          name="client_id"
                          required
                        >
                          <option value="">
                            Select Company / Contact person name
                          </option>
                          @foreach ($clients as $item)
                          <option value="{{ $item->id }}">
                            {{ $item->company_name }} / {{ $item->full_name }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                      <!-- Project Name -->
                      <div class="col-md-4 datacol-md-4">
                        <label for="name" class="form-label"
                          >Project Name</label
                        >
                        <div class="input-group">
                          <span class="input-group-text">
                            <i
                              class="fas fa-briefcase"
                              style="color: #686464"
                            ></i>
                          </span>
                          <input
                            type="text"
                            id="name"
                            class="form-control"
                            name="name"
                            placeholder="Enter project's name"
                            required
                          />
                        </div>
                      </div>

                      <!-- Start Date -->
                      <div class="col-md-4 datacol-md-4">
                        <label for="start_date" class="form-label"
                          >Start Date</label
                        >
                        <div class="input-group">
                          <span class="input-group-text">
                            <i
                              class="fas fa-calendar-alt"
                              style="color: #686464"
                            ></i>
                          </span>
                          <input
                            type="date"
                            id="start_date"
                            class="form-control"
                            name="start_date"
                            required
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <!-- End Date -->
                      <div class="col datacol-md-4">
                        <label for="end_date" class="form-label"
                          >End Date</label
                        >
                        <div class="input-group">
                          <span class="input-group-text">
                            <i
                              class="fas fa-calendar-check"
                              style="color: #686464"
                            ></i>
                          </span>
                          <input
                            type="date"
                            id="end_date"
                            class="form-control"
                            name="end_date"
                            required
                          />
                        </div>
                      </div>

                      <!-- Status -->
                      <div class="col datacol-md-4">
                        <label for="status" class="form-label">Status</label>
                        <div class="input-group">
                          <span class="input-group-text">
                            <i class="fas fa-tasks" style="color: #686464"></i>
                          </span>
                          <select
                            id="status"
                            class="form-select"
                            name="status"
                            required
                          >
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Completed">Completed</option>
                          </select>
                        </div>
                      </div>

                      <!-- Server URL -->
                      <div class="col datacol-md-4">
                        <label for="server_url" class="form-label"
                          >Server URL</label
                        >
                        <div class="input-group">
                          <span class="input-group-text">
                            <i class="fas fa-server" style="color: #686464"></i>
                          </span>
                          <input
                            type="url"
                            id="server_url"
                            class="form-control"
                            name="server_url"
                            placeholder="Enter URL"
                          />
                        </div>
                      </div>

                      <!-- Client URL -->
                      <div class="col datacol-md-4">
                        <label for="client_url" class="form-label"
                          >Client URL</label
                        >
                        <div class="input-group">
                          <span class="input-group-text">
                            <i class="fas fa-globe" style="color: #686464"></i>
                          </span>
                          <input
                            type="url"
                            id="client_url"
                            class="form-control"
                            name="client_url"
                            placeholder="Enter URL"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <!-- Assign Employees -->
                      <div class="col-md-12 mb-3">
                        <label for="employees" class="form-label"
                          >Assign Employees</label
                        >
                        <div class="row">
                          @foreach ($employees as $employee)
                          <div class="col-md-3 datacol-md-4 col-sm-6 col-12 mb-2">
                            <div class="form-check">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                name="employees[]"
                                value="{{ $employee->id }}"
                                id="employee_{{ $employee->id }}"
                              />
                              <label
                                class="form-check-label"
                                for="employee_{{ $employee->id }}"
                              >
                                {{ $employee->name }}
                              </label>
                            </div>
                          </div>
                          @endforeach
                        </div>
                      </div>

                      <!-- Description -->
                      <div class="col-md-12">
                        <label for="description" class="form-label"
                          >Description</label
                        >
                        <div class="input-group">
                          <span class="input-group-text">
                            <i
                              class="fas fa-align-left"
                              style="color: #686464"
                            ></i>
                          </span>
                          <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            cols="30"
                            placeholder="Description"
                            rows="5"
                            required
                          ></textarea>
                        </div>
                      </div>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                      <button
                        type="submit"
                        class="btn btn-primary"
                        style="border-radius: 8px"
                      >
                        Submit
                      </button>
                      <button
                        type="reset"
                        class="btn btn-primary"
                        style="border-radius: 8px"
                      >
                        Reset
                      </button>
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
  </div>
</body>
