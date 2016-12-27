<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>客户信息</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.css')?>" rel="stylesheet">

    <!-- Toastr style -->
    <link href="<?= base_url('assets/css/plugins/toastr/toastr.min.css')?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/animate.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css')?>" rel="stylesheet">
    <script type="text/javascript">
        function setModifyInfo(account,name,authority)
        {
            $('#modifyUserAccount').val(account);
            $('#modifyUserName').val(name);
            $('#modifyUserAuthority').val(authority);
            $('#modifyUserForm').attr("action", "<?=site_url('SystemManage/UserManage/modifyUser/')?>"+account)
        }

        function setDeleteInfo(account)
        {
            var url = '<?=site_url('SystemManage/UserManage/deleteUser/')?>'+account;
            $('#confirmDelete').attr('onclick','toURL(\''+url+'\')');
        }

        function toURL(url)
        {
            window.location.href = url;
        }

        function addToSubmit()
        {
            if($('#addUserAccount').val()=='')
                $('#addUserAccountError').html('<p>输入不能为空</p>');
            else if($('#addUserAccountError').html()=='<p>输入不能为空</p>')
                $('#addUserAccountError').html('');
            if($('#addUserName').val()=='')
                $('#addUserNameError').html('<p>输入不能为空</p>');
            else
                $('#addUserNameError').html('');

            if($('#addUserAccountError').html()=='' && $('#addUserNameError').html()=='')
                $('#addUserForm').submit();
        }

        function modifyToSubmit()
        {
            if($('#modifyUserAccount').val()=='')
                $('#modifyUserAccountError').html('<p>输入不能为空</p>');
            else if($('#modifyUserAccountError').html()=='<p>输入不能为空</p>')
                $('#modifyUserAccountError').html('');
            if($('#modifyUserName').val()=='')
                $('#modifyUserNameError').html('<p>输入不能为空</p>');
            else
                $('#modifyUserNameError').html('');
            if($('#modifyUserAccountError').html()=='' && $('#modifyUserNameError').html()=='')
                $('#modifyUserForm').submit();
        }

        function changePasswordToSubmit()
        {
            if($('#passwordChangeFormer').val()=='')
                $('#formerPasswordError').html('<p>输入不能为空</p>');
            else
                $('#formerPasswordError').html('');

            if($('#passwordChange').val()=='')
                $('#changePasswordError').html('<p>输入不能为空</p>');
            else
                $('#changePasswordError').html('');

            if($('#passwordChangeConfirm').val()=='')
                $('#confirmPasswordError').html('<p>输入不能为空</p>');
            else
                $('#confirmPasswordError').html('');

            if($('#passwordChange').val()!='' && $('#passwordChangeConfirm').val()!='' && ($('#passwordChange').val()!=$('#passwordChangeConfirm').val()))
                $('#confirmPasswordError').html('<p>请输入两次相同的密码</p>');

            if($('#changePasswordError').html()=='' && $('#confirmPasswordError').html()=='' && $('#formerPasswordError').html()=='')
            {
                var url = '<?= site_url('SystemManage/UserManage/passwordCheck/')?>'+$('#passwordChangeFormer').val();
                //alert(url);
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    error: changePassworderrFunction,  //错误执行方法
                    success: changePasswordSuccFunction //成功执行方法
                })
            }
        }

        function changePasswordSuccFunction(data) {
            //alert('密码修改成功');
            $('#changePasswordForm').submit();

        }

        function changePassworderrFunction(data) {
                $('#formerPasswordError').html('<p>原密码输入不正确</p>');
        }

        function validate_account() {
            var add_user_account = $('#addUserAccount').val();
            if(add_user_account!='') {
                var url = '<?= site_url('SystemManage/UserManage/findAccount')?>' + '/' + add_user_account;
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    error: errFunction,  //错误执行方法
                    success: addSuccFunction //成功执行方法
                })
            }
            else {
                $('#addUserError').html('');
            }

            var modify_user_account = $('#modifyUserAccount').val();
            if(modify_user_account!='') {
                var url = '<?= site_url('SystemManage/UserManage/findAccount')?>' + '/' + modify_user_account;
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    error: errFunction,  //错误执行方法
                    success: modifySuccFunction //成功执行方法
                })
            }
            else {
                $('#modifyUserAccountError').html('');
            }

        }

        function modifySuccFunction(data) {
            var json = eval(data);
            if (json != null)
                $('#modifyUserAccountError').html('<p>用户名已存在</p>');
            else
                $('#modifyUserAccountError').html('');

        }

        function addSuccFunction(data) {
            var json = eval(data);
            if (json != null)
                $('#addUserAccountError').html('<p>用户名已存在</p>');
            else
                $('#addUserAccountError').html('');

        }
        function errFunction(data) {
            alert('error');
        }
    </script>
</head>

<body>

    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_small.jpg" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">王昆</strong>
                             </span> <span class="text-muted text-xs block">管理员 <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a data-toggle="modal" data-target="#passwordChangeModal">修改密码</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= site_url('Login/logout') ?>">退出登录</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    <li >
                        <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">首页</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="index.html">首页 v.1</a></li>
                            <li><a href="dashboard_2.html">首页 v.2</a></li>
                            <li><a href="dashboard_3.html">首页 v.3</a></li>
                            <li><a href="dashboard_4_1.html">首页 v.4</a></li>
                            <li><a href="dashboard_5.html">首页 v.5 <span class="label label-primary pull-right">NEW</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">布局</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">图表</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="graph_flot.html">Flot Charts</a></li>
                            <li><a href="graph_morris.html">Morris.js Charts</a></li>
                            <li><a href="graph_rickshaw.html">Rickshaw Charts</a></li>
                            <li><a href="graph_chartjs.html">Chart.js</a></li>
                            <li><a href="graph_chartist.html">Chartist</a></li>
                            <li><a href="c3.html">c3 charts</a></li>
                            <li><a href="graph_peity.html">Peity Charts</a></li>
                            <li><a href="graph_sparkline.html">Sparkline Charts</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">邮箱 </span><span class="label label-warning pull-right">16/24</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="mailbox.html">收件箱</a></li>
                            <li><a href="mail_detail.html">邮件详情</a></li>
                            <li><a href="mail_compose.html">发送邮件</a></li>
                            <li><a href="email_template.html">邮件模板</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="metrics.html"><i class="fa fa-pie-chart"></i> <span class="nav-label">指标</span>  </a>
                    </li>
                    <li>
                        <a href="widgets.html"><i class="fa fa-flask"></i> <span class="nav-label">组件</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">表单</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="form_basic.html">基本表单</a></li>
                            <li><a href="form_advanced.html">高级插件</a></li>
                            <li><a href="form_wizard.html">分步引导</a></li>
                            <li><a href="form_file_upload.html">文件上传</a></li>
                            <li><a href="form_editors.html">富文本编辑</a></li>
                            <li><a href="form_markdown.html">Markdown</a></li>
                        </ul>
                    </li>
                    <li class="active">
                        <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">APP视图</span>  <span class="pull-right label label-primary">SPECIAL</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="contacts.html">联系方式</a></li>
                            <li ><a href="profile.html">个人信息</a></li>
                            <li ><a href="profile_2.html">个人信息 v.2</a></li>
                            <li ><a href="contacts_2.html">联系方式 v.2</a></li>
                            <li ><a href="projects.html">项目列表</a></li>
                            <li ><a href="project_detail.html">项目详情</a></li>
                            <li ><a href="teams_board.html">团队面板</a></li>
                            <li ><a href="social_feed.html">订阅</a></li>
                            <li class="active"><a href="allUser.php">客户信息</a></li>
                            <li><a href="full_height.html">Outlook</a></li>
                            <li><a href="vote_list.html">投票</a></li>
                            <li><a href="file_manager.html">文件管理</a></li>
                            <li><a href="calendar.html">日历</a></li>
                            <li><a href="issue_tracker.html">Issue</a></li>
                            <li><a href="blog.html">博客</a></li>
                            <li><a href="article.html">文章</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="timeline.html">时间轴</a></li>
                            <li><a href="pin_board.html">Pin board</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">其他</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="search_results.html">搜索结果</a></li>
                            <li><a href="lockscreen.html">锁屏</a></li>
                            <li><a href="invoice.html">发票</a></li>
                            <li><a href="login.html">登录</a></li>
                            <li><a href="login_two_columns.html">登录 v.2</a></li>
                            <li><a href="forgot_password.html">忘记密码</a></li>
                            <li><a href="register.html">注册</a></li>
                            <li><a href="404.html">404</a></li>
                            <li><a href="500.html">500</a></li>
                            <li><a href="empty_page.html">空白页面</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-globe"></i> <span class="nav-label">杂七杂八</span><span class="label label-info pull-right">NEW</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="toastr_notifications.html">通知</a></li>
                            <li><a href="nestable_list.html">嵌套列表</a></li>
                            <li><a href="agile_board.html">TO-DO LIST</a></li>
                            <li><a href="timeline_2.html">时间轴 v.2</a></li>
                            <li><a href="diff.html">文件对比</a></li>
                            <li><a href="i18support.html">国际化</a></li>
                            <li><a href="sweetalert.html">弹出框</a></li>
                            <li><a href="idle_timer.html">计时器</a></li>
                            <li><a href="truncate.html">截断...</a></li>
                            <li><a href="spinners.html">菊花</a></li>
                            <li><a href="tinycon.html">favicon</a></li>
                            <li><a href="google_maps.html">谷歌地图</a></li>
                            <li><a href="code_editor.html">代码</a></li>
                            <li><a href="modal_window.html">模态对话框</a></li>
                            <li><a href="clipboard.html">剪贴板</a></li>
                            <li><a href="forum_main.html">论坛</a></li>
                            <li><a href="validation.html">JS验证</a></li>
                            <li><a href="tree_view.html">树</a></li>
                            <li><a href="loading_buttons.html">加载按钮</a></li>
                            <li><a href="chat_view.html">聊天</a></li>
                            <li><a href="masonry.html">瀑布流</a></li>
                            <li><a href="tour.html">教程</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">UI</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="typography.html">段落</a></li>
                            <li><a href="icons.html">Icons</a></li>
                            <li><a href="draggable_panels.html">拖拽面板</a></li> <li><a href="resizeable_panels.html">调整大小面板</a></li>
                            <li><a href="buttons.html">按钮</a></li>
                            <li><a href="video.html">视频</a></li>
                            <li><a href="tabs_panels.html">面板</a></li>
                            <li><a href="tabs.html">Tabs</a></li>
                            <li><a href="notifications.html">通知 & Tooltips</a></li>
                            <li><a href="badges_labels.html">徽章, Labels, 进度条</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="grid_options.html"><i class="fa fa-laptop"></i> <span class="nav-label">网格</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">表格</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="table_basic.html">静态表格</a></li>
                            <li><a href="table_data_tables.html">动态表格</a></li>
                            <li><a href="table_foo_table.html">高级表格</a></li>
                            <li><a href="jq_grid.html">jqGrid</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">电子商务</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="ecommerce_products_grid.html">产品-网格</a></li>
                            <li><a href="ecommerce_product_list.html">产品-列表</a></li>
                            <li><a href="ecommerce_product.html">产品-编辑</a></li>
                            <li><a href="ecommerce_product_detail.html">产品-详情</a></li>
                            <li><a href="ecommerce-cart.html">购物车</a></li>
                            <li><a href="ecommerce-orders.html">订单</a></li>
                            <li><a href="ecommerce_payments.html">信用卡</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">画廊</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="basic_gallery.html">灯箱</a></li>
                            <li><a href="slick_carousel.html">旋转木马</a></li>
                            <li><a href="carousel.html">Bootstrap 轮播</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">菜单 </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="#">三级菜单 <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">三级菜单标题</a>
                                    </li>
                                    <li>
                                        <a href="#">三级菜单标题</a>
                                    </li>
                                    <li>
                                        <a href="#">三级菜单标题</a>
                                    </li>

                                </ul>
                            </li>
                            <li><a href="#">二级菜单标题</a></li>
                            <li>
                                <a href="#">二级菜单标题</a></li>
                            <li>
                                <a href="#">二级菜单标题</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="css_animation.html"><i class="fa fa-magic"></i> <span class="nav-label">CSS动画 </span><span class="label label-info pull-right">62</span></a>
                    </li>
                    <li class="landing_link">
                        <a target="_blank" href="landing.html"><i class="fa fa-star"></i> <span class="nav-label">着陆页</span> <span class="label label-warning pull-right">NEW</span></a>
                    </li>
                    <li class="special_link">
                        <a href="package.html"><i class="fa fa-database"></i> <span class="nav-label">框架</span></a>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">欢迎来到goopay</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a7.jpg">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46小时前</small>
                                    <strong>李文俊</strong> 关注了 <strong>刘海洋</strong>. <br>
                                    <small class="text-muted">3 天 前- 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a4.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5小时前</small>
                                    <strong>王昆</strong> 关注了 <strong>李文俊</strong>. <br>
                                    <small class="text-muted">昨天下午1:21 - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/profile.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23小时前</small>
                                    <strong>张三</strong> 赞了 <strong>李四</strong>. <br>
                                    <small class="text-muted">2天前 - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>查看更多消息</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> 您有 16 条未读通知
                                    <span class="pull-right text-muted small">4 分钟 前</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 个新粉丝
                                    <span class="pull-right text-muted small">12 分钟 前</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> 服务器重启
                                    <span class="pull-right text-muted small">4 分钟 前</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>查看更多通知</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="login.html">
                        <i class="fa fa-sign-out"></i> 退出登录
                    </a>
                </li>
            </ul>
        </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>用户信息</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?= site_url('index') ?>">首页</a>
                        </li>
                        <li>
                            <a>App视图</a>
                        </li>
                        <li class="active">
                            <strong>客户信息</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h2 style="display: inline-block">用户</h2><div style="display: inline-block;margin: 0px 0px 10px 15px;"  class="input-group-btn">
                                        <button type="button" class="btn btn btn-primary" data-toggle="modal" data-target="#addUserModal">添加用户</button>
                                </div>
                            <form method="post" action="<?= site_url('SystemManage/UserManage/search') ?>">
                            <div class="input-group">
                                <input type="text" placeholder="搜索用户 " class="input form-control" name="search">
                                <span class="input-group-btn">
                                        <button type="submit" class="btn btn btn-primary"> <i class="fa fa-search"></i> 开始搜索</button>
                                </span>
                            </div>
                            </form>
                            <div class="clients-list">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <tbody id="allUserList">
                                                <?php foreach($allUser->result() as $allUserRow): ?>
                                                <tr id="tr<?= $allUserRow->user_account ?>">
                                                    <td class="client-avatar"><img alt="image" src="img/a2.jpg"> </td>
                                                    <td width="25%"><?= $allUserRow->user_account ?></td>
                                                    <td width="25%"><?= $allUserRow->user_name ?></td>
                                                    <td width="25%">
                                                        <?php if($allUserRow->user_authority == 0): ?>
                                                        超级管理员
                                                        <?php elseif($allUserRow->user_authority == 1): ?>
                                                        授权用户
                                                        <?php elseif($allUserRow->user_authority == 2): ?>
                                                        审查用户
                                                        <?php endif; ?>
                                                        </td>

                                                    <td width="25%">
                                                        <?php if($allUserRow->user_account!=$this->session->userdata('user_account')): ?>
                                                        <button type="button" style="float:right;margin:0px 5px;" class="btn btn btn-danger" data-toggle="modal" data-target="#deleteUserModal" onclick="setDeleteInfo('<?=$allUserRow->user_account?>')">删除用户</button>
                                                        <?php endif; ?>
                                                        <button style="float:right;margin:0px 5px;" type="button" class="btn btn btn-primary" data-toggle="modal" data-target="#modifyUserModal" onclick="setModifyInfo('<?=$allUserRow->user_account?>','<?=$allUserRow->user_name?>','<?=$allUserRow->user_authority?>')">修改用户</button>

                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2015
            </div>
        </div>
        </div>
        </div>

    <!-- Modal -->
    <div class="modal fade" id="modifyUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">修改用户</h4>
                </div>
                <div class="modal-body">
                <form class="m-t" role="form" method="post" id="modifyUserForm">
                <div class="form-group">
                        <input type="text" class="form-control" placeholder="用户名" name="user_account" required="required" maxlength="30" pattern="^[\w\d_]*$" onchange="validate_account()" id="modifyUserAccount">
                     <div style="color:red" id="modifyUserAccountError"></div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="真实姓名" name="user_name" required="required" id="modifyUserName">
                        <div style="color:red" id="modifyUserNameError"></div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="密码(密码为空时不修改密码)" name="user_password" id="modifyUserPassword">
                    </div>
                    <div class="form-group">
                            <select class="form-control" name="user_authority" id="modifyUserAuthority">
                                <option value="0">超级管理员</option>
                                <option value="1">授权用户</option>
                                <option value="2">审查用户</option>
                            </select>
                    </div>
                    <div class="form-group">
                    <button type="button" class="btn btn-primary" onclick="modifyToSubmit()">提交</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加用户</h4>
                </div>
                <div class="modal-body">
                    <form class="m-t" role="form" action="<?=site_url('SystemManage/UserManage/addUser')?>" method="post" id="addUserForm">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="用户名" name="user_account" required="required" maxlength="30" pattern="^[\w\d_]*$" onblur="validate_account()" id="addUserAccount">
                            <div style="color:red" id="addUserAccountError"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="真实姓名" name="user_name" required="required" id="addUserName">
                            <div style="color:red" id="addUserNameError"></div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="user_authority">
                                <option value="0">超级管理员</option>
                                <option value="1">授权用户</option>
                                <option value="2">审查用户</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" onclick="addToSubmit()">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">确认删除</h4>
                </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="confirmDelete" onclick="">确认删除</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="passwordChangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">修改密码</h4>
                </div>
                <div class="modal-body">
                    <form class="m-t" role="form" action="<?=site_url('SystemManage/UserManage/changePassword')?>" method="post" id="changePasswordForm">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="原密码" name="user_password" required="required" maxlength="30" pattern="^[\w\d_]*$" id="passwordChangeFormer">
                            <div style="color:red" id="formerPasswordError"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="新密码" name="newPassword" required="required" maxlength="30" pattern="^[\w\d_]*$" id="passwordChange">
                            <div style="color:red" id="changePasswordError"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="确认新密码" name="newPasswordConfirm" required="required" maxlength="30" pattern="^[\w\d_]*$" id="passwordChangeConfirm">
                            <div style="color:red" id="confirmPasswordError"></div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" onclick="changePasswordToSubmit()">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?= base_url('assets/js/jquery-2.1.1.js')?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?= base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js')?>"></script>
    <script src="<?= base_url('assets/js/plugins/slimscroll/jquery.slimscroll.min.js')?>"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?= base_url('assets/js/inspinia.js')?>"></script>
    <script src="<?= base_url('assets/js/plugins/pace/pace.min.js')?>"></script>

</body>
</html>
