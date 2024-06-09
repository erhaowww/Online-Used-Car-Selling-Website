@extends('admin/master')
@section('content')
<link rel="stylesheet" href="{{asset('user/image-uploader/image-uploader.css')}}">
<script src="{{asset('user/image-uploader/image-uploader.js')}}"></script>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create New Payments</h4>
            <p class="card-description"> This is only for creating new payment only ! </p>

            <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="order_id">Order ID</label>
                    <input type="text" class="form-control" name="order_id" id="order_id" placeholder="123" maxlength="255">
                    @error($errors->has('order_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="total_charge">Total Charge (RM)</label>
                    <input type="text" class="form-control" name="total_charge" id="total_charge" placeholder="">
                    @error($errors->has('total_charge'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="date">Payment Date</label>
                    <input type="date" class="form-control" name="date" id="date">
                    @error($errors->has('date'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="method">Payment Method</label>
                    <select class="form-control" id="method" name="method" required="" style="padding: 15px 24px;">
                        <option>Choose...</option>
                        <option value="credit card" style="padding: 5px">Credit Card</option>
                        <option value="debit card" style="padding: 5px">Debit Card</option>
                    </select>
                    @error($errors->has('method'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="4" placeholder="No 123, Jalan Besar" maxlength="255"></textarea>
                    @error($errors->has('address'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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
                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                <a href="/admin/payments" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>

@endsection