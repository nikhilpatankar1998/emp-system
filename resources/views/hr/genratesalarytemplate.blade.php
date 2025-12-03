{{-- resources/views/admin/genratesalarytemplate.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        Salary Slip - {{ $user->name }}
        ({{ date('F', mktime(0, 0, 0, $salary->month, 1)) }} {{ $salary->year }})
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS (adjust if you already load it elsewhere) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Force a consistent max-width on the payslip so content doesn’t stretch out wide */
        .payslip-wrapper {
            max-width: 800px;
            margin: 0 auto;
            /* center horizontally */
            padding: 10px;
            /* some breathing room */
        }

        /* Header image sizing */
        .header-img {
            width: 100%;
            max-height: 120px;
            /* object-fit: contain; */
        }

        /* Footer image sizing (if you have one) */
        .footer-img {
            width: 100%;
            max-height: 80px;
            object-fit: contain;
            margin-top: 2rem;
        }

        /* Ensure salary table rows are vertically centered */
        .salary-table th,
        .salary-table td {
            vertical-align: middle;
        }

        /* Slight padding on user‐details table cells */
        .user-details td {
            padding: 0.25rem 0.5rem;
        }

        @media print {

            /* If you ever print, keep a page break after the slip */
            .page-break {
                page-break-after: always;
            }
        }

        /* Add outer border around entire payslip */
        .payslip-wrapper {
            border: 2px solid #999;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            background-color: #fff;
        }

        /* Add border and spacing to user-details table */
        .user-details {
            border: 1px solid #dee2e6;
            padding: 8px;
            border-radius: 5px;
        }

        /* Make salary table look sharper */
        .salary-table th,
        .salary-table td {
            border-color: #333 !important;
        }

        /* Highlight section headers more boldly */
        .salary-table .table-secondary {
            background-color: #d6d6d6 !important;
            font-weight: bold;
        }

        /* Clean top and bottom table summary rows */
        .salary-table .table-light {
            background-color: #f1f1f1 !important;
        }

        .salary-table .table-success {
            background-color: #d4edda !important;
            font-weight: bold;
            font-size: 13.5px;
        }

        /* Add spacing from footer image */
        .footer-img {
            margin-top: 40px;
        }

        .payslip-wrapper {
            font-size: 13px;
            /* was 11px */
        }
        
    </style>
</head>

<body class="bg-white">

    <div class="payslip-wrapper" style="max-width: 600px; margin: 0 auto; padding: 5px; font-size: 11px;">

        {{-- ─── CENTERED HEADER IMAGE ─── --}}
        <div class="text-center mb-4">
            {{--<img src="{{ asset('assets/images/NEW-HEADER.jpeg') }}" alt="IDICE Header" class="header-img"> --}}
        </div>
      <div style="margin: 2px; padding-left: 25px; padding-top:14px">
       <img src="{{ asset('assets/images/auralogo.jpeg') }}" alt="no" style="height: 60px;">
      </div>

        {{-- ─── TITLE ─── --}}
        <div class="text-center mb-3">
            <h6 class="fw-bold">Salary Slip </h6>
            <p class="mb-0">
                {{ date('F', mktime(0, 0, 0, $salary->month, 1)) }}
                {{ $salary->year }}
            </p>
        </div>

        {{-- ─── USER DETAILS SECTION (still left‐aligned text, but container centered) ─── --}}
        <div class="mb-4">
            <table class="table table-borderless user-details mx-auto" style="max-width: 100%;">
                <tbody>
                    <tr>
                        <td><strong>Employee Name:</strong></td>
                        <td>{{ $user->name }}</td>

                        <td><strong>Employee ID:</strong></td>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Department:</strong></td>
                        <td>{{ $user->department ?? '-' }}</td>

                       {{-- <td><strong>Designation:</strong></td>
                        <td>{{ $user->designation ?? '-' }}</td> --}}
                      <td><strong>Generated On:</strong></td>
                        <td>{{ now()->format('d M, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date of Joining:</strong></td>
                        <td>{{ optional($user->created_at)->format('d M, Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ─── SALARY BREAKDOWN TABLE (centered within payslip-wrapper) ─── --}}
        <div class="mb-4">
            <table class="table table-bordered salary-table mx-auto" style="max-width: 100%;">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%;">#</th>
                        <th>Description</th>
                        <th class="text-end" style="width: 20%;">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Allowances Header --}}
                    <tr class="table-secondary">
                        <td colspan="3"><strong>Allowances</strong></td>
                    </tr>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Basic Salary</td>
                        <td class="text-end">{{ number_format($salary->basic_salary, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Other Allowances</td>
                        <td class="text-end">{{ number_format($salary->other_allowances, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Incentive Pay</td>
                        <td class="text-end">{{ number_format($salary->incentive_pay, 2) }}</td>
                    </tr>
                    <tr class="table-light">
                        <td colspan="2"><strong>Total Allowances</strong></td>
                        <td class="text-end"><strong>{{ number_format($salary->total_allowances, 2) }}</strong></td>
                    </tr>

                    {{-- Deductions Header --}}
                    <tr class="table-secondary">
                        <td colspan="3"><strong>Deductions</strong></td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td>Provident Fund</td>
                        <td class="text-end">{{ number_format($salary->provident_fund, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">5</td>
                        <td>Professional Tax</td>
                        <td class="text-end">{{ number_format($salary->professional_tax, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">6</td>
                        <td>Other Deduction</td>
                        <td class="text-end">{{ number_format($salary->other_deduction, 2) }}</td>
                    </tr>
                    <tr class="table-light">
                        <td colspan="2"><strong>Total Deduction</strong></td>
                        <td class="text-end"><strong>{{ number_format($salary->total_deduction, 2) }}</strong></td>
                    </tr>

                    {{-- Net Salary Row --}}
                    <tr class="table-success">
                        <td colspan="2"><strong>Net Salary (Payable)</strong></td>
                        <td class="text-end"><strong>{{ number_format($salary->net_salary, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
           {{-- <img src="{{ asset('assets/images/NEW-FOOTER.jpeg') }}" alt="Company Footer" class="footer-img"> --}}
           <p><em>This is a software-generated payslip. No signature is required.</em></p>

        </div>
    </div> {{-- /.payslip-wrapper --}}
</body>

</html>
