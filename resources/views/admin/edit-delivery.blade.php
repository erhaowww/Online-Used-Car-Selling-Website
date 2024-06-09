@extends('admin/master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  .input-group-text{
    border: none !important;
  }
</style>

@if(\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div><br>
@endif

@if(\Session::has('failed'))
    <div class="alert alert-success">
        <p>{{ \Session::get('failed') }}</p>
    </div><br>
@endif

<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Delivery</h4>
        <p class="card-description"> Edit Delivery Status </p>
        <form class="forms-sample" method="POST" action="{{route('delivery.update', $id)}}" >
           @csrf
        {!!$html!!}
        </form>
      </div>
    </div>
  </div>

  
@endsection