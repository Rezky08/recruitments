<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bulma.min.css') }}">
    <title>@yield('title')</title>
</head>

<body>
    @if (Session::has('success'))
        <div class="notification is-success position-absolute">
            <button class="delete"></button>
            <p>
                {{Session::get('success')}}
            </p>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="notification is-danger position-absolute">
            <button class="delete"></button>
            <p>
                {{Session::get('error')}}
            </p>
        </div>
    @endif
    @stack('main')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                var $notification = $delete.parentNode;

                $delete.addEventListener('click', () => {
                $notification.parentNode.removeChild($notification);
                });
            });
            });
    </script>
</body>

</html>
