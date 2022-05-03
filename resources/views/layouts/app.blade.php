<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
   @include('layouts.navbar')
    <!-- /.navbar -->

    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts.header')


    @yield('content')

    <!-- Main content -->

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>

 @include('layouts.footer')


