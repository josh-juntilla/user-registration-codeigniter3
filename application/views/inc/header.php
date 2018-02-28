<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration System</title>

    <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/grid.min.css"> 
    <link rel="stylesheet" href="<?php echo base_url() ?>css/style.css">
</head>

<body>

<header class="row">
    <div class="col-xs-9 col-md-3" id="logo">
        <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>images/logo.png" alt=""></a>
    </div>
    <div class="col-xs-3 nav-button row text-xs-center middle-xs">
        <div class="toggle-menu"><i class="fa fa-bars fa-2x"></i></div>
    </div>
    <div class="col-md-9 nav-wrapper">
        <nav>
            <ul class="row end-xs">
                <?php if(!$islogin){ ?>
                <li><a href="<?php echo base_url('auth') ?>">Login</a></li>
                <li><a href="<?php echo base_url('auth/register') ?>">Signup</a></li>
                <?php }else{ ?>
                <li><a href="<?php echo base_url('auth/logout') ?>">Logout</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>

<!-- <div class="mobile-nav">
    <ul>
        <?php if(!$islogin){ ?>
        <li><a href="<?php echo base_url('auth') ?>">Login</a></li>
        <li><a href="<?php echo base_url('register') ?>">Signup</a></li>
        <?php }else{ ?>
        <li><a href="<?php echo base_url('logout') ?>">Logout</a></li>
        <?php } ?>
    </ul>
</div>
 -->