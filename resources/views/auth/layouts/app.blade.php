<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Appointment System | @yield('title')</title>

  @include('layouts.css')
  @yield('styles')
</head>
<body class="hold-transition layout-top-nav text-sm">
    <div class="wrapper">

    @include('layouts.nav')
        <div class="content-wrapper">
            <div class="content">
                <div class="container">
                    <br>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('layouts.scripts')
    @yield('scripts')
</div>
</body>
</html>
