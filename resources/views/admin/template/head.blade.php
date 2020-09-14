<head>
    <meta charset="UTF-8">
    <title>{{ $page_title or "IEPTB MA" }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- <link href="{{ asset('admin/dist/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" /> -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- <link href="{{ asset('admin/dist/css/ionicons.min.css')}}" rel="stylesheet" type="text/css" /> -->
    <!-- Theme style -->
    <link href="{{ asset('admin/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datepicker/datepicker3.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/iCheck/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/iCheck/flat/blue.css')}}" rel="stylesheet" type="text/css" />     
    <link href="{{ asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    @if (substr_count(Request::url(), 'ieptbma') > 0)
        <link href="{{ asset('admin/dist/css/skins/skin-blue.min.css')}}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('admin/dist/css/skins/skin-yellow.min.css')}}" rel="stylesheet" type="text/css" />
    @endif
        <!-- LINK FOR FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/img/favicon.png') }}" />
    <style type="text/css">.box{box-shadow:none;margin-bottom: 0;}</style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style>
        html, body {
            min-height: 100%;
            padding: 0;
            margin: 0;
            font-family: 'Source Sans Pro', "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        iframe {
            display: block;
            overflow: auto;
            border: 0;
            margin: 0;
            padding: 0;
            margin: 0 auto;
        }
        .frame {
            height: 49px;
            margin: 0;
            padding: 0;
            border-bottom: 1px solid #ddd;
        }
        .frame a {
            color: #666;
        }
        .frame a:hover {
            color: #222;
        }
        .frame .buttons a {
            height: 49px;
            line-height: 49px;
            display: inline-block;
            text-align: center;
            width: 50px;
            border-left: 1px solid #ddd;
        }
        .frame .brand {
            color: #444;
            font-size: 20px;
            line-height: 49px;
            display: inline-block;
            padding-left: 10px;
        }
        .frame .brand small {
            font-size: 14px;
        }
        a,a:hover {
            text-decoration: none;
        }
        .container-fluid {
            padding: 0;
            margin: 0;
        }
        .text-muted {
            color: #999;
        }
        .ad {
            text-align: center;
            position: fixed;
            bottom: 0;
            left: 0;
            background: #222;
            background: rgba(0,0,0,0.8);
            width: 100%;
            color: #fff;
            display: none;
        }
        #close-ad {
            float: left;
            margin-left: 10px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
    @yield('styles')
</head>
