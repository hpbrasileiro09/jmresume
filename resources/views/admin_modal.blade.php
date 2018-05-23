<!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Hpbtec</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-green.min.css")}}" rel="stylesheet" type="text/css" />

        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}">

        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }}">

        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css") }}">

        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/iCheck/flat/blue.css") }}">

        <link rel="stylesheet" href="{{ asset ("/css/bootstrap-select.min.css") }}"></link>

        <!-- fullCalendar 2.2.5-->
        <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.min.css") }}">
        <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.print.css") }}" media="print">

        <link rel="stylesheet" href="{{ asset ("/css/hpbtec.css") }}">

        <link rel="shortcut icon" type="image/ico" href="favicon.ico">

        <!-- jQuery 2.1.3 -->
        <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>

        <style>
        .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        }

        #pac-input:focus {
        border-color: #4d90fe;
        }

        .pac-container {
        font-family: Roboto;
        }

        #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
        }

        #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
        }
        #target {
        width: 345px;
        }   
        </style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-green">

    <!-- Your Page Content Here -->
    @yield('content')

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>

    <!-- DataTables -->
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>

    <!-- bootstrap datepicker -->
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}" type="text/javascript"></script>

    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>

    <script src="{{ asset ("/js/bootstrap-select.min.js") }}" type="text/javascript"></script>

    <!-- Sindiprol ADUEL -->
    <script src="{{ asset ("/js/hpbtec.js") }}" type="text/javascript"></script>

    <!-- iCheck -->
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/iCheck/icheck.min.js") }}" type="text/javascript"></script>

    <!-- Slimscroll -->
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
    <!-- FastClick -->
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/fastclick/fastclick.js") }}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.js") }}"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience -->
    </body>
</html>