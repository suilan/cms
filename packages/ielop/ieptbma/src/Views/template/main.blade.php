@include('ieptbma::template._head')
<body class="interna 
    @if(Request::segment(1) === 'jornaldoprotestoma') 
        downloads
    @elseif(Request::segment(1) === 'protonline') 
        contato
    @else
        {{Request::segment(1)}}
    @endif
    ">
    @include('ieptbma::template._header')
    <div class="banner">
    </div>
    <div class="content">
        <div class="container">
            <div class="main">
                @yield('content')
            </div>
            @include('ieptbma::template._aside')
        </div>
    </div>
    @include('ieptbma::template._footer')
    @include('ieptbma::template._scripts')

    @yield('scripts')
</body>
</html>
