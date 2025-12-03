<style>
    .submenu-dot {
    color: #007bff;  /* Blue dot */
    font-size: 40px;
    margin-right: 7px;
      margin-bottom: 6px;
}
  
  
  span.hide-menu {
    margin-left: 5px;
}

.logo-img{
   margin: 0 auto;
  }

.sidebar-nav ul .sidebar-item .sidebar-link {
padding: 5px 10px;
    border-radius: 5px;
    gap: 0px;
  }
  
  .sidebar-nav ul .sidebar-item .sidebar-links {
padding: 0px 10px;
    border-radius: 5px;
    gap: 0px;
  }

.sidebar-nav ul .sidebar-item.selected > .sidebar-link.active, .sidebar-nav ul .sidebar-item.selected > .sidebar-link, .sidebar-nav ul .sidebar-item > .sidebar-link.active {
    background-color: #093862 !important;
    color: #fff;
}
  
  .sidebar-nav ul .sidebar-item.selected > .sidebar-links.active, .sidebar-nav ul .sidebar-item.selected > .sidebar-link, .sidebar-nav ul .sidebar-item > .sidebar-link.active {
    background-color: #093862d1 !important;
    color: #fff;
}
  
  
  
  .left-sidebar {
    width: 270px !important;
    background-color: #f6f8fa !important;
      transition: all 0.3s ease;
  }

 .left-sidebar .logo-img img{
    width: 100%;
    height: 75px;
    margin-top: 10px;
  }


.left-sidebar.collapsed .logo-img img{
    width: 100%;
    height: 40px;
    margin-top: 10px;
  }

/* Collapse mode */
.left-sidebar.collapsed {
  width: 80px !important;
}

.left-sidebar.collapsed .hide-menu {
  display: none;
}

  
  .sidebar-items{
    margin-bottom: 0px !important;
  }


/* Small screens (below 1200px) */
@media (max-width: 1199px) {

.left-sidebar.collapsed .hide-menu {
  display: block;
}

/* Collapse mode */
.left-sidebar.collapsed {
  width: 100% !important;
        padding-top: 20px;
}


  }



</style>
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="/dashboard" class="text-nowrap logo-img">
         <img src="../assets/images/logos/newbird.png" alt="" /> 
        {{-- <img src="http://test.idicesystem.com/public/assets/images/bg-removed.png" alt=""> --}}
       {{-- <h2 class="mb-0">IDICE SYSTEMS</h2>--}}
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="" style="padding: 0px 16px !important;">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
          <span class="hide-menu">Home</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="/dashboard" aria-expanded="false">
            <span>
              <iconify-icon icon="mdi:view-dashboard" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>
        <!-- <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
          <span class="hide-menu">DETAILS</span>
        </li> -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="/mytask" aria-expanded="false">
            <span>
              <iconify-icon icon="solar:clipboard-text-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">My Tasks</span>
          </a>
        </li>
       <!-- <li class="sidebar-item">
          <a class="sidebar-link" href="/dailyreports" aria-expanded="false">
            <span>
              <iconify-icon icon="mdi:calendar-text-outline" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Daily Report</span>
          </a>
        </li> -->
        <!-- <li class="sidebar-item">
          <a class="sidebar-link" href="#" aria-expanded="false">
            <span>
              <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Monthly Report</span>
          </a>
        </li> -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="/chat-user-page" aria-expanded="false">
              <span>
                  <iconify-icon icon="mdi:message-text-outline" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">Chat</span>
            <span id="chatNotificationBadge" class="badge bg-danger ms-2" style="display: none;">0</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="/applyleave" aria-expanded="false">
            <span>
              <iconify-icon icon="mdi:calendar-alert" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Leave</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="/leaveRecord" aria-expanded="false">
            <span>
              <iconify-icon icon="mdi:clipboard-list-outline" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Leave Record</span>
          </a>
        </li>
        <li class="sidebar-item">
                    <a class="sidebar-link" href="/getdocuments" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:document-add-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Documents</span>
                        <span id="chatNotificationBadge" class="badge bg-danger ms-2" style="display: none;">0</span>
                    </a>
                </li>
        <!-- <li class="nav-small-cap">
          <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6" class="fs-6"></iconify-icon>
          <span class="hide-menu">AUTH</span>
        </li> -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="/logout" onclick="return confirm('Are you sure you want to logout?');" aria-expanded="false">
            <span>
              <iconify-icon icon="mdi:exit-to-app" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Logout</span>
          </a>
        </li>
        <!-- <li class="sidebar-item">
          <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
            <span>
              <iconify-icon icon="solar:user-plus-rounded-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Register</span>
          </a>
        </li> -->
        <!-- <li class="nav-small-cap">
          <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4" class="fs-6"></iconify-icon>
          <span class="hide-menu">EXTRA</span>
        </li> -->
        <!-- <li class="sidebar-item">
          <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
            <span>
              <iconify-icon icon="solar:sticker-smile-circle-2-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Icons</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
            <span>
              <iconify-icon icon="solar:planet-3-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Sample Page</span>
          </a>
        </li> -->
      </ul>
      <!-- <div class="unlimited-access hide-menu bg-primary-subtle position-relative mb-7 mt-7 rounded-3"> 
        <div class="d-flex">
          <div class="unlimited-access-title me-3">
            <h6 class="fw-semibold fs-4 mb-6 text-dark w-75">Upgrade to pro</h6>
            <a href="#" target="_blank"
              class="btn btn-primary fs-2 fw-semibold lh-sm">Buy Pro</a>
          </div>
          <div class="unlimited-access-img">
            <img src="../assets/images/backgrounds/rocket.png" alt="" class="img-fluid">
          </div>
        </div>
      </div> -->
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<script>
  function fetchUnreadChatCount() {
      fetch('/chat/unread-count', {
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              'Accept': 'application/json'
          }
      })
      .then(response => response.json())
      .then(data => {
          const badge = document.getElementById('chatNotificationBadge');
          if (data.unread_count > 0) {
              badge.innerText = data.unread_count;
              badge.style.display = 'inline-block';
          } else {
              badge.innerText = '';
              badge.style.display = 'none';
          }
      })
      .catch(err => {
          console.error('Failed to fetch unread chat count:', err);
      });
  }

  // Poll every 2 seconds
  setInterval(fetchUnreadChatCount, 2000);
  // Fetch immediately on page load
  fetchUnreadChatCount();
</script>