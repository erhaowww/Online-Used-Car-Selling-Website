@if ($message = Session::get('success'))
    <script>
        swal({
            title: "Success!",
            text: "{{ $message }}",
            icon: "success",
            button: "OK",
        });
    </script>
@endif


@if ($message = Session::get('error'))
    <script>
            swal({
                title: "Sorry!",
                text: "{{ $message }}",
                icon: "error",
                button: "OK",
            });
    </script>
@endif


@if ($message = Session::get('warning'))
    <script>
        swal({
            title: "Sorry!",
            text: "{{ $message }}",
            icon: "warning",
            button: "OK",
        });
    </script>
@endif


@if ($message = Session::get('info'))
    <script>
        swal({
            title: "Sorry!",
            text: "{{ $message }}",
            icon: "info",
            button: "OK",
        });
    </script>
@endif
