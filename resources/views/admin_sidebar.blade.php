<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("person.jpg") }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>
                @if (Auth::guest())
                @else
                    {{ Auth::user()->name }} 
                @endif
                </p>
                <!-- Status -->
                <a href="{{ route('person.edit', Auth::user()->id) }}"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) 
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Procurar..."/>
                <span class="input-group-btn">
                  <button type='submit' name='search' id='search-btn' class="btn btn-flat">
                  <i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
         /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ route('dashboard') }}"><span>Dashboard</span></a></li>
            <li><a href="{{ route('entry.index') }}"><span>Entries</span></a></li>
            <li><a href="{{ route('category.index') }}"><span>Categories</span></a></li>
            <li><a href="{{ route('time.index') }}"><span>Times</span></a></li>
            <li class="header">REPORTS</li>
            <li><a href="{{ route('reports.detalhe') }}"><span>Exercício</span></a></li>
            <li class="header">CONFIGURATIONS</li>
            <li><a href="{{ route('param.show', 1) }}"><span>Params</span></a></li>
            <li><a href="{{ route('users.index') }}"><span>Users</span></a></li>
            <li><a href="{{ route('entry.support') }}"><span>Support</span></a></li>
            <li><a href="{{ route('dump.index', 1) }}"><span>Backups</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>