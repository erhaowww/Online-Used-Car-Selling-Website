@extends('admin/master')
@section('content')
<h2>Free Gift Page</h2><br>

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
                    <!-- <a href="{{ route('freegifts.create') }}" class="btn btn-primary" title="Add">Add<i class="mdi mdi-plus-circle-outline"></i></a> -->
                    </th>
                </tr>
                <tr>
                    <th>Gift Name</th>
                    <th>Gift Description</th>
                    <th>Required Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($freeGifts['freeGifts'] as $freeGift)
                <tr>
                <td>{{ $freeGift['giftName'] }}</td>
                <td>{{ $freeGift['giftDesc'] }}</td>
                <td>{{ $freeGift['giftRequiredPrice'] }}</td>
                <td>{{ $freeGift['qty'] }}</td>
                <td><img src="{{ asset('user/img/gift/' . $freeGift['image']) }}"></td>
                <td>
                    <a href="{{ route('freegifts.edit', $freeGift['id']) }}" class="btn btn-success btn-edit" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                    <!-- <a href="/deleteGift/{{ $freeGift['id'] }}" class="btn btn-danger delete_button btn-delete" title="Delete"><i class="mdi mdi-delete-outline"></i></a> -->
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