<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="logo"><b>Hpb</b> Tecnologia</a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <?php if (isset($messages)) { ?>
                    <?php if (count($messages)) { ?>
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">{{ count($messages) }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Você tem {{ count($messages) }} mensagens</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    @foreach($messages as $message)
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src="{{ asset("person.jpg") }}" class="img-circle" alt="Admin"/>
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                {{$message['title']}}
                                            </h4>
                                            <!-- The message -->
                                            <p>{{$message['content']}}</p>
                                        </a>
                                    </li><!-- end message -->
                                    @endforeach
                                </ul><!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">Veja todas as mensagens</a></li>
                        </ul>
                    </li><!-- /.messages-menu -->
                    <?php } ?>
                <?php } ?>

                <?php if (isset($_notifications)) { ?>
                    <?php if (count($_notifications)) { ?>
                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">{{ count($_notifications) }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Você tem {{ count($_notifications) }} notificações</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    @foreach($_notifications as $notification)
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> {{$notification['title']}}
                                        </a>
                                    </li><!-- end notification -->
                                    @endforeach
                                </ul>
                            </li>
                            <li class="footer"><a href="#">Vejas todas as notificações</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                <?php } ?>

                <?php if (isset($tasks)) { ?>
                    <?php if (count($tasks)) { ?>
                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">{{ count($tasks) }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Você tem {{ count($tasks) }} tarefas</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    @foreach($tasks as $task)
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                {{$task['title']}}
                                                <small class="pull-right">{{$task['progress']}}%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: {{$task['progress']}}%" role="progressbar" aria-valuenow="{{$task['progress']}}" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">{{$task['progress']}}% Completo</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                    @endforeach
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">Veja todas as tarefas</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                <?php } ?>

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset("person.jpg") }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">
                            @if (Auth::guest())
                            @else
                            {{ Auth::user()->name }} 
                            @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset("person.jpg") }}" class="img-circle" alt="User Image" />
                            <p>
                                @if (Auth::guest())
                                @else
                                    {{ Auth::user()->name }} 
                                @endif
                                <small>Membro desde {{ Auth::user()->created_at->format('m') }} de {{ Auth::user()->created_at->format('Y') }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <!--
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                            -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('person.edit', Auth::user()->id) }}" class="btn btn-default btn-flat">Meus dados</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>