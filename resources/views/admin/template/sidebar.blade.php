<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel" >
            {{-- <div class="pull-left image">
                @if(substr_count(Request::url(), 'segundotabelionato') > 0 || substr_count(Request::url(), '2protestoslz') > 0)
                    <img src="{{ asset('segundotabelionato/img/logo.png') }}" class="img-circle" style="border-radius:0;" alt="2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos - São Luís" />
                @else
                    <img src="{{ asset('admin/img/ieptbma-icon.png') }}" class="img-circle" style="border-radius:0;" alt="Instituto de Estudo de Protestos e Títulos do Brail - Seção Maranhão" />
                @endif
            </div> --}}
            <div class="pull-left info" style="height: 60px;">
                <p style="font-size: 11px">{{Auth::user()?Auth::user()->name:''}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
<!--         <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Pesquisar..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <!-- Optionally, you can add icons to the links -->
                @for( $i=0; $i<$menu->count();$i++)
                    @if( $menu[$i]->pai )
                        @if( $i==0 || !$menu[$i-1]->pai || $menu[$i-1]->pai!=$menu[$i]->pai )
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-{{$menu[$i]->icon}}"></i>
                            <span>{{$menu[$i]->pai}}</span>
                        </a>
                        <ul class="treeview-menu">
                        @endif
                            <li class="{{Request::segment(2)==str_replace('admin/','',$menu[$i]->caminho)?'active':''}}">
                              <a href="{{url($menu[$i]->caminho)}}"><i class="fa fa-circle-o"></i> {{$menu[$i]->nome}}</a>
                            </li>
                        @if(($i+1)<$menu->count() && (!$menu[$i+1]->pai || $menu[$i+1]->pai!=$menu[$i]->pai ))
                        </ul>
                    </li>
                        @endif
                    @else
                    <li class="treeview {{Request::segment(2)==str_replace('admin/','',$menu[$i]->caminho)?'active':''}}">
                        <a href="{{url($menu[$i]->caminho)}}">
                            <i class="fa fa-{{$menu[$i]->icon}}"></i> 
                            <span>{{$menu[$i]->nome}}</span>
                        </a>
                    </li>
                    @endif
                @endfor
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
