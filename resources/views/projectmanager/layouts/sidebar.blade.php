<style>
    .submenu-dot {
        color: #007bff;
        /* Blue dot */
        font-size: 40px;
        margin-right: 7px;
        margin-bottom: 6px;
    }

    .logo-img img {
        width: 100%;
        height: 75px;
        margin-top: 10px;
    }

    span.hide-menu {
        margin-left: 5px;
    }

    .logo-img {
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

    .sidebar-nav ul .sidebar-item.selected>.sidebar-link.active,
    .sidebar-nav ul .sidebar-item.selected>.sidebar-link,
    .sidebar-nav ul .sidebar-item>.sidebar-link.active {
        background-color: #093862 !important;
        color: #fff;
    }

    .sidebar-nav ul .sidebar-item.selected>.sidebar-links.active,
    .sidebar-nav ul .sidebar-item.selected>.sidebar-link,
    .sidebar-nav ul .sidebar-item>.sidebar-link.active {
        background-color: #093862d1 !important;
        color: #fff;
    }


    .left-sidebar {
        width: 270px !important;
    }

    .sidebar-items {
        margin-bottom: 0px !important;
    }
</style>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="/hr-dashboard" class="text-nowrap logo-img">
                <img src="../assets/images/logos/newbird.png" alt="" />
                {{-- <h2>IDICE SYSTEMS</h2> --}}
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar " data-simplebar="">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/projectmanager-dashboard" aria-expanded="false">
                        <span>
                            <iconify-icon icon="mdi:view-dashboard" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="/project-list" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:money-bag-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">My Projects</span>
                        <span id="chatNotificationBadge" class="badge bg-danger ms-2" style="display: none;">0</span>
                    </a>
                </li> --}}
                <li class="sidebar-item {{ request()->is('addproject') || request()->is('projectlist') ? 'active' : '' }}">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <span>
                              <iconify-icon icon="mdi:clipboard-text" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Projects</span>
                    </a>
                    <ul class="collapse first-level {{ request()->is('addproject') || request()->is('projectlist') ? 'in' : '' }}" style="margin-left: 45px;">
                       <li class="sidebar-item">
                            <a class="sidebar-links sidebar-link {{ request()->is('projectlist') ? 'd-flex align-items-center active' : '' }}" href="/project-list">
                                {{-- <span class="hide-menu">Project List</span> --}}
                                <span class="submenu-dot">•</span> <span class="hide-menu">Project List</span>
                            </a>
                        </li>
                        <li class="sidebar-item sidebar-items">
                            <a class="sidebar-links sidebar-link {{ request()->is('addproject') ? 'd-flex align-items-center active' : '' }}" href="/addprojects">
                                {{-- <span class="hide-menu">Add Projects</span> --}}
                                <span class="submenu-dot">•</span> <span class="hide-menu">Add Projects</span>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/myteam" aria-expanded="false">
                        <span>
                            <iconify-icon icon="mdi:account-group" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Team Members</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/projectTask" aria-expanded="false">
                        <span>
                            <iconify-icon icon="mdi:account-group" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Project Task</span>
                    </a>
                </li>

                {{-- <li class="sidebar-item {{ request()->is('employee*') ? 'active' : '' }}">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <span>
                            <iconify-icon icon="mdi:account-group" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Employees</span>
                    </a>
                    <ul class="collapse first-level {{ request()->is('employee*') ? 'in' : '' }}"
                        style="margin-left: 45px;">
                        <li class="sidebar-item" style="margin-bottom: 0px;">
                            <a class="sidebar-link sidebar-links" href="#">
                                <span class="submenu-dot">•</span> <span class="hide-menu">All Employees</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('addemployee') ? 'active' : '' }}">
                            <a class="sidebar-link sidebar-links" href="#">
                                <span class="submenu-dot">•</span> <span class="hide-menu">Add Employee</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span>
                            <iconify-icon icon="mdi:calendar-alert" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Leave Request </span>
                        @if ($pendingCount > 0)
                            <span class="badge bg-danger ms-2">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:document-add-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Documents</span>
                        <span id="chatNotificationBadge" class="badge bg-danger ms-2" style="display: none;">0</span>
                    </a>
                </li> --}}

                {{-- <li class="sidebar-item {{ request()->is('getCheckInData') || request()->is('taskreport') ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow {{ request()->is('getCheckInData') || request()->is('taskreport') ? 'active' : '' }}" 
                       href="javascript:void(0)" aria-expanded="false">
                        <span>
                            <iconify-icon icon="mdi:clipboard-text-outline" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Reports</span>
                    </a>
                    <ul class="collapse first-level {{ request()->is('getCheckInData') || request()->is('taskreport') ? 'show' : '' }}" style="margin-left: 45px;">
                        <li class="sidebar-item" style="margin-bottom: 0px">
                            <a class="sidebar-link sidebar-links {{ request()->is('getCheckInData') ? 'active' : '' }}" href="/hr-getCheckInData">
                                <span class="submenu-dot">•</span> <span class="hide-menu">Check In/out</span>
                            </a>
                        </li>
                        
                        <li class="sidebar-item" style="margin-bottom: 0px">
                            <a class="sidebar-link sidebar-links {{ request()->is('leavereport') ? 'active' : '' }}"
                                href="/hr-leave-report">
                                <span class="submenu-dot">•</span> <span class="hide-menu">Leave Report</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}


                <li class="sidebar-item">
                    <a class="sidebar-link" href="/logout" onclick="return confirm('Are you sure you want to logout?');"
                        aria-expanded="false">
                        <span>
                            <iconify-icon icon="mdi:exit-to-app" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
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
