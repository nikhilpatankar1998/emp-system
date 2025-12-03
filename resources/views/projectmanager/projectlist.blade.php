@include('projectmanager.layouts.head')

<style>
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

    @media screen and (max-width: 640px) {

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            float: none;
            text-align: left !important;
        }
    }

    @media screen and (max-width: 640px) {
        div.dt-buttons {
            float: none !important;
            text-align: start !important;
        }
    }
</style>

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('projectmanager.layouts.sidebar')

        <div class="body-wrapper">

            @include('projectmanager.layouts.header')

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
                                <h2 class="text-left" style="font-size:23px; margin-bottom:25px">Project List</h2>

                                <!-- Responsive Table Wrapper -->
                                <div class="table-responsive">
                                    <!-- Employee Table -->
                                    <table id="employeeTable"
                                        class="table table-bordered text-nowrap align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-center">ID</th>
                                                <th scope="col" class="text-center">Project Name</th>
                                                <th scope="col" class="text-center">Start Date</th>
                                                <th scope="col" class="text-center">End Date</th>
                                                <th scope="col" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="text-center fw-medium">{{ $item->id }}</td>
                                                    <td class="text-center fw-medium">{{ $item->name }}</td>
                                                    <td class="text-center fw-medium">{{ $item->start_date }}</td>
                                                    <td class="text-center fw-medium">{{ $item->end_date }}</td>
                                                    <td class="text-center fw-medium">
                                                        {{-- <a href="{{ url('/project-tasks/' . $item->id) }}"
                                                            class="btn btn-sm btn-primary me-1"
                                                            style="border-radius: 5px;">
                                                            <i class="fas fa-plus"></i> Add Tasks
                                                        </a>

                                                        <a href="{{ url('/tasks-list/' . $item->id) }}"
                                                            class="btn btn-sm btn-primary me-1"
                                                            style="border-radius: 5px;">
                                                            <i class="fas fa-tasks"></i> Task List
                                                        </a> --}}

                                                        <a href="{{ url('/editprojects/' . $item->id) }}"
                                                            class="btn btn-sm btn-secondary me-1"
                                                            style="border-radius: 5px;">
                                                            <i class="ti ti-edit"></i>
                                                        </a>

                                                        <a href="{{ url('/viewprojects/' . $item->id) }}"
                                                            class="btn btn-sm btn-secondary"
                                                            style="border-radius: 5px;">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
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
</body>
@include('projectmanager.layouts.footer')
