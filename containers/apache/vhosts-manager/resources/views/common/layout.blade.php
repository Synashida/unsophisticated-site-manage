<!DOCTYPE html>
<html>

<head>
    <title>ローカル環境検証用サイト管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="/css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<style>
    .loading-blur {
        filter: blur(10px);
        animation-name: blur;
        animation-duration: 3s;
        animation-iteration-count: infinite;
    }

    @keyframes blur {
        0% {
            filter: blur(5px);
        }

        100% {
            filter: blur(0);
        }
    }

    #loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(255, 255, 255, 0.5);
        z-index: 999;

        display: flex;
        justify-content: center;
        align-items: center;
        visibility: hidden;
    }
</style>

<div id="loading" class="loading-blur">
    <img src="images/wait.png">
</div>


    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Logo -->
                    <div class="logo">
                        <h1><a href="/">ローカル環境検証用サイト管理</a></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-md-2">
                <div class="sidebar content-box" style="display: block;">
                    <ul class="nav">
                        <!-- Main menu -->
                        <li @if ($current=='add') class="current" @endif>
                            <a href="/">
                                <i class="glyphicon glyphicon-plus"></i> サイト新規追加
                            </a>
                        </li>
                        <?php $hosts = \App\Services\Utility::loadVhosts(); ?>
                        @foreach($hosts as $host)
                        <li @if ($current==$host['domain_name']) class="current" @endif>
                            <a style="color: #39b3d7; padding: 15px 15px 5px 15px;" href="http://{{ $host['domain_name'] }}:8000" target="_blank">
                                {{ $host['domain_name'] }} <i class="glyphicon glyphicon-share" aria-hidden="true"></i>
                            </a>
                            <div style="padding: 0px 15px 15px 5px;">
                                @if ($current=='delete' && $host['domain_name']==$domain_name)
                                <span style="padding-left: 1em; font-weight: bold;">
                                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i> DEL
                                </span>
                                @else
                                <a  style="display: inline; padding-left: 1em; font-size: 0.9em;" href="/delete/?domain_name={{ $host['domain_name'] }}">
                                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i> DEL
                                </a>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12 panel-warning">
                        @yield('contents')
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="container">

            <div class="copy text-center">
                &nbsp;
            </div>

        </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/custom.js"></script>
</body>

</html>