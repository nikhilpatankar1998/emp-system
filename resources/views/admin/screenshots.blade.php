@include('admin.layouts.head')

<style>
  .screenshot-img{
    cursor: pointer;
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

        {{-- <div class="body-wrapper"> --}}

        {{-- @include('admin.layouts.header') --}}

        <div class="body-wrapper">
            @include('admin.layouts.header')

            <div class="container-fluid">
                <!--<h2>{{ $user->name }} - Screen Activity</h2>-->
              
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
                    {{ $user->name }} - Screen Activity
                  </h2>
                  <form method="GET" action="{{ route('admin.screenshots', $user->id) }}" class="d-flex align-items-center gap-2 flex-nowrap">
                        <input type="date" name="date" class="form-control" value="{{ $selectedDate }}" style="border: 1px solid #474a4d52 !important;">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>

                <div class="row">
                    @foreach ($screenshots as $screenshot)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="{{ asset('../storage/screenshots/' . $screenshot->filename) }}" class="card-img-top img-thumbnail screenshot-img" 
                                        alt="Screenshot" data-img="{{ asset('../storage/screenshots/' . $screenshot->filename) }}"> 
                                {{-- <img src="{{ asset('storage/screenshots/' . $screenshot->filename) }}"
                                    class="card-img-top img-thumbnail screenshot-img" alt="Screenshot"
                                    data-img="{{ asset('storage/screenshots/' . $screenshot->filename) }}">--}}

                                <div class="card-body text-center">
                                    <p class="card-text">📅 {{ $screenshot->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Modal (Larger Popup) -->
     <div id="imageModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- Large Modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Screenshot Preview</h5>
                    {{--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
                    <button type="button"
                          class="btn btn-sm"
                          data-bs-dismiss="modal"
                          aria-label="Close"
                          style="background-color: red; color: white; border: none; border-radius: 5px; padding: 0px 10px; font-size: 20px;">
                           &times;
                     </button>

                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Large Screenshot" style="max-width: 100%; max-height: 75vh;">
                </div>
            </div>
        </div>
    </div> 
    @include('admin.layouts.footer')

    <!-- Bootstrap & Custom Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modalImage = document.getElementById("modalImage");
            const imageModal = new bootstrap.Modal(document.getElementById("imageModal"));

            document.querySelectorAll(".screenshot-img").forEach(img => {
                img.addEventListener("click", function() {
                    modalImage.src = this.getAttribute("data-img");
                    imageModal.show();
                });
            });
        });
    </script>
</body>

{{-- screenshot_20250305_173702.png- 718(123) --}}
