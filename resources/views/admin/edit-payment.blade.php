@extends('admin/master')
@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Payment</h4>
        <p class="card-description"> Edit Info </p>
        <form class="forms-sample" method="POST" action="{{ route('payments.update', $payment->id) }}" >
          @csrf
          <input type="hidden" name="_method" value="PATCH"> 
          <div class="form-group">
            <label for="order_id">Order ID</label>
            <input type="text" name="order_id" class="form-control" id="order_id" placeholder="123" value="{{old('order_id', $payment->order_id)}}" maxlength="255">
            <input type="hidden" name="old_order_id" value="{{ $payment->order_id }}">
            @error($errors->has('order_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
          </div>
          <div class="form-group">
                    <label for="total_charge">Total Charge (RM)</label>
                    <input type="text" class="form-control" name="total_charge" id="total_charge" placeholder="" value="{{old('total_charge', $payment->total_charge)}}">
                    @error($errors->has('total_charge'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="date">Payment Date</label>
                    <input type="date" class="form-control" name="date" id="date" value="{{old('payment_date', $payment->payment_date)}}">
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
                        <option value="credit card" {{ old('payment_method', $payment->payment_method) == 'credit card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="debit card" {{ old('payment_method', $payment->payment_method) == 'credit card' ? '' : 'selected' }}>Debit Card</option>
                    </select>
                    @error($errors->has('method'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="4" maxlength="255">{{ old('billing_address', $payment->billing_address) }}</textarea>
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