<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Respectism</title>
    <link rel="icon" href="{{asset('user/img/favicon.png')}}">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/vendors/css/vendor.bundle.base.css')}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('user/css/all.css')}}">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    {{-- jquery --}}
    <!-- plugins:js -->
    <script src="{{asset('admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.18/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.18/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>

    <style>
        .table {
        border-spacing: 0 0.85rem !important;
        }

        .table td,
        .table th {
        vertical-align: middle;
        margin-bottom: 10px;
        border: none;
        }

        .table thead tr,
        .table thead th {
        border: none;
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        background: transparent;
        }

        .table td {
        background: #fff;
        }

        .table td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        }

        .table td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        }

        table.dataTable.dtr-inline.collapsed
        > tbody
        > tr[role="row"]
        > td:first-child:before,
        table.dataTable.dtr-inline.collapsed
        > tbody
        > tr[role="row"]
        > th:first-child:before {
        top: 28px;
        left: 14px;
        border: none;
        box-shadow: none;
        }

        table.dataTable.dtr-inline.collapsed > tbody > tr[role="row"] > td:first-child,
        table.dataTable.dtr-inline.collapsed > tbody > tr[role="row"] > th:first-child {
        padding-left: 48px;
        }

        table.dataTable > tbody > tr.child ul.dtr-details {
        width: 100%;
        }

        table.dataTable > tbody > tr.child span.dtr-title {
        min-width: 50%;
        }

        table.dataTable.dtr-inline.collapsed > tbody > tr > td.child,
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.child,
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dataTables_empty {
        padding: 0.75rem 1rem 0.125rem;
        }

        div.dataTables_wrapper div.dataTables_length label,
        div.dataTables_wrapper div.dataTables_filter label {
        margin-bottom: 0;
        }

        .table a:hover,
        .table a:focus {
        text-decoration: none;
        }

        table.dataTable {
        margin-top: 12px !important;
        }

        .buttons-pdf, .buttons-excel{
            color: #333;
            border-color: #ccc;
        }

        .buttons-pdf:hover, .buttons-excel:hover {
        background: #e1e1e1;
        border: 1px solid #d0d0d0;
        }

        .table-hover tbody tr:hover td{
            background-color: #cfe2ff !important;
        }

        .alert p{
            margin-top: 0;
            margin-bottom: 0 !important;
        }

        .btn-edit,
        .btn-delete {
            font-size: 14px;
            padding: 10px 15px;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        {{View::make('admin/header')}}
        <div class="container-fluid page-body-wrapper">
            {{View::make('admin/sidebar')}}
            <div class="main-panel">
                <div class="content-wrapper">
                     @yield('content')
                </div>
                {{View::make('admin/footer')}}
            </div>
        </div>
    </div>
    
    <!-- inject:js -->
    <script src="{{asset('admin/assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('admin/assets/js/misc.js')}}"></script>
    <script src="{{asset('admin/assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <!-- Custom js for this page -->
    <script src="{{asset('admin/assets/js/file-upload.js')}}"></script>

</body>
</html>