@include('admin.layouts.head')

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
                                <h2>Leave's of Month</h2>
                                <br>
                                <div class="col-lg-12">
                                    <div class="card shadow-sm border-0 rounded-4">
                                        <div class="card-body">
                                            <div  class="datatitlenew mb-4">
                                                <h4 class="mb-0 card-title text-start fw-bold text-primary">Employees
                                                    (Leave)</h4>
                                                <p class="text-start mb-0 fs-3"
                                                    style="color: #dd0101;font-weight: 500;">- &nbsp;Current Month</p>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered align-middle text-left">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>FullName</th>
                                                            <th>Leave Type</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($leave as $leaves)
                                                            <tr>
                                                                <td class="fw-semibold text-nowrap">
                                                                    {{ $leaves->user->name }}
                                                                    ({{ $leaves->leave_duration }})</td>
                                                                <td class="text-nowrap">{{ $leaves->leave_type }}</td>
                                                                <td class="text-nowrap">{{ $leaves->from_date }}</td>
                                                                <td class="text-nowrap">{{ $leaves->to_date }}</td>
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
            </div>
        </div>
    </div>
</body>
@include('admin.layouts.footer')
