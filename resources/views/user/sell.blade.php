@extends('user/master')
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

    .g-recaptcha div{
        width: auto !important;
    }
</style>
<!--================Home Banner Area =================-->
<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item">
                        <h2>Sell Used car</h2>
                        <p>Home <span>-</span> Sell Used car</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb start-->

<!-- ================ contact section start ================= -->
<section class="contact-section padding_top">
    <div class="container">
      <div class="d-none d-sm-block mb-5 pb-4">
        <div class="container-fluid">
          <div class="row justify-content-center">
              <div class="col-11 col-sm-10 col-md-10 col-lg-10 col-xl-9 text-center p-0 mt-3 mb-2">
                  <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                      <h2 id="heading">Sign Up Your Used Car</h2>
                      <p>Fill all form field to go to next step</p>
                      <form id="msform" enctype="multipart/form-data" method="post" action="{{url('products')}}">
                        @csrf
                          <!-- progressbar -->
                          <ul id="progressbar">
                              <li class="active" id="account"><strong>Car</strong></li>
                              <li id="personal"><strong>Details</strong></li>
                              <li id="payment"><strong>Image</strong></li>
                              <li style="display: none"></li>
                              <li id="confirm"><strong>Finish</strong></li>
                          </ul>
                          <div class="progress">
                              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                          </div> <br> <!-- fieldsets -->
                          <fieldset>
                              <div class="form-card">
                                  <div class="row">
                                      <div class="col-7">
                                          <h2 class="fs-title">Car:</h2>
                                      </div>
                                      <div class="col-5">
                                          <h2 class="steps">Step 1 - 4</h2>
                                      </div>
                                  </div> 
                                  <label class="fieldlabels">Make: * @if ($errors->has('make'))
                                      <span class="text-danger">{{ $errors->first('make') }}</span>
                                  @endif</label> 
                                  <input type="text" name="make" placeholder="Mercedes-Benz" value="{{old('make')}}"/> 
                                  
                                  <label class="fieldlabels">Model: * @if ($errors->has('model'))
                                      <span class="text-danger">{{ $errors->first('model') }}</span>
                                  @endif</label> 
                                  <input type="text" name="model" placeholder="Mercedes-AMG G 63" value="{{old('model')}}"/>
                                  
                                  <label class="fieldlabels">Price: * @if ($errors->has('price'))
                                      <span class="text-danger">{{ $errors->first('price') }}</span>
                                  @endif</label> 
                                  <input type="text" name="price" placeholder="RM500,000" value="{{old('price')}}"/>
                                  
                              </div> <input type="button" name="next" class="next action-button" value="Next" />
                          </fieldset>
                          <fieldset>
                              <div class="form-card">
                                  <div class="row">
                                      <div class="col-7">
                                          <h2 class="fs-title">Car Information:</h2>
                                      </div>
                                      <div class="col-5">
                                          <h2 class="steps">Step 2 - 4</h2>
                                      </div>
                                  </div> 
                                  <label class="fieldlabels">Year: * @if ($errors->has('year'))
                                      <span class="text-danger">{{ $errors->first('year') }}</span>
                                  @endif</label> 
                                  <input type="text" name="year" placeholder="2021" value="{{old('year')}}"/> 
                                  
                                  <label class="fieldlabels">Mileage: * @if ($errors->has('mileage'))
                                      <span class="text-danger">{{ $errors->first('mileage') }}</span>
                                  @endif</label> 
                                  <input type="text" name="mileage" placeholder="10km" value="{{old('mileage')}}"/>
                                  
                                  <label class="fieldlabels">Color: * @if ($errors->has('color'))
                                      <span class="text-danger">{{ $errors->first('color') }}</span>
                                  @endif</label> 
                                  <input type="text" name="color" placeholder="black and pink" value="{{old('color')}}"/> 
                          
                                  <label class="fieldlabels">Transmission: * @if ($errors->has('transmission'))
                                      <span class="text-danger">{{ $errors->first('transmission') }}</span>
                                  @endif</label> 
                                  <input type="text" name="transmission" placeholder="Manual" value="{{old('transmission')}}"/>
                                 
                                  <label class="fieldlabels">Product Description: * @if ($errors->has('pDesc'))
                                      <span class="text-danger">{{ $errors->first('pDesc') }}</span>
                                  @endif</label>
                                  <textarea name="pDesc" id="pDesc" cols="30" rows="10">{{old('pDesc')}}</textarea>
                                  
                              </div> <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                          </fieldset>
                          <fieldset>
                              <div class="form-card">
                                  <div class="row">
                                      <div class="col-7">
                                          <h2 class="fs-title">Image Upload:</h2>
                                      </div>
                                      <div class="col-5">
                                          <h2 class="steps">Step 3 - 4</h2>
                                      </div>
                                  </div> 
                                    <label class="fieldlabels">Upload Your Photo: * @if ($errors->has('filepond'))
                                      <span class="text-danger">{{ $errors->first('filepond') }}</span>
                                    @endif</label> 
                                    <input type="file" class="filepond" name="filepond[]" multiple data-max-file-size="3MB" data-max-files="9" />
                              </div> <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                          </fieldset>
                          <fieldset>
                              <div class="form-card">
                                  <div class="row">
                                      <div class="col-7">
                                          <h2 class="fs-title">Finish:</h2>
                                      </div>
                                      <div class="col-5">
                                          <h2 class="steps">Step 4 - 4</h2>
                                      </div>
                                  </div> <br><br>
                                  <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>
                                  <div class="row justify-content-center">
                                      <div class="col-3"> <img src="{{asset('user/img/tick.png')}}" class="fit-image"> </div>
                                  </div> <br><br>
                                  <div class="row justify-content-center">
                                      <div class="col-7 text-center">
                                          <h5 class="purple-text text-center">You Have Successfully Filled Up The Form</h5>
                                          {!! NoCaptcha::display() !!}
                                          @if ($errors->has('g-recaptcha-response'))
                                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span><br>
                                          @endif
                                          <input type="submit" name="submit" class="action-button submit-btn" value="Submit" />
                                      </div>
                                  </div>
                              </div>
                          </fieldset>
                      </form>
                      @if (count($errors) > 0)
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      </div>



    </div>
</section>
<!-- ================ contact section end ================= -->
{!! NoCaptcha::renderJs() !!}
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
    allowMultiple: true
  });
</script>

<script>
    $(document).ready(function() {

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length - 1;

        setProgressBar(current);

        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(++current);
        });

        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(--current);
        });

        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
        }

        $(".submit").click(function() {
            return false;
        })

    });
</script>

@endsection