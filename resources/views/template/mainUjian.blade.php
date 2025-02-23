<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> Talenta Muda | {{ $title }}</title>
    <link rel="icon" type="image/x-icon" href="{{ url('/assets/img') }}/cbt-malela.png" />
    <link href="{{ url('/assets/cbt-malela') }}/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="{{ url('/assets/cbt-malela') }}/assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{ url('/assets/cbt-malela') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/cbt-malela') }}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    {{-- PLUGIN --}}
    <link href="{{ url('/assets/cbt-malela') }}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/cbt-malela') }}/assets/css/components/custom-sweetalert.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('/assets/cbt-malela') }}/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <script src="{{ url('/assets/cbt-malela') }}/assets/js/libs/jquery-3.1.1.min.js"></script>
    {!! $plugin !!}
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ url('/assets/cbt-malela') }}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="{{ url('/assets/cbt-malela') }}/plugins/sweetalerts/custom-sweetalert.js"></script>
    <script src="{{ url('/assets/cbt-malela') }}/bootstrap/js/popper.min.js"></script>
    <script src="{{ url('/assets/cbt-malela') }}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ url('/assets/cbt-malela') }}/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ url('/assets/cbt-malela') }}/assets/js/app.js"></script>
    <script src="{{ url('/assets/cbt-malela') }}/plugins/font-icons/feather/feather.min.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{ url('/assets/cbt-malela') }}/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{ url('/assets/cbt-malela') }}/assets/js/scrollspyNav.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <style>
        .btn {
            padding-left: 0.6rem;
            padding-right: 0.6rem;
        }
    </style>

</head>

<body class="sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    <!--  BEGIN NAVBAR  -->
    
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="container-fluid" >

       

        <!-- Content -->
        @yield('content');
        
    </div>
    <!-- END MAIN CONTAINER -->
    @yield('script');
    <script>
        $(".logout").on("click",function(t){t.preventDefault();var n=$(this).attr("href");swal({title:"yakin logout?",text:"anda harus login ulang untuk masuk ke aplikasi!",type:"warning",showCancelButton:!0,cancelButtonText:"tidak",confirmButtonText:"ya, logout",padding:"2em"}).then(function(t){t.value&&(document.location.href=n)}),$("#swal2-container").css("z-index","9999")}),feather.replace();
    </script>
</body>


</html>
