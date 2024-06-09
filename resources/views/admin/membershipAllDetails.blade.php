@extends('admin/master')
@section('content')
<style>
    .membership-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 14px;
    text-transform: uppercase;
    }

    .gold {
    background-color: #ffc107;
    color: #fff;
    }

    .silver {
    background-color: #c4c4c4;
    color: #fff;
    }

    .bronze {
    background-color: #cd7f32;
    color: #fff;
    }

    .platinum {
    background-color: #e5e4e2;
    color: #0c0c0c;
    border: 2px solid #c0c0c0;
    }
</style>


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
                            columns: [ 0, 1, 2, 3, 4 ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        }
                    },
                ],
            });
        });
    </script>
@endsection