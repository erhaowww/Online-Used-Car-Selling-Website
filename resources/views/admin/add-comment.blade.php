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
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

.wrapper {
  margin: 0 auto;
  max-width: 960px;
  width: 100%;
}

.master {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: start;
  -ms-flex-pack: start;
  justify-content: flex-start;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
}

h1 {
  font-size: 20px;
  margin-bottom: 20px;
}

h2 {
  line-height: 160%;
  margin-bottom: 20px;
  text-align: center;
}

.rating-component {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  margin-bottom: 10px;
}

.rating-component .status-msg {
  margin-bottom: 10px;
  text-align: center;
}

.rating-component .status-msg strong {
  display: block;
  font-weight: bold;
  margin-bottom: 10px;
}

.rating-component .stars-box {
  -ms-flex-item-align: center;
  align-self: center;
  margin-bottom: 15px;
}

.rating-component .stars-box .star {
  color: #ccc;
  cursor: pointer;
}

.rating-component .stars-box .star.hover {
  color: #ff5a49;
}

.rating-component .stars-box .star.selected {
  color: #ff5a49;
}

.feedback-tags {
  min-height: 119px;
  width: 100%;
}

.feedback-tags .tags-container {
  display: none;
}

.feedback-tags .tags-container .question-tag {
  text-align: center;
  margin-bottom: 40px;
}

.feedback-tags .tags-box {
  display: -webkit-box;
  display: -ms-flexbox;
  text-align: center;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  -ms-flex-direction: row;
  flex-direction: row;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
}

.feedback-tags .tags-container .make-compliment {
  padding-bottom: 20px;
}

.feedback-tags .tags-container .make-compliment .compliment-container {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  color: #000;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
}

.feedback-tags
  .tags-container
  .make-compliment
  .compliment-container
  .fa-smile-wink {
  color: #ff5a49;
  cursor: pointer;
  font-size: 40px;
  margin-top: 15px;
  -webkit-animation-name: compliment;
  animation-name: compliment;
  -webkit-animation-duration: 2s;
  animation-duration: 2s;
  -webkit-animation-iteration-count: 1;
  animation-iteration-count: 1;
}

.feedback-tags
  .tags-container
  .make-compliment
  .compliment-container
  .list-of-compliment {
  display: none;
  margin-top: 15px;
}

.image-uploader{
    border: 1px solid #ff5a49;
    background: #fff;
    cursor: pointer;
}

.modal-header, .modal-body{
    background: #fff;
}

.feedback-tags .tag {
  border-radius: 5px;
  color: #4c4e53;
  cursor: pointer;
  margin-bottom: 10px;
  padding: 10px;
  background-color: #f0f0f5;
}

.feedback-tags .tag::placeholder {
  color: #4c4e53;
}

.feedback-tags .tag.choosed {
  background-color: #ff5a49;
  color: #fff;
}

.list-of-compliment ul {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  -ms-flex-direction: row;
  flex-direction: row;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
}

.list-of-compliment ul li {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  cursor: pointer;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  margin-bottom: 10px;
  margin-left: 20px;
  min-width: 90px;
}

.list-of-compliment ul li:first-child {
  margin-left: 0;
}

.list-of-compliment ul li .icon-compliment {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  border: 2px solid #ff5a49;
  border-radius: 50%;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  height: 70px;
  margin-bottom: 15px;
  overflow: hidden;
  padding: 0 10px;
  -webkit-transition: 0.5s;
  transition: 0.5s;
  width: 70px;
}

.list-of-compliment ul li .icon-compliment i {
  color: #ff5a49;
  font-size: 30px;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.list-of-compliment ul li.actived .icon-compliment {
  background-color: #ff5a49;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.list-of-compliment ul li.actived .icon-compliment i {
  color: #fff;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.button-box .done {
  background-color: #ff5a49;
  border: 1px solid #ff5a49;
  border-radius: 3px;
  color: #fff;
  cursor: pointer;
  display: none;
  min-width: 100px;
  padding: 10px;
}

.button-box .done:disabled,
.button-box .done[disabled] {
  border: 1px solid #ff9b95;
  background-color: #ff9b95;
  color: #fff;
  cursor: initial;
}

.submited-box {
  display: none;
  padding: 20px;
}

.submited-box .loader,
.submited-box .success-message {
  display: none;
}

.submited-box .loader {
  border: 5px solid transparent;
  border-top: 5px solid #4dc7b7;
  border-bottom: 5px solid #ff5a49;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 0.8s linear infinite;
  animation: spin 0.8s linear infinite;
}

@-webkit-keyframes compliment {
  1% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  25% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  50% {
    -webkit-transform: rotate(30deg);
    transform: rotate(30deg);
  }

  75% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  100% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
}

@keyframes compliment {
  1% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  25% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  50% {
    -webkit-transform: rotate(30deg);
    transform: rotate(30deg);
  }

  75% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  100% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
}

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
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
<button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>

<div id="review_modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Submit Review</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('comments.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                <div class="wrapper">
                    <div class="master">
                      <h1>Review And rating</h1>
                      <h2>How was your experience about our product?</h2>
                  
                      <div class="rating-component">
                        <div class="status-msg">
                          <label>
                            <input  class="rating_msg" type="hidden" name="rating_msg" value=""/>
                          </label>
                        </div>
                        <div class="stars-box">
                          <i class="star fa fa-star" title="1 star" data-message="Poor" data-value="1"></i>
                          <i class="star fa fa-star" title="2 stars" data-message="Too bad" data-value="2"></i>
                          <i class="star fa fa-star" title="3 stars" data-message="Average quality" data-value="3"></i>
                          <i class="star fa fa-star" title="4 stars" data-message="Nice" data-value="4"></i>
                          <i class="star fa fa-star" title="5 stars" data-message="very good qality" data-value="5"></i>
                        </div>
                        <div class="starrate">
                          <label>
                            <input class="ratevalue" type="hidden" name="rate_value" value=""/>
                          </label>
                        </div>
                      </div>
                  
                      <div class="feedback-tags">
                        <div class="tags-container" data-tag-set="1">
                          <div class="question-tag">
                            Why was your experience so bad?
                          </div>
                        </div>
                        <div class="tags-container" data-tag-set="2">
                          <div class="question-tag">
                            Why was your experience so bad?
                          </div>
                  
                        </div>
                  
                        <div class="tags-container" data-tag-set="3">
                          <div class="question-tag">
                            Why was your average rating experience ?
                          </div>
                        </div>
                        <div class="tags-container" data-tag-set="4">
                          <div class="question-tag">
                            Why was your experience good?
                          </div>
                        </div>
                  
                        <div class="tags-container" data-tag-set="5">
                          <div class="make-compliment">
                            <div class="compliment-container">
                              Give a compliment
                              <i class="far fa-smile-wink"></i>
                            </div>
                          </div>
                        </div>
                        
                        <div class="tags-box">
                          <input type="text" class="tag form-control" name="review" id="inlineFormInputName" placeholder="Please enter your review">
                          <input type="hidden" name="product_id" value="" />
                        </div>

                        <input type="file" class="filepond" name="filepond[]" multiple data-max-file-size="3MB" data-max-files="9" />
                        
                      </div>
                  
                      <div class="button-box">
                        <button type="submit" class="done btn btn-warning" disabled="disabled">Add review</button>
                      </div>
                  
                      <div class="submited-box">
                        <div class="loader"></div>
                        <div class="success-message">
                          Thank you!
                        </div>
                      </div>
                    </div>
                </div>
                </form>
            </div>
      </div>
    </div>
</div>
    <script>
        $('#add_review').click(function(){
            $('#review_modal').modal('show');
        });
    </script>

    <script>
        $(".rating-component .star").on("mouseover", function () {
        var onStar = parseInt($(this).data("value"), 10); //
        $(this).parent().children("i.star").each(function (e) {
            if (e < onStar) {
            $(this).addClass("hover");
            } else {
            $(this).removeClass("hover");
            }
        });
        }).on("mouseout", function () {
        $(this).parent().children("i.star").each(function (e) {
            $(this).removeClass("hover");
        });
        });

        $(".rating-component .stars-box .star").on("click", function () {
        var onStar = parseInt($(this).data("value"), 10);
        var stars = $(this).parent().children("i.star");
        var ratingMessage = $(this).data("message");

        var msg = "";
        if (onStar > 1) {
            msg = onStar;
        } else {
            msg = onStar;
        }
        $('.rating-component .starrate .ratevalue').val(msg);
        

        
        $(".fa-smile-wink").show();
        
        $(".button-box .done").show();

        if (onStar === 5) {
            $(".button-box .done").removeAttr("disabled");
        } else {
            $(".button-box .done").attr("disabled", "true");
        }

        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass("selected");
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass("selected");
        }

        $(".status-msg .rating_msg").val(ratingMessage);
        $(".status-msg").html(ratingMessage);
        $("[data-tag-set]").hide();
        $("[data-tag-set=" + onStar + "]").show();
        });

        $(".feedback-tags  ").on("click", function () {
        var choosedTagsLength = $(this).parent("div.tags-box").find("input").length;
        choosedTagsLength = choosedTagsLength + 1;

        if ($(this).hasClass("choosed")) {
            $(this).removeClass("choosed");
            choosedTagsLength = choosedTagsLength - 2;
        } else {
            $(this).addClass("choosed");
            $(".button-box .done").removeAttr("disabled");
        }

        // console.log(choosedTagsLength);

        if (choosedTagsLength <= 0) {
            $(".button-box .done").attr("enabled", "false");
        }
        });



        $(".compliment-container .fa-smile-wink").on("click", function () {
        $(this).fadeOut("slow", function () {
            $(".list-of-compliment").fadeIn();
        });
        });



        $(".done").on("click", function (e) {
            e.preventDefault();
            $(".rating-component").hide();
            $(".feedback-tags").hide();
            $(".button-box").hide();
            $(".submited-box").show();
            $(".submited-box .loader").show();

            setTimeout(function () {
                $(".submited-box .loader").hide();
                $(".submited-box .success-message").show();
            }, 1500);

            $('form').submit();
        });

    </script>

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
@endsection