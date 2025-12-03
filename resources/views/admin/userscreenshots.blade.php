@include('admin.layouts.head')

<style>
/* Basic style for the image */
.screenshot-img {
    transition: transform 0.3s ease; /* Smooth zoom transition */
    cursor: zoom-in;
    object-fit: cover; /* Maintain image aspect ratio */
    width: 100%; /* Make sure image fits the container */
    height: auto;
   position: relative;
    z-index: 1;
}

/* Hover effect to zoom the image */
.screenshot-img:hover {
    transform: scale(4.5); /* Zoom effect */
    transform-origin: center center; /* Ensure zoom happens from the center */
     z-index: 9999; /* Ensure zoomed image stays on top */
  position: absolute;
    top: 50%;
    left: 50%;
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
                 <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="mb-0">{{ $user->name }} - Screen Activity</h2>

    <form method="GET" action="{{ route('admin.screenshots', $user->id) }}" class="d-flex align-items-center gap-2 flex-nowrap">
        <input type="date" name="date" class="form-control" value="{{ $selectedDate }}">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

                <div class="row">
                    @foreach ($screenshots as $screenshot)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                {{-- <img src="{{ asset('../storage/screenshots/' . $screenshot->filename) }}" class="card-img-top img-thumbnail screenshot-img" 
                                        alt="Screenshot" data-img="{{ asset('../storage/screenshots/' . $screenshot->filename) }}"> --}}
                                <img src="{{ asset('storage/screenshots/' . $screenshot->filename) }}"
                                    class="card-img-top img-thumbnail screenshot-img" alt="Screenshot"
                                    data-img="{{ asset('storage/screenshots/' . $screenshot->filename) }}">

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
