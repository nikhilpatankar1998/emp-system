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
    Upload Documents
  </h2>
  <h2 class="card-title fw-bold text-primary"></h2>
</div>
                                <form action="{{ url('/postdocument') }}" method="POST" id="employee-form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $id }}">
                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <label for="document_name" class="form-label">Document Name</label>
                                            <select id="document_name_select" class="form-select" name="document_name"
                                                required>
                                                <option value="">Select Document</option>
                                                <option value="Demo Document">Demo Document</option>
                                                <option value="Joining Letter">Joining Letter</option>
                                                <option value="Offer Letter">Offer Letter</option>
                                                <option value="Termination Letter">Termination Letter</option>
                                                <option value="Payslip">Payslip</option>
                                                <option value="Experience Letter">Experience Letter</option>
                                                <option value="NOC">NOC</option>
                                                <option value="Relieving Letter">Relieving Letter</option>
                                                <option value="Other">Other</option>
                                            </select>
                                              {{-- Hidden input shown only when "Other" is selected --}}
                                                <input type="text" id="other_document_name" name="document_name"
                                                class="form-control mt-2 d-none"
                                                placeholder="Enter custom document name">
                                        </div>

                                        <div class="col-md-4 mb-4">
                                            <label for="document_file" class="form-label">Upload</label>
                                            <input type="file" id="document_path" class="form-control"
                                                name="document_path" required>
                                        </div>

                                        <div class="col-md-4 mb-4" style="padding-top: 28px;">
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    const select = document.getElementById('document_name_select');
                                    const otherInput = document.getElementById('other_document_name');
                                    const resetBtn = document.getElementById('reset-btn');

                                    select.addEventListener('change', function() {
                                        if (this.value === 'Other') {
                                            otherInput.classList.remove('d-none');
                                            select.removeAttribute('name'); // Remove name to avoid duplicate field
                                            otherInput.setAttribute('name', 'document_name'); // Set input as final name
                                        } else {
                                            otherInput.classList.add('d-none');
                                            otherInput.removeAttribute('name');
                                            select.setAttribute('name', 'document_name');
                                        }
                                    });

                                    // Optional: reset input visibility when form resets
                                    resetBtn.addEventListener('click', function() {
                                        otherInput.classList.add('d-none');
                                        otherInput.removeAttribute('name');
                                        select.setAttribute('name', 'document_name');
                                        select.value = "";
                                    });
                                </script>

                                <br>
                                @if ($documents->count())
                                    <h4 class="mt-5">Uploaded Documents</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mt-3">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Document Name</th>
                                                    <th>Uploaded By</th>
                                                    <th>Uploaded At</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($documents as $index => $doc)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $doc->document_name }}</td>
                                                        <td>{{ $doc->uploaded_by == auth()->user()->id ? 'You' : ($doc->uploadedBy->name ?? '-') }}</td>
                                                        <td>{{ $doc->created_at->format('d M Y, h:i A') }}</td>
                                                        <td>
                                                            <a href="{{ asset('storage/' . $doc->document_path) }}"
                                                                class="btn btn-primary" target="_blank">
                                                                View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@include('admin.layouts.footer')
