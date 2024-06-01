<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Clothing Platform</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('frontend') }}/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{ asset('frontend') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <style>
        /* Navigation Bar */
        .navbar {
            padding: 0.5rem 1rem;
        }

        .navbar-brand img {
            height: 85px;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #fff;
        }

        .navbar-nav .nav-item.active .nav-link {
            color: #fff;
        }

        .navbar-nav .nav-link i {
            font-size: 1.2rem;
        }

        .navbar-nav .nav-link .badge {
            font-size: 0.8rem;
            padding: 0.2rem 0.4rem;
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
        }

        .announcement-bar {
            background-color: #000;
            color: #fff;
            padding: 10px;
            width: 100%;
        }

        .announcement-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .announcement-content p {
            margin: 0;
            font-size: 14px;
            flex-grow: 1;
            text-align: center;
        }

        .announcement-content strong {
            font-weight: bold;
        }

        .close-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-left: 10px;
        }
    </style>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend') }}/css/style.css" rel="stylesheet">

    @yield('css')

</head>

<body>

    @include('frontend.partials.headder')

    @yield('content')
    @include('frontend.partials.footer')



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/lib/easing/easing.min.js"></script>
    <script src="{{ asset('frontend') }}/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('frontend') }}/mail/jqBootstrapValidation.min.js"></script>
    {{-- <script src="{{ asset('frontend') }}/mail/contact.js"></script> --}}

    <!-- Template Javascript -->
    <script src="{{ asset('frontend') }}/js/main.js"></script>
    @yield('js')
    <script>
        const closeBtn = document.querySelector('.close-btn');
        const announcementBar = document.querySelector('.announcement-bar');

        closeBtn.addEventListener('click', () => {
            announcementBar.style.display = 'none';
        });
    </script>

    @if (session('message'))
        <script>
            setTimeout(function() {
                alert("{{ session('message') }}");
            }, 500);
        </script>
    @endif
</body>

</html>
