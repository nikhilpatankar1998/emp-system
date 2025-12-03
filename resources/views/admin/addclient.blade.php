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
    Add New Client
  </h2>
  <h2 class="card-title fw-bold text-primary"></h2>
</div>
                                    </div>
                                    <form action="/add-client" method="POST" id="employee-form">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label for="name" class="form-label">Company Name</label>
                                                <input type="text" id="company_name" class="form-control" name="company_name"
                                                    placeholder="Enter company name" required>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6 mb-4">
                                                <label for="email" class="form-label">Company website url</label>
                                                <input type="text" class="form-control" id="company_website_url" name="company_website_url"
                                                    placeholder="Enter company website url" required>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <!-- Email -->
                                            <div class="col-md-6 mb-4">
                                                <label for="email" class="form-label">Official Email</label>
                                                <input type="email" class="form-control" id="official_email" name="official_email"
                                                    placeholder="Enter clients's official email" required>
                                            </div>
                                            <!-- Date of Joining -->
                                            <div class="col-md-6 mb-4">
                                                <label for="date_of_joining" class="form-label">Official Contact Number</label>
                                                <input type="number" id="official_contact_name" class="form-control"
                                                placeholder="Enter official contact number" name="official_contact_name" required>
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label for="name" class="form-label">Contact Person Name</label>
                                                <input type="text" id="full_name" class="form-control" name="full_name"
                                                    placeholder="Enter clients's name" required>
                                            </div>

                                            <!-- Department -->
                                            <div class="col-md-6 mb-4">
                                                <label for="email" class="form-label">Contact Person Email</label>
                                                <input type="email" class="form-control" id="personal_email" name="personal_email"
                                                    placeholder="Enter clients's personal email" required>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label for="password" class="form-label">Personal Contact Number</label>
                                                <input type="text" id="personal_contact_name" class="form-control"
                                                    name="personal_contact_name" placeholder="Enter personal contact number" required>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="date_of_birth" class="form-label">City</label>
                                                <input type="text" id="city" class="form-control"
                                                placeholder="Enter city" name="city" required>
                                            </div>

                                        </div>
                                        <div class="mb-4">
                                            <label for="description" class="form-label">Full Address</label>
                                            <textarea name="full_address" id="full_address" class="form-control" cols="30" rows="5" placeholder="Enter client's full address" required ></textarea>
                                        </div>

                                        <div class="row">
                                            <!-- Confirm Password -->
                                            {{-- <div class="col-md-6 mb-4">
                                                <label for="conform_password" class="form-label">Confirm
                                                    Password</label>
                                                <input type="password" id="conform_password" class="form-control"
                                                    name="conform_password" placeholder="Confirm password" required>
                                            </div> --}}

                                            <div style="padding-top: 24px;" class="col-md-6 mb-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="reset" class="btn btn-secondary">Reset</button>
                                            </div>
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
@include('admin.layouts.footer')
