<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ url('public/admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('public/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('public/admin/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   <link rel="stylesheet" href="{{ url('public/admin/plugins/select2/css/select2.min.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ url('public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ url('public/admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ url('public/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ url('public/admin/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ url('public/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ url('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
  <link rel="stylesheet" href="{{ url('public/admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">

 <link rel="stylesheet" href="{{ url('public/admin/css/style.css')}}">

 <link rel="stylesheet" href="{{ url('public/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ url('public/admin/plugins/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="{{ url('public/css/notify.css')}}">

</head>

<!--<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">-->
 
<body class="hold-transition sidebar-mini layout-fixed">                  

    
      @include('admin.layouts.header')
      @include('admin.layouts.left-sidebar')
    
      @yield('content')
      @include('notify::messages')
       <x:notify-messages />
      @include('admin.layouts.footer')

    </body>
</html>