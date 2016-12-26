<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>登录</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.css')?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/animate.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css')?>" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">IN+</h1>

            </div>
            <h3>欢迎进入+</h3>
            <form class="m-t" role="form" action="<?=site_url('Login/login')?>" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="用户名" name="user_account" required="required" maxlength="30" pattern="^[\w\d_]*$" value="<?= set_value('user_account'); ?>">
                    <?php echo form_error('user_account', '<div style="color:red">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="密码" name="user_password" required="required" maxlength="30" pattern="^[\w\d_]*$">
                    <?php echo form_error('user_password', '<div style="color:red">', '</div>'); ?>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登录</button>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?= base_url('assets/js/jquery-2.1.1.js')?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>

</body>

</html>
