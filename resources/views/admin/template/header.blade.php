<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('') }}" class="logo" target="_blank">
        @if(substr_count(Request::url(), 'segundotabelionato') > 0 || substr_count(Request::url(), '2protestoslz') > 0)
            <style>
                .navbar-nav>.user-menu>.dropdown-menu>li.user-header>img{
                    width: auto;
                }
            </style>
            <img src="{{ asset('segundotabelionato/img/logo.png') }}" style="width: 120px; margin-top: 1px" alt="2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos - São Luís" />
        @else
            <img src="{{ asset('admin/img/ieptbma-icon.png') }}" style="width: 170px; margin-top: 2px" alt="Instituto de Estudo de Protestos e Títulos do Brail - Seção Maranhão" />
        @endif
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                {{--  @include('admin.template.notification-menu')  --}}
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-align: center">
                        <!-- The user image in the navbar-->
                        {{-- @if(substr_count(Request::url(), 'segundotabelionato') > 0 || substr_count(Request::url(), '2protestoslz') > 0)
                            <img src="{{ asset('segundotabelionato/img/logo.png') }}" class="user-image" style="border-radius:0;" alt="2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos - São Luís" />
                        @else
                            <img src="{{ asset('admin/img/ieptbma-icon.png') }}" class="user-image" style="border-radius:0;" alt="Instituto de Estudo de Protestos e Títulos do Brail - Seção Maranhão" />
                        @endif --}}
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">
                            {{Auth::user()?Auth::user()->name:''}}
                            <br />
                            CPF: {{Auth::user()?Auth::user()->cpf:''}}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            @if(substr_count(Request::url(), 'segundotabelionato') > 0 || substr_count(Request::url(), '2protestoslz') > 0)
                                <img src="{{ asset('segundotabelionato/img/logo.png') }}" class="img-circle" style="border-radius:0;" alt="2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos - São Luís" />
                            @else
                                <img src="{{ asset('admin/img/ieptbma-icon.png') }}" class="img-circle" style="border-radius:0;" alt="Instituto de Estudo de Protestos e Títulos do Brail - Seção Maranhão" />
                            @endif
                            <p style="font-size: 12px; font-weight: bold">
                                {{Auth::user()?Auth::user()->name:''}}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div style="width: 100%">
                                <a href="{{ url('admin/logout') }}" class="btn btn-primary btn-flat" style="width:100%">SAIR</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
