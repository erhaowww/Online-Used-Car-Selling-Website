@extends('admin/master')
@section('content')

<h2>Gift Record Page</h2><br>

@if(\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div><br>
@endif

<div class="container-fluid">
    <div class="table-responsive">
        <table id="example" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>
                    <!-- <a href="{{ route('giftRecords.create') }}" class="btn btn-primary" title="Add">Add<i class="mdi mdi-plus-circle-outline"></i></a> -->
                    </th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Payment ID</th>
                    <th>Gift Id</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($giftRecords['giftRecords'] as $giftRecord)
                <tr>
                    <td>{{ $giftRecord['id'] }}</td>
                    <td>{{ $giftRecord['paymentId'] }}</td>
                    <td>{{ $giftRecord['giftId'] }}</td>
                    <td>
                        <a href="{{ route('giftRecords.edit', $giftRecord['id']) }}" class="btn btn-success btn-edit" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                        <a href="/admin/deleteGiftRecords/{{ $giftRecord['id'] }}" class="btn btn-danger delete_button btn-delete" title="Delete"><i class="mdi mdi-delete-outline"></i></a>
                    </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>
<script>
        $(".delete_button").click(function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            swal({
                title: "Confirmation",
                text: "Are you sure to delete this record?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    window.location.href = url;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

<style>
    .table-responsive{
        overflow-x: auto;
        width: 100%;
    }
</style>

@endsection