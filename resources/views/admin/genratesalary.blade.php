@include('admin.layouts.head')

<style>

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
                                {{-- <h4>Generate Salary</h4> --}}
                                <br>
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
    Genrate Payslip for {{ $user->name }}
  </h2>
  <h2 class="card-title fw-bold text-primary"></h2>
</div>
                                <br>
                                <div class="card-body">
                                    <form action="{{ route('salary.store', ['id' => $user->id]) }}" method="POST" id="generate-salary-form"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                                        {{-- ─── ROW 1: Month / Year ─── --}}
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-2">
                                                <label for="month" class="form-label">Month</label>
                                                <select id="month" class="form-select" name="month" required>
                                                    <option value="">Select Month</option>
                                                    @foreach (range(1, 12) as $m)
                                                        <option value="{{ $m }}">
                                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="year" class="form-label">Year</label>
                                                <select id="year" class="form-select" name="year" required>
                                                    <option value="">Select Year</option>
                                                    @foreach (range(2024, 2030) as $yr)
                                                        <option value="{{ $yr }}">{{ $yr }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ─── ALLOWANCES SECTION ─── --}}
                                        <h6 class="mb-3">Allowances</h6>
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4">
                                                <label for="basic_salary" class="form-label">Basic Salary</label>
                                                <input type="number" id="basic_salary" name="basic_salary"
                                                    class="form-control" min="0" step="0.01"
                                                    placeholder="e.g. 25000" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="other_allowances" class="form-label">Other
                                                    Allowances</label>
                                                <input type="number" id="other_allowances" name="other_allowances"
                                                    class="form-control" min="0" step="0.01"
                                                    placeholder="e.g. 5000" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="incentive_pay" class="form-label">Incentive Pay</label>
                                                <input type="number" id="incentive_pay" name="incentive_pay"
                                                    class="form-control" min="0" step="0.01"
                                                    placeholder="e.g. 2000" required>
                                            </div>
                                        </div>

                                        <hr>

                                        {{-- ─── DEDUCTIONS SECTION ─── --}}
                                        <h6 class="mb-3">Deductions</h6>
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4">
                                                <label for="provident_fund" class="form-label">Provident Fund</label>
                                                <input type="number" id="provident_fund" name="provident_fund"
                                                    class="form-control" min="0" step="0.01"
                                                    placeholder="e.g. 1800" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="professional_tax" class="form-label">Professional
                                                    Tax</label>
                                                <input type="number" id="professional_tax" name="professional_tax"
                                                    class="form-control" min="0" step="0.01"
                                                    placeholder="e.g. 200" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="other_deduction" class="form-label">Other Deduction</label>
                                                <input type="number" id="other_deduction" name="other_deduction"
                                                    class="form-control" min="0" step="0.01"
                                                    placeholder="e.g. 500" required>
                                            </div>
                                        </div>

                                        <hr>

                                        {{-- ─── NET PAY SECTION ─── --}}
                                        <h6 class="mb-3">Net Pay</h6>
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4">
                                                <label for="total_allowances" class="form-label">Total
                                                    Allowances</label>
                                                <input type="number" id="total_allowances" name="total_allowances"
                                                    class="form-control bg-light" min="0" step="0.01"
                                                    placeholder="Auto-calculated" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="total_deduction" class="form-label">Total
                                                    Deduction</label>
                                                <input type="number" id="total_deduction" name="total_deduction"
                                                    class="form-control bg-light" min="0" step="0.01"
                                                    placeholder="Auto-calculated" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="net_salary" class="form-label">Net Salary</label>
                                                <input type="number" id="net_salary" name="net_salary"
                                                    class="form-control bg-light" min="0" step="0.01"
                                                    placeholder="Auto-calculated" readonly>
                                            </div>
                                        </div>

                                        {{-- ─── ROW 5: Submit Button ─── --}}
                                        <div class="row">
                                            <div class="col-md-12 text-start">
                                                <button type="submit" class="btn btn-primary px-4">
                                                    Generate Salary
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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

{{-- ─── JavaScript: Auto‐Calculate Totals ─── --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fields = {
            basic: document.getElementById('basic_salary'),
            otherAll: document.getElementById('other_allowances'),
            incentive: document.getElementById('incentive_pay'),
            pf: document.getElementById('provident_fund'),
            profTax: document.getElementById('professional_tax'),
            otherDed: document.getElementById('other_deduction'),
            totalAll: document.getElementById('total_allowances'),
            totalDed: document.getElementById('total_deduction'),
            netSal: document.getElementById('net_salary'),
        };

        function calculateTotals() {
            const a = parseFloat(fields.basic.value) || 0;
            const b = parseFloat(fields.otherAll.value) || 0;
            const c = parseFloat(fields.incentive.value) || 0;
            const d = parseFloat(fields.pf.value) || 0;
            const e = parseFloat(fields.profTax.value) || 0;
            const f = parseFloat(fields.otherDed.value) || 0;

            const allowances = a + b + c;
            const deductions = d + e + f;
            const net = allowances - deductions;

            fields.totalAll.value = allowances.toFixed(2);
            fields.totalDed.value = deductions.toFixed(2);
            fields.netSal.value = net.toFixed(2);
        }

        [
            fields.basic,
            fields.otherAll,
            fields.incentive,
            fields.pf,
            fields.profTax,
            fields.otherDed
        ].forEach(el => {
            el.addEventListener('input', calculateTotals);
        });
    });
</script>
