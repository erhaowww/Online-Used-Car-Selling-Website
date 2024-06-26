@extends('admin/master')
@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Customer</h4>
        <p class="card-description"> Add Customer </p>
        <form class="forms-sample" method="POST" action="{{route('customers.store')}}">
          @csrf
          <div class="form-group">
            <label for="exampleInputName1">Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Name" value="{{old('name')}}">
            @if ($errors->has('name'))
                <span class="text-danger" style="font-size: 14px">{{ $errors->first('name') }}</span>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail3">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail3" placeholder="Email" value="{{old('email')}}">
            @if ($errors->has('email'))
                <span class="text-danger" style="font-size: 14px">{{ $errors->first('email') }}</span>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputPassword4">Password</label>
            <div class="input-group">
              <input type="password" name="password" class="form-control" id="exampleInputPassword4" placeholder="Password" value="{{old('password')}}">
              <span class="field-icon input-group-text"><i class="fa fa-fw fa-eye toggle-password" toggle="#exampleInputPassword4"></i></span>
            </div>       
            @if ($errors->has('password'))
              <span class="text-danger" style="font-size: 14px">{{ $errors->first('password') }}</span>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleSelectGender">Gender</label>
            <select class="form-control" name="gender" id="exampleSelectGender">
              <option value="">Choose a gender</option>
              <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            @if ($errors->has('gender'))
              <span class="text-danger" style="font-size: 14px">{{ $errors->first('gender') }}</span>
            @endif
          </div>
          <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
          <a href="{{route('customers.index')}}" class="btn btn-light">Cancel</a>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
@endsection