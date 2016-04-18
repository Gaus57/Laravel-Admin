<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>{{ $title or 'Админка' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="/adminlte/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/adminlte/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="/adminlte/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="/adminlte/plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    
    <link href="/adminlte/style.css" rel="stylesheet" type="text/css" />

    <!-- jQuery 2.1.4 -->
    <script src="/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="/adminlte/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/adminlte/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="/adminlte/dist/js/app.min.js" type="text/javascript"></script>
    
    <script src="/adminlte/interface.js" type="text/javascript"></script>

    @yield('scripts')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue sidebar-close">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="{{ url() }}" class="logo" target="_blank">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><i class="fa fa-home"></i></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          
          <ul class="nav navbar-nav">
            <li><a href="{{ route('admin.pages') }}"><i class="fa fa-fw fa-sitemap"></i> Структура сайта</a></li>
            <li><a href="{{ route('admin.catalog') }}"><i class="fa fa-fw fa-list"></i> Каталог</a></li>
            <li><a href="{{ route('admin.news') }}"><i class="fa fa-fw fa-calendar"></i> Новости</a></li>
            <li><a href="{{ route('admin.gallery') }}"><i class="fa fa-fw fa-image"></i> Галереи</a></li>
            <li><a href="{{ route('admin.reviews') }}"><i class="fa fa-fw fa-star"></i> Отзывы</a></li>
            <li><a href="{{ route('admin.settings') }}"><i class="fa fa-fw fa-gears"></i> Настройки</a></li>
          </ul>
          
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li><a href="{{ route('admin.feedbacks') }}">
                <i class="fa fa-fw fa-bell-o"></i>
                @if ($feedback_new = Gaus\Admin\Models\Feedback::notRead()->count())
                  <span class="label label-danger">{{ $feedback_new }}</span>
                @endif
              </a></li>
              <li><a href="{{ route('admin.users') }}"><i class="fa fa-fw fa-group"></i></a></li>
              <li><a href="{{ route('admin.pages',['sitemap' => 1]) }}" title="Обновить sitemap.xml"><i class="fa fa-fw fa-sitemap" title="Обновить sitemap.xml"></i></a></li>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!--<img src="/adminlte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>-->
                  <span class="hidden-xs">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <!--<img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />-->
                    <p>
                      {{ Auth::user()->name }}
                      <small>Зарегистрирован {{ date('d.m.Y', strtotime(Auth::user()->created_at)) }}</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ route('admin.users.edit', [Auth::user()->id]) }}" class="btn btn-default btn-flat" onclick="popupAjax($(this).attr('href')); return false;">Профиль</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{ route('auth') }}" class="btn btn-default btn-flat">Выйти</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>

        </nav>
      </header>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="margin:0;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          @yield('page_name')
          @yield('breadcrumb')
        </section>

        <!-- Main content -->
        <section class="content">

          @yield('content')

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer" style="margin:0;">
        <div class="pull-right hidden-xs">
          <b>Version</b> 0.1
        </div>
        <strong>&copy; 2015 <a href="http://fanky.ru">Gaus</a>.</strong>
      </footer>

    </div><!-- ./wrapper -->

  </body>
</html>