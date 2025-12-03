@include('hr.layouts.head')

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('hr.layouts.sidebar')

        <div class="body-wrapper">

            @include('hr.layouts.header')

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
                                <h4></h4>
                                <!-- Employee Table -->
                                <div class="container">
                                    <h4 class="mb-4">Payslips for {{ $user->name }}</h4>

                                    @if ($salaries->isEmpty())
                                        <p>No payslips found.</p>
                                    @else
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Month / Year</th>
                                                    {{-- <th>Year</th> --}}
                                                    <th>Generated On</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($salaries as $index => $salary)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ date('F', mktime(0, 0, 0, $salary->month, 1)) }} /
                                                            {{ $salary->year }}</td>
                                                        {{-- <td>{{ $salary->year }}</td> --}}
                                                        <td>{{ $salary->created_at->format('d M, Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('hr.salary.view', [$user->id, $salary->id]) }}"
                                                                class="btn btn-sm btn-primary" target="_blank">
                                                                View Payslip
                                                            </a>
                                                           {{-- <a href="{{ route('salary.download', [$user->id, $salary->id]) }}"
                                                                class="btn btn-sm btn-success">
                                                                Download PDF
                                                            </a> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@include('hr.layouts.footer')
