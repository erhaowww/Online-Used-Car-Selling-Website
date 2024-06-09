@extends('user/master')
@section('content')

<style>
    /* Circle-shaped checkbox styles */
.custom-checkbox .custom-control-input:checked~.custom-control-label::before {
  border-color: #ff3368;
  background-color: #ff3368;
}

.custom-checkbox .custom-control-label::before {
  border-radius: 50%;
}

.custom-checkbox .custom-control-label::after {
  border-radius: 50%;
}

.custom-control-input:focus ~ .custom-control-label::before {
    box-shadow: none;
}

tr.sold {
    position: relative;
}

tr.sold td:not(:last-child) {
  opacity: 0.5;
}

tr.sold td::before {
    content: "SOLD"; /* add the "SOLD" text */
    font-size: 72px;
    color: #ff3368;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: bold;
}

tr.deleted {
    position: relative;
}

tr.deleted td:not(:last-child) {
  opacity: 0.5;
}

tr.deleted td::before {
    content: "DELETED"; /* add the "SOLD" text */
    font-size: 72px;
    color: #ff3368;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: bold;
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
                        <h2>Cart Products</h2>
                        <p>Home <span>-</span>Cart Products</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb start-->

<!--================Cart Area =================-->
<section class="cart_area padding_top">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select-all-checkbox" id="select-all">
                                    <label class="custom-control-label" for="select-all"></label>
                                </div>
                            </th>
                            <th scope="col">Vehicle</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Details</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="{{ $order->status === 'sold' ? 'sold' : ($order->deleted === 1 ? 'deleted' : '') }}">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select-checkbox" id="select-{{ $order->id }}" value="{{ $order->orderId }}" {{ $order->status === 'sold' ? 'disabled' : ($order->deleted === 1 ? 'disabled' : '') }}>
                                    <label class="custom-control-label" for="select-{{ $order->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <div class="media">
                                    <div class="d-flex">
                                        @php
                                        $images = explode('|', $order->product_image);
                                        @endphp
                                        <img src="{{ asset('user/img/product/'.$images[0]) }}" width="500" height="250" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>{{ $order->make }} &nbsp;{{ $order->model }}</h5>
                            </td>
                            <td>
                                <h5 class="product-price">RM {{ $order->price }}</h5>
                            </td>
                            <td>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Details</h5>
                                        <p class="card-text">Mileage: {{ $order->mileage }}</p>
                                        <p class="card-text">Year: {{ $order->year }}</p>
                                        <p class="card-text">Color: {{ $order->color }}</p>
                                        <p class="card-text">Transmission: {{ $order->transmission }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="" title="Delete" class="btn btn-sm btn-danger delete-btn" data-order-id="{{ $order->id }}"><i class="fas fa-trash" style="color:#fff"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td>
                                <h5 id="subtotal">RM 0</h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="checkout_btn_inner float-right">
                    <a href="" class="btn_1 checkout_btn_1" id="submit-button">Proceed to Checkout</a>
                </div>
            </div>
        </div>
</section>
<!--================End Cart Area ============-->

<script>
    // get the submit button by ID
    const submitButton = document.querySelector('#submit-button');
    var selectedOrderIds = [];

    // Add event listener to select all checkbox
    var selectAllCheckbox = document.querySelector('#select-all');
    selectAllCheckbox.addEventListener('change', function(event) {
        // If select all checkbox is checked, add all order IDs to selectedOrderIds array
        if (event.target.checked) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#select-all):not(:disabled)');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
                selectedOrderIds.push(checkboxes[i].value);
            }
        } else { // If select all checkbox is unchecked, remove all order IDs from selectedOrderIds array
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#select-all):not(:disabled)');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
            selectedOrderIds = [];
        }
        let selectedOrderIdsString = selectedOrderIds.join(',');
        // Encode the selectedOrderIdsString using base64
        let encodedSelectedOrderIds = btoa(selectedOrderIdsString);
        // update the href attribute of the submit button tag
        submitButton.href = "{{ route('payment.display', ['selectedOrderIds' => ':selectedOrderIds']) }}".replace(':selectedOrderIds', encodedSelectedOrderIds);
    });

    // Add event listener to all other checkboxes
    var checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#select-all):not(:disabled)');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function(event) {
            // If checkbox is checked, add order ID to selectedOrderIds array
            if (event.target.checked) {
                selectedOrderIds.push(event.target.value);
            } else { // If checkbox is unchecked, remove order ID from selectedOrderIds array
                var index = selectedOrderIds.indexOf(event.target.value);
                if (index !== -1) {
                    selectedOrderIds.splice(index, 1);
                }
            }
            let selectedOrderIdsString = selectedOrderIds.join(',');
            // Encode the selectedOrderIdsString using base64
            let encodedSelectedOrderIds = btoa(selectedOrderIdsString);
            // update the href attribute of the submit button tag
            submitButton.href = "{{ route('payment.display', ['selectedOrderIds' => ':selectedOrderIds']) }}".replace(':selectedOrderIds', encodedSelectedOrderIds);
        });
    }


    // add event listener to the submit button
    submitButton.addEventListener('click', (event) => {
        // check if any checkbox is checked
        if (!Array.from(checkboxes).some((checkbox) => checkbox.checked)) {
            // if no checkbox is checked, show the SweetAlert error message
            swal("Error!", "Please select at least one order to proceed to checkout.", "error");
            event.preventDefault();
            return false; // prevent form submission
        }
    });
</script>

<script>
    const deleteBtns = document.querySelectorAll('.delete-btn');

    // loop through all delete buttons and add a click event listener to each
    deleteBtns.forEach(function(deleteBtn) {
        // add a click event listener to each delete button
        deleteBtn.addEventListener('click', function(event) {
            event.preventDefault();
            swal({
                title: "Confirmation",
                text: "Are you sure to delete this record?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    const productId = $(this).data('order-id');
                    // send an AJAX request to the server to update the likes count
                    fetch('/user/deleteCart/'+productId)
                        .then(response => response.json())
                        .then(data => {
                            if(data.message === 'success'){
                                swal({
                                    title: "Item deleted in Cart!",
                                    text: "Your item has been successfully deleted in your cart.",
                                    icon: "success",
                                    timer: 2000, // Display duration in milliseconds
                                    buttons: false,
                                    closeOnClickOutside: false,
                                    closeOnEsc: false,
                                    animation: {
                                        showClass: "animate__animated animate__fadeIn",
                                        hideClass: "animate__animated animate__fadeOut"
                                    }
                                });

                                // Fade out the corresponding row and remove it from the table
                                $('#select-' + productId).closest('tr').fadeOut('slow', function() {
                                    $(this).remove();

                                    // Recalculate the subtotal after deleting the order
                                    var subtotal = 0;
                                    $('.select-checkbox:checked').each(function() {
                                        var price = parseFloat($(this).closest('tr').find('.product-price').text().replace(/[^0-9.-]+/g,""));
                                        subtotal += price;
                                    });
                                    $('#subtotal').text("RM " + subtotal.toFixed(2));
                                });
                            } else {
                                swal({
                                    title: "Delete Cart Failed",
                                    text: "This item is cannot be deleted. Something went wrong!",
                                    icon: "error",
                                    timer: 2000, // Display duration in milliseconds
                                    buttons: false,
                                    closeOnClickOutside: false,
                                    closeOnEsc: false,
                                    animation: {
                                        showClass: "animate__animated animate__fadeIn",
                                        hideClass: "animate__animated animate__fadeOut"
                                    }
                                });
                            }
                        });
                }
            });
            
        });
    });
</script>

<script>
    // Get the "select all" checkbox element
    const selectAllCheckbox = document.getElementById('select-all');

    // Get all the individual checkboxes in the table
    const selectCheckboxes = document.getElementsByClassName('select-checkbox');

    // Add a change event listener to the "select all" checkbox
    selectAllCheckbox.addEventListener('change', () => {
    // Loop through all the individual checkboxes and set their checked property to match the "select all" checkbox
    for (let i = 0; i < selectCheckboxes.length; i++) {
        selectCheckboxes[i].checked = selectAllCheckbox.checked;
    }
    });
</script>

<script>
    $(document).ready(function() {
        // select all checkbox
        $('#select-all').click(function() {
            $('.select-checkbox').not(':disabled').prop('checked', this.checked);
            setTimeout(function() {
                $('.select-checkbox:disabled').prop('checked', false);
            }, 1);
            calculateSubtotal();
        });

        // individual checkbox
        $('.select-checkbox').change(function() {
            if ($('.select-checkbox:not(:disabled):checked').length == $('.select-checkbox:not(:disabled)').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }
            calculateSubtotal();
        });

        function calculateSubtotal() {
            var subtotal = 0;
            $('.select-checkbox:not(:disabled):checked').each(function() {
                var price = parseFloat($(this).closest('tr').find('.product-price').text().replace(/[^0-9.-]+/g,""));
                subtotal += price;
            });
            $('#subtotal').text("RM " + subtotal.toFixed(2));
        }
    });
</script>

@endsection