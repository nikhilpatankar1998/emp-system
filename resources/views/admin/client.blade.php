@include('admin.layouts.head')

<style>
  
  .card-title {
    font-size: 23px !important;
}

#dataTables_length{
  margin-bottom: 20px;
  }
  
#clientTable_filter {
  margin-bottom: 20px;
  }
  
  #clientTable_info{
  margin-top: 20px;
  }


#clientTable_paginate{
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
    Client List
  </h2>
   <a href="/add-client" class="btn btn-primary">Add Client</a>
</div>
                                

<!-- Responsive Table Wrapper -->
                                           <div class="table-responsive">
                                <!-- Employee Table -->
                                <table class="table table-hover table-bordered align-middle text-left">
                                                <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-left">ID</th>
                                            <th scope="col" class="text-left text-nowrap">Name</th>
                                            <th scope="col" class="text-left text-nowrap">official Email</th>
                                            <th scope="col" class="text-left text-nowrap">Official Number</th>
                                            {{-- <th scope="col" class="text-left text-nowrap">City</th> --}}
                                            <th scope="col" class="text-lefttext-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        @foreach ($clients as $item)
                                            <tr>
                                                <td class="text-left fw-medium text-nowrap">{{ $item->id }}</td>
                                                <td class="text-left fw-medium text-nowrap">{{ $item->full_name }}</td>
                                                <td class="text-left fw-medium text-nowrap">{{ $item->official_email }}</td>
                                                <td class="text-left fw-medium text-nowrap">{{ $item->official_contact_name }} </td>
                                                <td class="text-left fw-medium text-nowrap">
                                                    {{-- <a href="{{ route('employee.edit', $item->id) }}"
                                                        class="btn btn-primary">View</a> --}}
                                                    {{-- <a href="javascript:void(0);"
                                                        class="btn btn-primary view-client-btn"
                                                        data-name="{{ $item->full_name }}"
                                                        data-email="{{ $item->official_email }}"
                                                        data-contact="{{ $item->official_contact_name }}"
                                                        data-personal="{{ $item->personal_contact_name }}">
                                                        View
                                                    </a> --}}
                                                    <a href="{{ route('edit-client', $item->id) }}"
                                                        class="btn btn-primary"><i class="ti ti-edit"></i></a>
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
    <!-- View Client Modal -->
    <div class="modal fade" id="clientViewModal" tabindex="-1" aria-labelledby="clientViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Client Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modal-client-name"></span></p>
                    <p><strong>Email:</strong> <span id="modal-client-email"></span></p>
                    <p><strong>official Contact:</strong> <span id="modal-client-contact"></span></p>
                    <p><strong>Personal Contact:</strong> <span id="data-personal"></span></p>
                    <!-- Add more fields here as needed -->
                </div>
            </div>
        </div>
    </div>
    
</body>
@include('admin.layouts.footer')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const viewButtons = document.querySelectorAll('.view-client-btn');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const contact = this.getAttribute('data-contact');
                const personal = this.getAttribute('data-personal');

                // Set modal values
                document.getElementById('modal-client-name').textContent = name;
                document.getElementById('modal-client-email').textContent = email;
                document.getElementById('modal-client-contact').textContent = contact;

                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('clientViewModal'));
                modal.show();
            });
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script> 
    $(document).ready(function () {
        $('#clientTable').DataTable({
            "order": [], // No default sorting, or set like [[0, 'asc']]
            "columnDefs": [
                { "orderable": false, "targets": -1 } // Disable sorting on "Action" column
            ]
        });
    });
</script>
