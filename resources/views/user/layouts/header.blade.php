<style>
  @media (max-width: 767.98px) {
  .navbar-nav .dropdown-menu {
    position: absolute;
    width: auto !important;
  }
  .navbar-nav .nav-item.dropdown {
    position: static;
  }
}
</style>

<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <!-- <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)">
            <i class="ti ti-bell-ringing"></i>
            <div class="notification bg-primary rounded-circle"></div>
          </a>
        </li>
      </ul> -->
      <div class="container-fluid paddingissue">
    @php
        $user = auth()->user();  
        $name = ucwords($user->name); // Capitalize first letter of each word
        $initials = collect(explode(' ', $name))->map(fn($part) => strtoupper(substr($part, 0, 1)))->join('');
    @endphp

    <h5 class="dashheader">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
<li class="nav-item d-none d-xl-inline">
  <a class="nav-link sidebartoggler nav-icon-hover" id="headerNewCollapse" href="javascript:void(0)">
    <i class="ti ti-menu-2"></i>
  </a>
</li>
        </ul>
        Welcome
        <!-- Full Name on Desktop -->
        <span class="d-none d-xl-inline">&nbsp;{{ $name }}</span>

        <!-- Initials on Mobile -->
        <span class="d-inline d-xl-none">&nbsp;{{ $initials }}</span>
    </h5>
</div>

      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
          {{-- <a href="#" target="_blank"
            class="btn btn-primary me-2"><span class="d-none d-md-block">Check Pro Version</span> <span class="d-block d-md-none">Pro</span></a>
          <a href="#" target="_blank"
            class="btn btn-success"><span class="d-none d-md-block">Download Free </span> <span class="d-block d-md-none">Free</span></a> --}}
            
        <li class="nav-item">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)">
            <i class="ti ti-bell-ringing"></i>
            <div class="notification bg-primary rounded-circle"></div>
          </a>
        </li>
          <li class="nav-item dropdown">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
              aria-expanded="false">
              @php
                 $user = auth()->user();  
              @endphp
             <!--<h5 >{{$user->name}}</h5> -->
            <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
              <div class="message-body">
                <a href="/my-profile-page" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-user fs-6"></i>
                  <p class="mb-0 fs-3">My Profile</p>
                </a>
                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-mail fs-6"></i>
                  <p class="mb-0 fs-3">My Account</p>
                </a>
                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-list-check fs-6"></i>
                  <p class="mb-0 fs-3">My Task</p>
                </a>
                <a href="/logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggle = document.getElementById("headerNewCollapse"); // Desktop toggle button
    const sidebar = document.querySelector(".left-sidebar");
    const bodyWrapper = document.querySelector(".body-wrapper");
    const toggleIcon = sidebarToggle.querySelector("i");

    // ---- Restore state from localStorage ----
    if (localStorage.getItem("sidebarCollapsed") === "true") {
        sidebar.classList.add("collapsed");
        bodyWrapper.classList.add("collapsed-sidebar");
        toggleIcon.classList.remove("ti-menu-2");
        toggleIcon.classList.add("ti-x");
    }

    // ---- Toggle on click ----
    sidebarToggle.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");
        bodyWrapper.classList.toggle("collapsed-sidebar");

        // Save state in localStorage
        if (sidebar.classList.contains("collapsed")) {
            localStorage.setItem("sidebarCollapsed", "true");
            toggleIcon.classList.remove("ti-menu-2");
            toggleIcon.classList.add("ti-x");
        } else {
            localStorage.setItem("sidebarCollapsed", "false");
            toggleIcon.classList.remove("ti-x");
            toggleIcon.classList.add("ti-menu-2");
        }
    });
});
</script>