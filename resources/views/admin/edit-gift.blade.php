@extends('admin/master')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css">
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<style>
    * {
        margin: 0;
        padding: 0
    }
    html {
        height: 100%
    }
    p {
        color: grey
    }
    #heading {
        text-transform: uppercase;
        color: #673AB7;
        font-weight: normal
    }
    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px
    }
    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;
        position: relative
    }
    .form-card {
        text-align: left
    }
    #msform fieldset:not(:first-of-type) {
        display: none
    }
    #msform input,
    #msform textarea {
        padding: 8px 15px 8px 15px;
        border: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        background-color: #ECEFF1;
        font-size: 16px;
        letter-spacing: 1px
    }
    #msform input:focus,
    #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: 1px solid #673AB7;
        outline-width: 0
    }
    #msform .action-button {
        width: 100px;
        background: #673AB7;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 0px 10px 5px;
        float: right
    }
    #msform .action-button:hover,
    #msform .action-button:focus {
        background-color: #311B92
    }
    #msform .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px 10px 0px;
        float: right
    }
    #msform .action-button-previous:hover,
    #msform .action-button-previous:focus {
        background-color: #000000
    }
    .card {
        z-index: 0;
        border: none;
        position: relative
    }
    .fs-title {
        font-size: 25px;
        color: #673AB7;
        margin-bottom: 15px;
        font-weight: normal;
        text-align: left
    }
    .purple-text {
        color: #673AB7;
        font-weight: normal
    }
    .steps {
        font-size: 25px;
        color: gray;
        margin-bottom: 10px;
        font-weight: normal;
        text-align: right
    }
    .fieldlabels {
        color: gray;
        text-align: left
    }
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey
    }
    #progressbar .active {
        color: #673AB7
    }
    #progressbar li {
        list-style-type: none;
        font-size: 15px;
        width: 25%;
        float: left;
        position: relative;
        font-weight: 400
    }
    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f13e"
    }
    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f007"
    }
    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f030"
    }
    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f00c"
    }
    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 20px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px
    }
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1
    }
    #progressbar li.active:before,
    #progressbar li.active:after {
        background: #673AB7
    }
    .progress {
        height: 20px
    }
    .progress-bar {
        background-color: #673AB7
    }
    .fit-image {
        width: 100%;
        object-fit: cover
    }
    .image-uploader .upload-text {
        cursor: pointer;
    }
    .submit-btn {
        float: unset !important;
    }
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
        <h4 class="card-title">Free Gift</h4>
        <p class="card-description"> Edit Info </p>
        <form class="forms-sample" method="POST" action="{{ route('freegifts.update', $freegift['id']) }}">
        @csrf
          <input type="hidden" name="_method" value="PATCH"> 
                <div class="form-group">
                    <label for="giftName">Gift Name</label>
                    <input type="text" class="form-control" name="giftName" id="giftName" value="{{old('giftName', $freegift['giftName'])}}" disabled>
                </div>
                <div class="form-group">
                    <label for="giftDesc">Gift Description</label>
                    <input type="text" class="form-control" name="giftDesc" id="giftDesc" maxlength="255" value="{{old('giftDesc', $freegift['giftDesc'])}}" disabled>
                </div>
                <div class="form-group">
                    <label for="giftRequiredPrice">Gift Required Price (RM)</label>
                    <input type="text" class="form-control" name="giftRequiredPrice" id="giftRequiredPrice" value="{{old('giftRequiredPrice', $freegift['giftRequiredPrice'])}}">
                    @error($errors->has('giftRequiredPrice'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="qty">Gift Quantity</label>
                    <input type="number" class="form-control" name="qty" id="qty" min="0" value="{{old('qty', $freegift['qty'])}}">
                    @error($errors->has('qty'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Gift Image Upload <span class="text-muted">(image will not update if no uploaded)</span></label>
                    <input type="file" class="filepond" name="giftImages" id="giftImages" accept="image/*" multiple data-max-file-size="3MB" data-max-files="1"/>
                    @error($errors->has('giftImages'))
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
          <a href="/admin/freegifts" class="btn btn-light">Cancel</a>
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
// Select the file input and use create() to turn it into a pond
const inputElement = document.querySelector('input[type="file"]');
  const pond = FilePond.create(inputElement, {
    imagePreviewHeight: 200,
    imagePreviewWidth: 200,
    allowImagePreview: true,
    allowMultiple: false
  });
</script>

@endsection