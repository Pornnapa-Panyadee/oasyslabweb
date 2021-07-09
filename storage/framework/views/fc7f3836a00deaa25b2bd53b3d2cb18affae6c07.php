<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Oasys - Dashboard</title>

    <!-- Scripts -->
    <!-- <script src="<?php echo e(asset('js/app.js')); ?>" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->
    <!-- <script src="<?php echo e(asset('js/menu.js')); ?>"></script> -->

</head>

<body class="app">
    <div id="loader">
        <div class="spinner"></div>
    </div>

<div>
    <div class="sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-logo">
                <div class="peers ai-c fxw-nw">
                    <div class="peer peer-greed"><a class="sidebar-link td-n" href="<?php echo e(route('home')); ?>">
                            <div class="peers ai-c fxw-nw">
                                <div class="peer">
                                    <div class="logo"></div>
                                </div>
                                <div class="peer peer-greed"><h5 class="lh-1 mB-0 logo-text">Oasys CMS</h5></div>
                            </div>
                        </a></div>
                    <div class="peer">
                        <div class="mobile-toggle sidebar-toggle"><a href="" class="td-n"><i class="ti-arrow-circle-left"></i></a></div>
                    </div>
                </div>
            </div>
            <ul class="sidebar-menu scrollable pos-r">
                <li class="nav-item mT-30 active">
                    <a class="sidebar-link" href="<?php echo e(route('home')); ?>">
                        <span class="icon-holder"><i class="c-blue-500 ti-home"></i> </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <?php if(Auth::user()->role_id == 1): ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder material"><i class="material-icons c-brown-500">perm_identity</i></span>
                        <span class="title material-text">Users</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="sidebar-link" href="<?php echo e(route('users.createUser')); ?>">Create User</a></li>
                        <li><a class="sidebar-link" href="<?php echo e(route('users')); ?>">List User</a></li>
                        <li><a class="sidebar-link" href="<?php echo e(route('users.deletedUser')); ?>">Restore User</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder material"><i class="material-icons c-deep-orange-500">account_box</i></span>
                        <span class="title material-text">Members</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="sidebar-link" href="<?php echo e(route('members.create')); ?>">Create Members</a></li>
                        <li><a class="sidebar-link" href="<?php echo e(route('members')); ?>">List Members</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder material"><i class="c-indigo-500 material-icons">chrome_reader_mode</i></span>
                        <span class="title material-text">Articles</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="sidebar-link" href="<?php echo e(route('article.createArticle')); ?>">Create Articles</a></li>
                        <li><a class="sidebar-link" href="<?php echo e(route('article')); ?>">List Articles</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="sidebar-link" href="<?php echo e(route('images')); ?>">
                        <span class="icon-holder"><i class="c-purple-500 ti-map"></i></span>
                        <span class="title">Manage Images</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder material"><i class="material-icons c-teal-500">chrome_reader_mode</i></span>
                        <span class="title material-text">Projects</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- <li><a class="sidebar-link" href="<?php echo e(route('projects.create')); ?>">Create Main Projects</a></li> -->
                        <li><a class="sidebar-link" href="<?php echo e(route('projects')); ?>">List Projects</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder material"><i class="material-icons c-brown-500">book</i></span>
                        <span class="title material-text">Publications</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="sidebar-link" href="<?php echo e(route('publications.create')); ?>">Create Publications</a></li>
                        <li><a class="sidebar-link" href="<?php echo e(route('publications')); ?>">List Publications</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder material"><i class="material-icons c-blue-500">settings</i></span>
                        <span class="title material-text">Setting</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="sidebar-link" href="<?php echo e(route('settings.banner')); ?>">Banner</a></li>
                        <li><a class="sidebar-link" href="<?php echo e(route('settings.detail')); ?>">About Us & Contact</a></li>
                        <li><a class="sidebar-link" href="<?php echo e(route('settings.color')); ?>">Colors</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-container">
        <div class="header navbar">
            <div class="header-container">
                <ul class="nav-left">
                    <li><a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);"><i class="ti-menu"></i></a></li>
                </ul>
                <ul class="nav-right">
                    <?php if(Auth::guest()): ?>
                        <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                                <div class="peer"><span class="fsz-sm c-grey-900"><?php echo e(Auth::user()->name); ?></span></div>
                            </a>
                            <ul class="dropdown-menu fsz-sm">
                                <li>
                                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                                        <i class="ti-power-off mR-10"></i> <span>Logout</span>
                                    </a>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo e(csrf_field()); ?>

                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <main class="main-content bgc-grey-100">
            <div id="mainContent" class="backend">
                <?php $__env->startSection('content-container'); ?>
                    <?php echo $__env->yieldContent('content'); ?>
                <?php echo $__env->yieldSection(); ?>
            </div>
        </main>
        <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600"><span>Copyright © 2017 Designed by <a
                        href="https://colorlib.com" target="_blank" title="Colorlib">Colorlib</a>. All rights reserved.</span>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo e(asset('js/vendor.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/bundle.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/script.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/backend.js')); ?>"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149683720-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-149683720-1');
</script>
</body>
</html>
