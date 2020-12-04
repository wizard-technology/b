<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">

        @include('layouts.sidebar')

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                @include('layouts.nav')
                <div class="page-content-wrapper">

                    <div class="container-fluid">

                        @yield('content')



                    </div><!-- container -->

                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->

            <footer class="footer">
                {{config('app.name')}} © {{date('Y')}}
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->
    @include('layouts.script')
    @if ($errors->has('admin'))
    <script>
        swal(
                'Error',
                '{{$errors->first("admin")}}',
                'error'
            );
    </script>
    @endif
</body>

</html>