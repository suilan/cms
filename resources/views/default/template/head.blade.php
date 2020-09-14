<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="robots" content="index, follow">
    <meta name="author" content="ielop">

    @section('metas')
        <title>IEPTB-MA</title>
        <meta name="description" content="Instituto de Protesto - Seção Maranhão" />
        <meta name="keywords" content="cartorio,protesto,maranhao,titulo,"/>
        <!-- facebook open graph -->
        <meta property="og:title" content="IEPTB-MA">
        <meta property="og:image" content="{{ asset('/site/images/logo-social.jpg') }}">
        <meta property="og:description" content="Instituto de Protesto - Seção Maranhão">
        <!-- twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@ieptbma">
        <meta name="twitter:creator" content="@ielop">
        <meta name="twitter:title" content="IEPTB-MA">
        <meta name="twitter:description" content="Instituto de Protesto - Seção Maranhão">
        <meta name="twitter:image" content="{{ asset('/site/images/logo-social.jpg') }}">
    @show
    <link rel="stylesheet" href="{{ asset('/site/css/k2.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/site/css/sjhexagon-mod_sj_contact_ajax.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/site/css/modules-mod_sj_contact_ajax.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/site/css/font-awesome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/site/css/materialize.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/site/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/site/css/sj-reslisting-me.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/asset/bootstrap/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/cpanel.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/template-blue.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/pattern.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/custom.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/asset/fonts/awesome/css/font-awesome.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/responsive.css') }}" type="text/css" />
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato" type="text/css" />

    <link rel="stylesheet" href="{{ asset('/site/css/gallery.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/jquery.fancybox-1.3.4.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/module_default.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/isotope.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/sj-slickslider.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/slickslider-font-color.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/site/css/shortcodes.css') }}" type="text/css" />

    <style type="text/css">
      .container{
        width:1200px
      }
      body{
        font-family:Lato;}
      #menu a{
        font-family:Lato;
      }
      h1,h2,h3{
        font-family:Lato;
      }
    </style>
    <style>
      .skypebutton img {
          margin: 10px 0 !important;
          padding: 0 !important;
          vertical-align: 0 !important;
      }
      .skypebutton a, .skypebutton a:link, .skypebutton a:visited, .skypebutton a:hover {
          display: block !important;
      }
      ul#dropdown_SkypeButton_Dropdown_Guilherme_1 {
          width: 100px !important;
      }
      ul#dropdown_SkypeButton_Dropdown_Guilherme_1 >li {
          line-height: 25px;;
      }
    </style>
    <style type="text/css">
      #map-canvas {
        height:300px;
        width:autopx;
        max-width:100%;
      };

     .container{width:1200px}
      body{font-family:Lato;font-weight:}
      #menu a{font-family:Lato;font-weight:}
      h1,h2,h3{font-family:Lato;font-weight:}

      #map-canvas {
        height:300px;
        width:500px;
        max-width:100%;
      };
    </style>

    <link id="consulta-gratuita-css" rel="stylesheet" href="{{ asset('/site/css/consulta-publica.css') }}" type="text/css" />
    @yield('styles')
    <script src="{{ asset('/site/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/bower_components/admin-lte/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
    <script src="{{ asset('/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('/site/js/jquery-noconflict.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/jquery-migrate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/k2.js?v2.6.8&amp;sitepath=/ieptbma/') }}" type="text/javascript"></script>
    <!-- <script src="{{ asset('/site/asset/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('/site/js/ytcpanel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/jquery.miniColors.min.js') }}" type="text/javascript"></script>
    <!-- <script src="{{ asset('/bower_components/admin-lte/bootstrap/js/laravel.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('/site/js/scrollReveal.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/jquery.print.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/yt-script.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/jquery.megamenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/jsmart.easing.1.3.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/jquery.fancybox-1.3.4.pack.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/jcarousel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/acymailing_module.js?v=550') }}" type="text/javascript" async="async"></script>
    <script src="{{ asset('/site/js/jquery.isotope.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/jquery.prettyPhoto.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/jquery.cj-swipe.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/prettify.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/site/js/shortcodes.js') }}" type="text/javascript"></script>
    <!-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script> 
    -->

    <meta name="HandheldFriendly" content="true"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="YES" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <!-- META FOR IOS & HANDHELD -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>

    <!-- LINK FOR FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon_2.png') }}" />
</head>
