@include('user.layouts.head')
<style>
  .container {
    margin-top: 100px;
  }

  .counter-box {
    display: flex;
    background: #0c0c0c3b;
    padding: 15px 15px;
    text-align: center;
    border-radius: 5px;
    align-items: center;
    justify-content: center;
    flex-direction: column;
  }

  .counter-box p {
    margin: 5px 0 0;
    padding: 0;
    color: #454242;
    font-size: 16px;
    font-weight: 600;
  }

  .counter-box i {
    font-size: 60px;
    margin: 0 0 15px;
    color: #d2d2d2;
  }

  .counter {
    font-size: 32px;
    font-weight: 700;
    color: #525050;
    line-height: 28px;
    background: #a3abb2;
    padding: 11px;
    border-radius: 100%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .counter-box.colored {
    background: #093862de;
  }

  .card-title {
    font-size: 22px !important;
    margin-bottom: 15px !important;
  }

  .datafont {
    margin-bottom: 15px !important;
  }

  .counter-box.colored p,
  .counter-box.colored i,
  .counter-box.colored .counter {
    color: #fff;
  }

  .counter-box {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    height: 200px;
    /* Fixed height for all cards */
    width: 100%;
    /* Ensures the width is uniform across all columns */
    max-width: 180px;
    /* Max width ensures all counter boxes don't stretch too far */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #f9f9f9;
  }

  .counter-box i {
    font-size: 36px;
    color: #666;
  }

  .counter {
    font-size: 36px;
    font-weight: bold;
    color: #333;
  }

  button {
    width: 100%;
    /* Ensure buttons are full-width inside their container */
    margin-top: 10px;
    border-radius: 5px;
  }

  #timerDisplay {
    font-size: 24px;
    font-weight: bold;
    color: white;
  }

  .col-md-3 {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 20%;
  }

  .counter-box.col-md-3 {
    padding: 0;
    /* Remove internal padding of columns */
  }

  button {
    width: 100%;
    margin-top: 10px;
    border-radius: 5px;
  }

  #employeeTable_wrapper {
    margin-bottom: 20px;
  }

  #employeeTable_length {
    margin-bottom: 20px;
  }

  #employeeTable_info {
    margin-top: 20px;
  }

  #employeeTable_paginate {
    margin-top: 20px;
  }

  @media screen and (max-width: 420px) {
    .card-title {
      font-size: 14px !important;
      margin-bottom: 15px !important;
    }
    .datafont {
      margin-bottom: 15px !important;
      font-size: 8px !important;
      padding: 7px 6px !important;
    }
    .col-md-3 {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 15px;
      width: 100%;
    }
  }

  @media screen and (max-width: 768px) {
    .card-title {
      font-size: 14px !important;
      margin-bottom: 15px !important;
    }
    .datafont {
      margin-bottom: 15px !important;
      font-size: 8px !important;
      padding: 7px 6px !important;
    }
    .col-md-3 {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 15px;
      width: 100%;
    }
  }

  @media screen and (max-width: 1200px) {
    .card-title {
      font-size: 14px !important;
      margin-bottom: 15px !important;
    }
    .datafont {
      margin-bottom: 15px !important;
      font-size: 8px !important;
      padding: 7px 6px !important;
    }
    .col-md-3 {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 15px;
      width: 100%;
    }
  }

  @media screen and (max-width: 640px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
      float: none;
      text-align: left !important;
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
    @include('user.layouts.sidebar')

    <div class="body-wrapper">
      @include('user.layouts.header')

      <div class="container-fluid" style="background-color: #f6f8fa;">
        <div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card shadow-sm border-info">
                <div class="card-body">
                  <h5 class="mb-3 text-primary">
                    System Alert – Admin Message
                  </h5>


                  @if($broadcast)
                  <div class="col-md-12 mb-2">
                    {{--
                    <p
                      class="broadcast-blink alert alert-warning text-center fw-bold m-0"
                    >
                      {{ $broadcast->message }}
                    </p>
                    --}}
                    <marquee
                      behavior="scroll"
                      direction="left"
                      scrollamount="8"
                      scrolldelay="0"
                      loop="infinite"
                      class="alert alert-warning text-center fw-bold m-0 fs-4"
                    >
                      {{ $broadcast->message }}
                    </marquee>
                  </div>
                  @else
                  <div class="col-md-12 mb-2">
                    <h6 class="alert alert-secondary text-center m-0">
                      No alerts for today.
                    </h6>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
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

                <div
                  class="d-flex justify-content-between align-items-center mb-3"
                >
                  <h1 class="card-title fw-bold text-primary mb-0" style="margin-bottom: 0px !important; background: #dde2e8;
                                    padding: 8px 10px;
                                    border-radius: 5px;" >User Dashboard</h1>
                  <div class="d-flex align-items-center position-relative">
                    <a
                      href="{{ url('/download-app') }}"
                      class="btn btn-primary me-2"
                      download
                    >
                      Download Screenshot App
                    </a>

                    <svg
                      class="position-absolute"
                      xmlns="http://www.w3.org/2000/svg"
                      width="48"
                      height="48"
                      viewBox="0 0 24 24"
                      fill="none"
                      data-bs-toggle="modal"
                      data-bs-target="#howToUseModal"
                      style="
                        cursor: pointer;
                        top: -13px;
                        right: -1px;
                        border: 3px solid #aaab44;
                        border-radius: 7px;
                        padding: 0px;
                        width: 30px;
                        background: #295276;
                        height: 30px;
                        padding: 3px;
                      "
                    >
                      <path
                        fill="#FFD600"
                        d="M12 2a7 7 0 0 0-3.5 13.09V18a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-2.91A7 7 0 0 0 12 2z"
                      />
                      <path
                        fill="#FFA000"
                        d="M10 22h4a1 1 0 0 0 1-1v-1h-6v1a1 1 0 0 0 1 1z"
                      />
                    </svg>
                  </div>
                  <div class="d-flex align-items-center position-relative">
                                        <a href="{{ url('/download-app-v1') }}" class="btn btn-primary me-2" download>
                                            Download Screenshot App -v1
                                        </a>

                                        
                                            <svg class="position-absolute" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" data-bs-toggle="modal" data-bs-target="#howToUseModal" style="cursor: pointer;
    top: -13px;
    right: -1px;
    border: 3px solid #aaab44;
    border-radius: 7px;
    padding: 0px;
    width: 30px;
    background: #295276;
    height: 30px;
    padding: 3px">
                                            <path fill="#FFD600" d="M12 2a7 7 0 0 0-3.5 13.09V18a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-2.91A7 7 0 0 0 12 2z"/>
                                            <path fill="#FFA000" d="M10 22h4a1 1 0 0 0 1-1v-1h-6v1a1 1 0 0 0 1 1z"/>
                                            </svg>
                                    </div>
                </div>

                <div class="row">
                  <div class="col-12 col-md-3">
                    <div class="counter-box colored">
                      <div
                        id="timerDisplay"
                        class="text-center mt-3"
                        style="font-size: 24px"
                      >
                        00:00
                      </div>
                      <button id="checkInBtn" class="btn btn-success mt-2">
                        Check In
                      </button>
                      <button
                        id="pauseBtn"
                        class="btn btn-warning mt-2"
                        style="display: none"
                      >
                        Pause
                      </button>
                      <button
                        id="resumeBtn"
                        class="btn btn-info mt-2"
                        style="display: none"
                      >
                        Resume
                      </button>
                      <button
                        id="checkOutBtn"
                        class="btn btn-danger mt-2"
                        style="display: none"
                      >
                        Check Out
                      </button>
                    </div>
                  </div>
                  {{--
                  <div class="col-12 col-md-3">
                    <div class="counter-box">
                      <div
                        id="timerDisplay"
                        class="text-center mt-3"
                        style="font-size: 24px"
                      >
                        0hr 00min
                      </div>
                      <button id="checkInBtn" class="btn btn-success mt-2">
                        Check In
                      </button>
                      <button
                        id="checkOutBtn"
                        class="btn btn-danger mt-2"
                        style="display: none"
                      >
                        Check Out
                      </button>
                    </div>
                  </div>
                  --}}

                  <div class="col-12 col-md-3">
                    <div class="counter-box colored">
                      <i class="fa fa-thumbs-o-up"></i>
                      <span class="counter">{{ $projectCount }}</span>
                      <p>Assigned Projects</p>
                    </div>
                  </div>

                  <div class="col-12 col-md-3">
                    <div class="counter-box">
                      <i class="fa fa-group"></i>
                      <span class="counter">{{ $tasks }}</span>
                      <p>Assigned Tasks</p>
                    </div>
                  </div>

                  <div class="col-12 col-md-3">
                    <div class="counter-box">
                      <i class="fa fa-shopping-cart"></i>
                      <span class="counter">{{ $completedtasks }}</span>
                      <p>Completed Tasks</p>
                    </div>
                  </div>

                  <div class="col-12 col-md-3">
                    <div class="counter-box">
                      <i class="fa fa-user"></i>
                      <span class="counter">{{ $incompleteTasks }}</span>
                      <p>Incomplete Tasks</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Check-in Modal -->
            <div
              class="modal fade"
              id="checkInModal"
              tabindex="-1"
              aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Check In</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <p>Current Time: <span id="currentTime"></span></p>
                    <textarea
                      name="chek_in_time"
                      id="checkInTask"
                      class="form-control"
                      cols="20"
                      rows="10"
                      placeholder="Enter task description"
                      required
                    ></textarea>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      id="confirmCheckIn"
                      class="btn btn-success"
                    >
                      Confirm
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Check-out Modal -->
            <div
              class="modal fade"
              id="checkOutModal"
              tabindex="-1"
              aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Check Out</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <p>
                      Tasks entered at check-in:
                      <span id="previousTasks"></span>
                    </p>
                    <p>Total Time Spent: <span id="totalTime"></span></p>
                    {{--
                    <input
                      type="text"
                      id="checkOutTask"
                      class="form-control"
                      placeholder="Enter end-of-day summary"
                    />
                    --}}
                    <textarea
                      name="chek_in_time"
                      id="checkOutTask"
                      class="form-control"
                      cols="20"
                      rows="10"
                      placeholder="Enter task description"
                      required
                    ></textarea>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      id="confirmCheckOut"
                      class="btn btn-danger"
                    >
                      Confirm
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="container-fluid"> -->
            <!-- <div class="row"> -->
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
<div class="d-flex justify-content-center align-items-center mb-3" style="
                                    background: #dde2e8;
                                    padding: 10px;
                                    border-radius: 5px;
                                ">
                                
                                <h2 class="card-title fw-bold text-primary mb-0" style="margin-bottom: 0px !important">
                                Assigned Projects
                                </h2>
                                
                                </div>
                  <!-- Responsive Table Wrapper -->
                  <div class="table-responsive">
                    <!-- Employee Table -->
                    <table
                      id="employeeTable"
                      class="table table-bordered text-nowrap align-middle mb-0"
                    >
                      <thead class="table-light">
                        <tr>
                          <th scope="col" class="text-left">ID</th>
                          <th scope="col" class="text-left">Project Name</th>
                          <th scope="col" class="text-left">Start Date</th>
                          <th scope="col" class="text-left">End Date</th>
                          <th scope="col" class="text-left">Actions</th>
                        </tr>
                      </thead>
                      <tbody class="table-group-divider">
                        @foreach ($projects as $item)
                        <tr>
                          <td class="text-left fw-medium text-nowrap">
                            {{ $item->id }}
                          </td>
                          <td class="text-left fw-medium text-normal" style="width: 50%; white-space: normal; word-wrap: break-word;">
                            {{ $item->name }}
                          </td>
                          <td class="text-left fw-medium text-nowrap">
                            {{ $item->start_date }}
                          </td>
                          <td class="text-left fw-medium text-nowrap">
                            {{ $item->end_date }}
                          </td>
                          {{--
                          <td class="text-left fw-medium text-nowrap">
                            <a class="btn btn-primary" href="/project-task"
                              >Tasks</a
                            >
                          </td>
                          --}}
                          <td class="text-left fw-medium text-nowrap">
                            <a
                              class="btn btn-primary"
                              href="{{ url('/project-task/' . $item->id) }}"
                              >Task History</a
                            >

                            <a
                              class="btn btn-primary"
                              href="{{ url('/addnew-task/' . $item->id) }}"
                              >Add Tasks</a
                            >
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
          <!-- </div> -->
          <!-- </div> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div
    class="modal fade"
    id="howToUseModal"
    tabindex="-1"
    aria-labelledby="howToUseModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="howToUseModalLabel">
            How to Use Screenshot App
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <ol>
            <li>
              Download the Screenshot App using the "Download Screenshot App"
              button.
            </li>

            <li>
              After <strong>checking in</strong> via DODolog manually,
              <strong>start the Screenshot App</strong> by double-clicking
              <code>ScreenshotApp.exe</code>.
            </li>

            <li>
              Click the <strong>Start</strong> button in the app to begin
              capturing screenshots and tracking time.
            </li>

            <li>
              The app interface displays:
              <ul>
                <li>
                  <strong>Total Time</strong> – Total duration since you started
                  tracking.
                </li>
                <li>
                  <strong>Active Time</strong> – Time actively spent using the
                  system.
                </li>
                <li>
                  <strong>Inactive Time</strong> – Time without activity (if
                  available).
                </li>
                <li>
                  <strong>Screenshots Taken</strong> – Total number of
                  screenshots captured.
                </li>
              </ul>
            </li>

            <li>
              Use <strong>Pause</strong> to temporarily stop capturing, and
              <strong>Stop</strong> to end the session.
            </li>
            <li>
              Click <strong>Exit</strong> to close the application when done
              working.
            </li>
          </ol>
          <p class="text-muted">
            Tip: For quick access, right-click the app icon and select
            <strong>“Pin to Taskbar.”</strong>
          </p>
        </div>
      </div>
    </div>
  </div>
</body>

@include('user.layouts.footer')

<script>
  $(document).ready(function () {
    $(".counter").each(function () {
      $(this)
        .prop("Counter", 0)
        .animate(
          {
            Counter: $(this).text(),
          },
          {
            duration: 4000,
            easing: "swing",
            step: function (now) {
              $(this).text(Math.ceil(now));
            },
          }
        );
    });
  });
</script>

{{-- working code --}}

<script>
  $(document).ready(function () {
    let checkInTime = null;
    let elapsedTime = 0;
    let interval = null;
    let pausedTime = 0;

    // Set up CSRF token for all AJAX requests
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });

    function updateTimerDisplay() {
      let hours = Math.floor(elapsedTime / 3600);
      let minutes = Math.floor((elapsedTime % 3600) / 60);
      let seconds = elapsedTime % 60;
      $("#timerDisplay").text(
        // `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`
        `${hours}:${minutes < 10 ? "0" : ""}${minutes}:${
          seconds < 10 ? "0" : ""
        }${seconds}`
      );
    }

    function startTimer() {
      interval = setInterval(() => {
        elapsedTime++;
        updateTimerDisplay();
      }, 1000);
    }

    $("#checkInBtn").click(function () {
      let currentTime = new Date().toLocaleTimeString();
      $("#currentTime").text(currentTime);
      $("#checkInModal").modal("show");
    });

    $("#confirmCheckIn").click(function () {
      let taskDescription = $("#checkInTask").val();
      $.post(
        "/check-in",
        {
          task_description: taskDescription,
        },
        function (response) {
          checkInTime = new Date();
          pausedTime = 0;
          $("#previousTasks").text(taskDescription);
          $("#checkInBtn").hide();
          $("#pauseBtn, #checkOutBtn").show();
          $("#checkInModal").modal("hide");
          startTimer();
        }
      );
    });

    $("#pauseBtn").click(function () {
      clearInterval(interval);
      $(this).hide();
      $("#resumeBtn").show();

      $.post(
        "/pause-time",
        {
          paused_time: elapsedTime,
        },
        function (response) {
          pausedTime = elapsedTime;
        }
      );
    });

    $("#resumeBtn").click(function () {
      checkInTime = new Date() - elapsedTime * 1000;
      startTimer();
      $(this).hide();
      $("#pauseBtn").show();
    });

    // $('#checkOutBtn').click(function() {
    //     let taskDescription = $('#previousTasks').text();
    //     $.post('/checkout', {
    //         task_description: taskDescription
    //     }, function(response) {
    //         let totalTime = response.total_time;
    //         let hours = Math.floor(elapsedTime / 3600);
    //         let minutes = Math.floor(totalTime / 60);
    //         let seconds = totalTime % 60;
    //         $('#totalTime').text(
    //             // `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`
    //             `${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`
    //         );
    //         $('#checkOutModal').modal('show');
    //     });
    // });

    // $('#confirmCheckOut').click(function() {
    //     $('#checkOutModal').modal('hide');
    //     alert('Check-out successful!');
    // });

    $("#checkOutBtn").click(function () {
      $("#checkOutModal").modal("show"); // Show check-out modal instead of submitting
    });

    $("#confirmCheckOut").click(function () {
      let taskDescription = $("#checkOutTask").val().trim();
      if (!taskDescription) {
        alert("Please enter a task description before checking out.");
        return;
      }

      $.post(
        "/checkout",
        {
          task_description: taskDescription,
        },
        function (response) {
          let totalTime = response.total_time;
          let hours = Math.floor(totalTime / 3600);
          let minutes = Math.floor((totalTime % 3600) / 60);
          let seconds = totalTime % 60;
          $("#totalTime").text(
            `${hours}:${minutes < 10 ? "0" : ""}${minutes}:${
              seconds < 10 ? "0" : ""
            }${seconds}`
          );
          $("#checkOutModal").modal("hide");
          alert("Check-out successful!");
          location.reload();
        }
      );
    });

    // Check the check-in status on page load
    $.get("/check-in-status", function (response) {
      if (response.checked_in) {
        elapsedTime = response.elapsed_time;
        checkInTime = new Date() - elapsedTime * 1000;
        $("#previousTasks").text(response.in_description);
        $("#checkInBtn").hide();
        $("#pauseBtn, #checkOutBtn").show();
        startTimer();
      }
    });
  });
</script>

{{-- working code --}}
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
</script>
