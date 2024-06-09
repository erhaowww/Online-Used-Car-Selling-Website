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

<h2>Membership Page</h2><br>
@if(\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div><br>
@endif

<table id="example" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>Membership Level</th>
            <th>Button</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($memberships['memberships'] as $membership)
        <tr>
            <td><span class="membership-badge {{$membership['level']}}">{{$membership['level']}}</span></td>
            <td><a href="{{route('membershipDetails', $membership['level'])}}" class="btn btn-primary" title="View {{$membership['level']}}" style="font-size: 14px;padding: 10px 15px;"><i class="mdi mdi-eye-outline"></i></a></td>
        </tr>
        @endforeach
        @if($memberships['memberships'])
        <tr>
            <td style="font-weight: bold">View All Levels</td>
            <td><a href="{{route('membershipAllDetails')}}" class="btn btn-primary" title="View All Levels" style="font-size: 14px;padding: 10px 15px;"><i class="mdi mdi-eye-outline"></i></a></td>
        </tr>
        @endif
    </tbody>
</table>

    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "lengthMenu": [5, 10, 20, 50],
            });
        });
    </script>

@endsection