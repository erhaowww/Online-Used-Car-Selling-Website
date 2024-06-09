@extends('user/master')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="{{asset('user/image-uploader/image-uploader.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script src="{{asset('user/image-uploader/image-uploader.js')}}"></script>
<div class="container">
    <div class="card" style="margin-top: 10rem">
        <div class="card-header">Total Reviews</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 text-center">
                    <h1 class="text-warning mt-4 mb-4">
                        <b><span id="average_rating">{{$output['average_rating']}}</span> / 5</b>
                    </h1>
                    <div class="mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($output['average_rating'] >= $i)
                                <i class="fas fa-star star-light mr-1 main_star text-warning"></i>
                            @else
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                            @endif
                        @endfor
                    </div>
                    <h3><span id="total_review">{{$output['total_review']}}</span> Review</h3>
                </div>
                <div class="col-sm-4">
                    <p>
                        <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>

                        <div class="progress-label-right">(<span id="total_five_star_review">{{$output['five_star_review']}}</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress" style="width:{{$output['five_star_review']/$output['total_review'] * 100}}%"></div>
                        </div>
                    </p>
                    <p>
                        <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                        
                        <div class="progress-label-right">(<span id="total_four_star_review">{{$output['four_star_review']}}</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress" style="width:{{$output['four_star_review']/$output['total_review'] * 100}}%"></div>
                        </div>               
                    </p>
                    <p>
                        <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                        
                        <div class="progress-label-right">(<span id="total_three_star_review">{{$output['three_star_review']}}</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress" style="width:{{$output['three_star_review']/$output['total_review'] * 100}}%"></div>
                        </div>               
                    </p>
                    <p>
                        <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                        
                        <div class="progress-label-right">(<span id="total_two_star_review">{{$output['two_star_review']}}</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress" style="width:{{$output['two_star_review']/$output['total_review'] * 100}}%"></div>
                        </div>               
                    </p>
                    <p>
                        <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                        
                        <div class="progress-label-right">(<span id="total_one_star_review">{{$output['one_star_review']}}</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress" style="width:{{$output['one_star_review']/$output['total_review'] * 100}}%"></div>
                        </div>               
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4">
            <select class="form-control" id="filter-rating">
                <option value="all" selected>All Ratings</option>
                <option value="5">5 stars</option>
                <option value="4">4 stars</option>
                <option value="3">3 stars</option>
                <option value="2">2 stars</option>
                <option value="1">1 star</option>
            </select>
        </div>
    </div>
    <div class="mt-5" id="review_content">
        @if (count($output['review_data']) > 0)
            @for ($i = 0; $i < count($output['review_data']); $i++)
                <div class="row mb-3 review-item {{$output['review_data'][$i]['rating']}}-review">
                    <div class="col-sm-1">
                        <img src="{{asset('user/img/profile/'.$output['review_data'][$i]['user_image'])}}" class="rounded-circle pt-2 pb-2">
                    </div>
                    <div class="col-sm-11">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <b>{{$output['review_data'][$i]['user_name']}}</b>
                                </div>
                                <div>
                                    <small class="text-muted">{{$output['review_data'][$i]['reviewTime']}}</small>
                                </div>
                            </div>
                            <div class="card-body">
                                @for ($star = 1; $star <= 5; $star++)
                                    @if ($output['review_data'][$i]['rating'] >= $star)
                                        <i class="fas fa-star text-warning mr-1"></i>
                                    @else
                                        <i class="fas fa-star star-light mr-1"></i>
                                    @endif                                    
                                @endfor
                                <br />
                                {{$output['review_data'][$i]['user_review']}}
                                {{-- images --}}
                                @if ($output['review_data'][$i]['review_image'] != NULL)
                                    @php
                                        $images = explode('|', $output['review_data'][$i]['review_image']);
                                    @endphp
                                    <br><br>
                                    <div class="row mb-3">
                                        @foreach ($images as $image)
                                            <div class="">
                                                <a href="{{asset('user/img/review/'.$image)}}" class="image-link">
                                                <img src="{{asset('user/img/review/'.$image)}}" class="mr-3 mb-3 img-fluid img-equal">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                {{-- end images --}}
                                @if ($output['review_data'][$i]['comment'] != NULL)
                                    <hr>
                                    {{-- comment --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-1">
                                            <img src="{{asset('user/img/profile/263-2635979_admin-abuse.png')}}" class="rounded-circle pt-2 pb-2">
                                        </div>
                                        <div class="col-sm-11">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <b>Admin</b>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted">{{$output['review_data'][$i]['commentTime']}}</small>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    {{$output['review_data'][$i]['comment']}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end comment --}}
                                @endif
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                @if (Session::has('user'))
                                    <div class="like-buttons">
                                        <a href="" class="like-button @if($output['review_data'][$i]['liked'] == 'YES')clicked @endif" id="{{$output['review_data'][$i]['review_id']}}">
                                            <i class="@if($output['review_data'][$i]['liked'] == 'YES')fas @else far @endif fa-thumbs-up"></i> Like
                                        </a>
                                    </div>
                                @endif
                                <div>
                                    <small class="text-muted">{{$output['review_data'][$i]['num_likes']}} likes</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
    </div>
</div>
</body>
</html>

<style>
.img-equal {
width: 150px;
height: 150px;
object-fit: cover;
}
/* style the like buttons */
.like-buttons a {
    display: inline-block;
    margin-right: 5px;
    font-size: 16px;
    color: #666;
    text-decoration: none;
    transition: color 0.2s ease-in-out;
}
.like-buttons a:hover {
    color: #333;
}
.like-buttons a.clicked {
    color: #f00;
}

/* style the likes count text */
.card-footer small {
    color: #666;
    font-size: 14px;
}
.progress-label-left
{
float: left;
margin-right: 0.5em;
line-height: 1em;
}
.progress-label-right
{
float: right;
margin-left: 0.3em;
line-height: 1em;
}
.star-light
{
color:#e9ecef;
}

.image-uploader .upload-text{
  cursor: pointer;
}

select:focus {
  outline: none !important;
  box-shadow: none !important;
}
</style>

<script>
    $(document).ready(function() {
        $("#filter-rating").change(function() {
            var selectedValue = $(this).val();
            if(selectedValue == "all"){
                $(".review-item").show();
            } else {
                $(".review-item").hide();
                $("." + selectedValue + "-review").show();
            }
        });
    });
</script>

<script>
$(document).ready(function() {
    $('.image-link').magnificPopup({
    type: 'image'
    });
});
</script>

<script>
// select the like button and likes count elements
const likeButtons = document.querySelectorAll('.like-button');

// add a click event listener to each like button
likeButtons.forEach(likeButton => {
  likeButton.addEventListener('click', function(event) {
    event.preventDefault();
    const likeButtonId = $(this).attr('id');
    // send an AJAX request to the server to update the likes count
    fetch('/user/reviews/'+likeButtonId+'/like')
        .then(response => response.json())
        .then(data => {
            // get the parent container of the like button
            const parentContainer = this.parentElement.parentElement;

            // get the likes count element using querySelector
            const likesCount = parentContainer.querySelector('.text-muted');

            // update the text content of the likes count element
            likesCount.textContent = data.num_likes +' likes';

            // toggle the "liked" class of the like button
            this.classList.toggle('clicked');

            // Get the <i> element inside the like button element
            const iconElement = this.querySelector('i');

            // Toggle the "far" and "fas" classes of the <i> element
            iconElement.classList.toggle('far');
            iconElement.classList.toggle('fas');
        });
  });
});
</script>
    
@endsection