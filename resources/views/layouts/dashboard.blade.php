<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-warning vh-100">
    <main class="container-fluid py-2" style="min-height: 100vh">
        <div class="left-side position-fixed bg-light rounded-4 p-3">
            <a class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" width="60">
                <span class="text-uppercase fs-2 fw-bold text-black">GGC</span>
            </a>
            <hr class="border border-black border-2 opacity-75">
            <ul class="menu list-unstyled d-flex flex-column gap-3">
                <li class="menu-item parent-menu">
                    <a href="javascript:void(0)" class="d-flex text-black fs-4 justify-content-between align-items-center p-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-receipt"></i>
                            <span>Invoices</span>
                        </div>
                        <i class="fa-solid fa-angle-up"></i>
                    </a>
                    <ul class="list-unstyled sub-menu">
                        <li class="sub-menu-item ps-4 mb-2">
                            <a href="" class="text-secondary-emphasis">
                                <div class="text">Add Invoice</div>
                            </a>
                        </li>
                        <li class="sub-menu-item ps-4">
                            <a href="" class="text-secondary-emphasis">
                                <div class="text">Invoices</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item parent-menu">
                    <a href="javascript:void(0)" class="d-flex text-black fs-4 justify-content-between align-items-center p-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-users-line"></i>
                            <span>Customer</span>
                        </div>
                        <i class="fa-solid fa-angle-up"></i>
                    </a>
                    <ul class="list-unstyled sub-menu">
                        <li class="sub-menu-item ps-4 mb-2">
                            <a href="" class="text-secondary-emphasis">
                                <div class="text">Add Customer</div>
                            </a>
                        </li>
                        <li class="sub-menu-item ps-4">
                            <a href="" class="text-secondary-emphasis">
                                <div class="text">Customers</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="" class="d-flex text-black fs-4 justify-content-between align-items-center p-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-users"></i>
                            <span>User</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="d-flex text-black fs-4 justify-content-between align-items-center p-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-gears"></i>
                            <span>Setting</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="right-side position-sticky w-75">
            <div class="bg-light rounded-4 p-3 text-end d-flex justify-content-end align-items-center gap-3 mb-3">
                <i class="fa-solid fa-bell fs-3"></i>
                <div class="dropdown">
                    <div class="image d-flex flex-column align-items-center g-1" data-bs-toggle="dropdown"
                        style="cursor: pointer">
                        <img class="object-fit-cover  rounded-circle" style="width: 25px; height: 25px;"
                            src="{{ asset('assets/images/OIP (1).webp') }}" alt="">
                        <span class="fw-bold">Ahmed</span>
                    </div>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">logout</a></li>
                    </ul>
                </div>
            </div>
            @yield('content')
        </div>
    </main>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
