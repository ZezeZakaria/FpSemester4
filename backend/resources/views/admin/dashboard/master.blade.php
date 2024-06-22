<!DOCTYPE html>
<html lang="en">

@include('admin.dashboard.head')

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    @include('admin.dashboard.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        @include('admin.dashboard.header')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        @yield('main-content')
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      @include('admin.dashboard.footer')

</body>

</html>
