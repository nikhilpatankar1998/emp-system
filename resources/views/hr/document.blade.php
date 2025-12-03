<style>
 @media screen and (max-width: 640px) {
    div.dt-buttons {
        float: none !important;
        text-align: start !important;
    }
}
</style>

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
                                <h4>Upload Documents for Employee</h4>
                                <!-- Employee Table -->
                              <div class="table-responsive">
                                <table id="employeeTable" class="table table-bordered text-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">ID</th>
                                            <th scope="col" class="text-center">Name</th>
                                            <th scope="col" class="text-center">Date Of Birth</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        @foreach ($user as $item)
                                            <tr>
                                                <td class="text-center fw-medium">{{ $item->id }}</td>
                                                <td class="text-center fw-medium">{{ $item->name }}</td>
                                                <td class="text-center fw-medium">{{ $item->date_of_joining }}</td>
                                                <td class="text-center fw-medium">
                                                    <a href="{{ route('hr.uploadDocument', $item->id) }}" class="btn btn-primary">Upload Document</a>
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
@include('hr.layouts.footer')
