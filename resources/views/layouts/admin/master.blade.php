<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles
</head>


<body id="page-top">

    <div id="wrapper">

        @include('layouts.admin.menu')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                @include('layouts.admin.header')

                <div class="container-fluid">

                    @yield('content')

                </div>

            </div>
            <br>
            @include('layouts.admin.footer')

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('layouts.admin.reload')
    @include('layouts.admin.modals')
    @include('acl::_msg')


    @livewireScripts
    @include('sweetalert::alert')
    <script src="{{ asset('js/app.js') }}" defer></script>

    @stack('scripts')

</body>

</html>