@extends('admin/master')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css">
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<style> 
.filepond--credits{
        display: none;
    }
        /**
        * FilePond Custom Styles
        */
    .filepond--drop-label {
        color: #4c4e53;
    }
    
    .filepond--label-action {
        text-decoration-color: #babdc0;
    }
    
    .filepond--panel-root {
        border-radius: 2em;
        background-color: #edf0f4;
        height: 1em;
    }
    
    .filepond--item-panel {
        background-color: #595e68;
    }
    
    .filepond--drip-blob {
        background-color: #7f8a9a;
    }
    
    .filepond--item {
        width: calc(50% - 0.5em);
    }
    
    @media (min-width: 30em) {
        .filepond--item {
            width: calc(50% - 0.5em);
        }
    }
    
    @media (min-width: 50em) {
        .filepond--item {
            width: calc(33.33% - 0.5em);
        }
    }

    .filepond--root {
        max-height: 100em;
    }

    .filepond--root .filepond--drop-label {
        cursor: pointer;
    }

    .filepond--drop-label.filepond--drop-label label {
        cursor: pointer;
    }
</style>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Products</h4>
            <p class="card-description"> This is only for editing products only ! </p>

            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PATCH"> 
                <input type="hidden" name="previousRouteName" value="{{$lastSegment}}">

                <div class="form-group">
                    <label for="exampleInputName1">Make</label>
                    <input type="text" class="form-control" name="make" id="make" value="{{$product->make}}" placeholder="Tesla Model 3 Year 2023">
                    @error('make')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Model</label>
                    <input type="text" class="form-control" name="model" value="{{$product->model}}" id="model" placeholder="Tesla Model 3">
                    @error('model')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Year</label>
                    <input type="text" class="form-control" name="year" value="{{$product->year}}" id="year" placeholder="05-11-2002">
                    @error('year')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Mileage</label>
                    <input type="text" class="form-control" name="mileage" value="{{$product->mileage}}" id="mileage" placeholder="50K">
                    @error('mileage')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Color</label>
                    <input type="text" class="form-control" name="color" value="{{$product->color}}" id="color" placeholder="Pearl White">
                    @error('color')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="Transmission">Transmission</label>
                    <input type="text" class="form-control" name="transmission" value="{{$product->transmission}}" id="transmission" placeholder="HONDA VTEC">
                    @error('transmission')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="pDesc">Product Description</label>
                    <textarea class="form-control" name="pDesc" id="pDesc" rows="4">{{$product->product_description}}</textarea>
                    @error('pDesc')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Product Image Upload</label>
                    <input type="file" class="filepond form-control" name="filepond[]" multiple data-max-file-size="3MB" data-max-files="9" />
                    @error('images')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" value="{{$product->price}}" id="price" rows="4" placeholder="RM250,000"></textarea>
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
                <button class="btn btn-light" onclick="history.back()">Cancel</button>
            </form>
        </div>
    </div>
</div>


<script>
    /*
We want to preview images, so we need to register the Image Preview plugin
*/
FilePond.registerPlugin(
	
	// encodes the file as base64 data
    FilePondPluginFileEncode,
	
	// validates the size of the file
	FilePondPluginFileValidateSize,
	
	// corrects mobile image orientation
	FilePondPluginImageExifOrientation,
	
	// previews dropped images
    FilePondPluginImagePreview
  
);

var imageUrls;
var images;
if ("{{$product->product_image}}" != ""){
    imageUrls = [];
    images = "{{$product->product_image}}".split('|');
    for (var i = 0; i < images.length; i++) {
        var imageUrl = {
            source: "{{asset('user/img/product')}}" + '/' + images[i]
        };
        imageUrls.push(imageUrl);
    }

}

// Select the file input and use create() to turn it into a pond
const inputElement = document.querySelector('input[type="file"]');
  const pond = FilePond.create(inputElement, {
    imagePreviewHeight: 200,
    imagePreviewWidth: 200,
    allowImagePreview: true,
    allowMultiple: true,
    files: imageUrls
  });
</script>
@endsection