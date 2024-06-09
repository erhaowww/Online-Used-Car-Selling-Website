@extends('admin/master')
@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Gift Record</h4>
        <p class="card-description"> Add Gift Record </p>
        <form class="forms-sample" method="POST" action="{{ route('giftRecords.store') }}">
          @csrf
          <div class="form-group">
            <label for="paymentId">Payment ID</label>
            <input type="text" name="paymentId" class="form-control" id="paymentId">
            @error($errors->has('paymentId'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="giftId">Gift ID</label>
            <input type="text" name="giftId" class="form-control" id="giftId" placeholder="1,2">
            @error($errors->has('giftId'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
          </div>
          <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
          <button type="button" class="btn btn-light" onclick="history.back()">Cancel</button>
        </form>
      </div>
    </div>
  </div>
  @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
@endsection