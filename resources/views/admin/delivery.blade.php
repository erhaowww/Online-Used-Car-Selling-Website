@extends('admin/master')
@section('content')

<h2>Delivery Page</h2><br>
@if(\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div><br>
@endif

{!!$html!!}

    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "lengthMenu": [5, 10, 20, 50],
                "dom": 'ZBfrltip',
                "buttons": [
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2 ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2 ]
                        }
                    },
                ],
            });
        });
    </script>

@endsection