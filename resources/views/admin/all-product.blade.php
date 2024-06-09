@extends('admin/master')
@section('content')
<!-- Link Swiper's CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<style>
.swiper {
    width: 180px;
    height: 40%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    /* background: #fff; */
    display: flex;
    justify-content: center;
    align-items: center;
}

.swiper-slide img {
    display: block;
    width: 100px !important;
    height: 100px !important;
    object-fit: cover;
    border-radius: unset !important;
}

.swiper {
    margin-left: auto;
    margin-right: auto;
}

</style>

<h2>Product Page</h2><br>

@if(\Session::has('success'))
<div class="alert alert-success">
    <p>{{ \Session::get('success') }}</p>
</div><br>
@endif

<div class="container-fluid">
    <div class="table-responsive">
        <table id="example" class="table table-hover" style="width:100%">
            <thead>
                {{-- <tr>
                    <th>
                        <a href="{{route('products.create')}}" class="btn btn-primary" title="Add">Add<i class="mdi mdi-plus-circle-outline"></i></a>
                    </th>
                </tr> --}}
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Mileage</th>
                    <th>Color</th>
                    <th>Transmission</th>
                    <th>Description</th>
                    <th>Images</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->make }}</td>
                    <td>{{ $product->model }}</td>
                    <td>{{ $product->year }}</td>
                    <td>{{ $product->mileage }}</td>
                    <td>{{ $product->color }}</td>
                    <td>{{ $product->transmission }}</td>
                    <td>{{ $product->product_description }}</td>
                    <td>
                        @if($product->product_image != NULL)
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                @foreach (explode('|', $product->product_image) as $image)
                                    <div class="swiper-slide">
                                        <a href="{{asset('user/img/product/'.$image)}}" class="image-link">
                                            <img src="{{asset('user/img/product/'.$image)}}" class="img-fluid">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                        @else
                            <p style="text-align: center">No Image</p>   
                        @endif
                    </td>
                    <td>{{ $product->price }}</td>
                
                        <td> 
                        {{-- <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-edit" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a> --}}
                        <a href="/user/destroyProduct/{{$product->id}}" class="btn btn-danger delete_button btn-delete" title="Delete"><i class="mdi mdi-delete-outline"></i></a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "lengthMenu": [5, 10, 20, 50],
            "dom": 'ZBfrltip',
            "buttons": [
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 8 ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 8 ]
                    }
                },
            ],
            "drawCallback": function() {
                $('.image-link').magnificPopup({
                    type: 'image'
                });
            }
        });
    });
</script>

<script>
    $(".delete_button").click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        swal({
            title: "Confirmation",
            text: "Are you sure to delete this record?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = url;
            }
        });
    });
</script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>

@endsection