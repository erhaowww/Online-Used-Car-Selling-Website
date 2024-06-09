@extends('admin/master')
@section('content')
<link rel="stylesheet" href="{{asset('user/image-uploader/image-uploader.css')}}">
<script src="{{asset('user/image-uploader/image-uploader.js')}}"></script>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create New Products</h4>
            <p class="card-description"> This is only for creating new products only ! </p>

            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="exampleInputName1">Make</label>
                    <input type="text" class="form-control" name="make" id="make" placeholder="Tesla Model 3 Year 2023">
                    @error('make')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Model</label>
                    <input type="text" class="form-control" name="model" id="model" placeholder="Tesla Model 3">
                    @error('model')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Year</label>
                    <input type="date" class="form-control" name="year" id="year" placeholder="05-11-2002">
                    @error('year')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword4">Mileage</label>
                    <input type="text" class="form-control" name="mileage" id="mileage" placeholder="50K">
                    @error('mileage')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword4">Color</label>
                    <input type="text" class="form-control" name="color" id="color" placeholder="Pearl White">
                    @error('color')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="Transmission">Transmission</label>
                    <input type="text" class="form-control" name="transmission" id="transmission" placeholder="HONDA VTEC">
                    @error('transmission')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pDesc">Product Description</label>
                    <textarea class="form-control" name="pDesc" id="pDesc" rows="4"></textarea>
                    @error('pDesc')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>



                <div class="form-group">
                    <label>Product Image Upload</label>
                    <input type="file" name="images" class="file-upload-default">
                    <div class="input-images-1">
                        
                        @error('images')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" id="price" rows="4" placeholder="RM250,000"></textarea>
                    @error('price')
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
                <button class="btn btn-light">Cancel</button>
            </form>
        </div>
    </div>
</div>


<script>
    $(function() {
        $('.input-images-1').imageUploader();
    });
</script>
@endsection