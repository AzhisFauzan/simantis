<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="500">
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">

    <title>@yield("judul")</title>

   @include("layout.header")
</head>
<style>
    .container-fluid{
        background-color: white;
    }
    #footer{
        margin-top: 10px
    }

    body.sidebar-toggled .topbar {
        left: 65px !important;
        width: calc(100% - 65px) !important;
    }

    body:not(.sidebar-toggled) .topbar {
        left: 224px !important;
        width: calc(100% - 224px) !important;
    }

    body.sidebar-toggled:not(.sidebar-hovering) .topbar {
        left: 65px !important;
        width: calc(100% - 65px) !important;
    }

    body:not(.sidebar-toggled):not(.sidebar-hovering) .topbar {
        left: 224px !important;
        width: calc(100% - 224px) !important;
    }

    /* Temporary hover state */
    body.sidebar-hovering .topbar {
        transition: left 0.3s ease, width 0.3s ease !important;
    }

    .topbar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 999 !important;
        transition: none !important;
        min-height: 40px;
        padding: 0 1rem;
    }

</style>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layout.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layout.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield("page_title")</h1>
                    </div>
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white" id="footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy;Magang UNIPMA 2026</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        setTimeout(function() {
            $('body').addClass('layout-loaded');
        }, 100);
    });

    var hoverTimeout;
    $(".sidebar").on("mouseenter", function () {
        clearTimeout(hoverTimeout);
        $('body').addClass('sidebar-hovering');

        if (!sidebarPinned) {
            $("body").removeClass("sidebar-toggled");
            $(".sidebar").removeClass("toggled");
            saveSidebarState(false);
        }
    });

    $(".sidebar").on("mouseleave", function () {
        if (!sidebarPinned) {
            hoverTimeout = setTimeout(function() {
                $('body').removeClass('sidebar-hovering');
                $("body").addClass("sidebar-toggled");
                $(".sidebar").addClass("toggled");
                saveSidebarState(true);
                $('.sidebar .collapse').collapse('hide');
            }, 200);
        } else {
            $('body').removeClass('sidebar-hovering');
        }
    });
    </script>
    @include("layout.footer")
</body>

</html>
