<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/plugins/summernote/summernote.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/plugins/summernote/summernote-bs3.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/plugins/datapicker/datepicker3.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/animate.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <script type="te">
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
    </script>
</head>

<body>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                           <span>
                             <?php if($this->session->userdata('user_authority') == 0):?>
                                 <img alt="image" class="img-circle" src="<?= base_url('assets/img/user_authority_0.png') ?>" />
                             <?php elseif($this->session->userdata('user_authority') == 1): ?>
                                 <img alt="image" class="img-circle" src="<?= base_url('assets/img/user_authority_1.png') ?>" />
                             <?php elseif($this->session->userdata('user_authority') == 2): ?>
                                 <img alt="image" class="img-circle" src="<?= base_url('assets/img/user_authority_2.png') ?>" />
                             <?php endif; ?>
                           </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs">
                                   <strong class="font-bold"><?=$this->session->userdata('user_account')?></strong>

                            <span class="text-muted text-xs block">
                                    <?php if($this->session->userdata('user_authority') == 0):?>
                                        <?="超级管理员"?>
                                    <?php elseif($this->session->userdata('user_authority') == 1): ?>
                                        <?= "授权用户" ?>
                                    <?php elseif($this->session->userdata('user_authority') == 2): ?>
                                        <?= "审查用户" ?>
                                    <?php endif; ?>
                                <b class="caret"></b>
                            </span>
                        </a>

                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="#" data-toggle="modal" data-target="#passwordChangeModal">修改密码</a></li>
                            <li class="divider"></li>
                            <li><a href="<?= site_url('Login/logout') ?>">退出登录</a></li>

                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li>
                    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">用户信息</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url('SystemManage/userManage') ?>">用户管理</a></li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">项目管理</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url('SystemManage/Project/addProjectIndex') ?>">项目信息登记</a></li>
                        <li><a href="<?= site_url('SystemManage/Project') ?>">项目信息维护</a></li>
                        <li><a href="#">系统信息导入</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">缺陷管理</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url('FaultManage/Fault/addFault') ?>">缺陷报告</a></li>
                        <li><a href="<?= site_url('FaultManage/FaultShow') ?>">缺陷查询</a></li>
                        <li><a href="<?= site_url('FaultManage/Fault/watchMyFault') ?>">我的缺陷</a></li>
                        <li><a href="#">缺陷统计</a></li>
                    </ul>
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
                        <a href="<?= site_url('Login/logout') ?>">
                            <i class="fa fa-sign-out"></i> 退出登录
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>项目信息维护</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">首页</a>
                    </li>
                    <li>
                        <a>项目管理</a>
                    </li>
                    <li class="active">
                        <strong>项目信息维护</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>所有项目</h5>
                            <div class="ibox-tools">
                                <a href="<?= site_url('SystemManage/Project/addProjectIndex') ?>" class="btn btn-primary btn-xs">项目信息登记</a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form action="<?= site_url('SystemManage/Project/search') ?>" method="post">
                            <div class="row m-b-sm m-t-sm">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" placeholder="请输入搜索内容" class="input-sm form-control" name="search" value="<?= set_value('search') ?>">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <div class="project-list">

                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th data-hide="phone" class="col-md-2">项目ID</th>
                                        <th data-hide="phone" class="col-md-2">项目名称</th>
                                        <th data-hide="phone" class="col-md-1">版本号</th>
                                        <th data-hide="phone" class="col-md-1">子系统</th>
                                        <th data-hide="phone" class="col-md-3">项目成员</th>
                                        <th data-hide="phone" class="col-md-3"></th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach($project->result() as $projectRow): ?>
                                    <tr>
                                        <td class="project-status">
                                            <span class=""><?= $projectRow->project_id ?></span>
                                        </td>
                                        <td class="project-title">
                                            <?= $projectRow->project_name ?>
                                        </td>
                                        <td class="project-version">
                                            <small><?= $projectRow->project_version ?></small>
                                        </td>
                                        <td class="project-subsys">
                                            <?php $allSubsystem = $this->Project_model->get_all_subsystem($projectRow->project_id); ?>
                                            <?php foreach($allSubsystem->result() as $allSubsystemRow): ?>
                                            <small><?= $allSubsystemRow->subsystem ?></small>
                                            <?php endforeach; ?>
                                        </td>
                                        <td  class="project-member">
                                            <?php $allMembers = $this->User_model->get_user_project_by_projectID($projectRow->project_id); ?>
                                            <?php foreach($allMembers->result() as $allMembersRow):?>
                                            <small><?= $allMembersRow->user_account ?></small>
                                            <?php endforeach; ?>
                                        </td>
                                        <td class="project-actions">
                                            <!--<a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </a>-->
                                            <a href="<?= site_url('SystemManage/Project/modifyProjectIndex/'.$projectRow->project_id) ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
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
        <div class="footer">
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2015
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
<script src="<?= base_url('assets/js/jquery-2.1.1.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') ?>"></script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url('assets/js/inspinia.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/pace/pace.min.js') ?>"></script>

<!-- SUMMERNOTE -->
<script src="<?= base_url('assets/js/plugins/summernote/summernote.min.js') ?>"></script>

<!-- Data picker -->
<script src="<?= base_url('assets/js/plugins/datapicker/bootstrap-datepicker.js') ?>"></script>

<!-- Ladda -->
<script src="<?= base_url('assets/js/plugins/ladda/spin.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/ladda/ladda.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/ladda/ladda.jquery.min.js') ?>"></script>

<script>
    $(document).ready(function(){

        $('#loading-example-btn').click(function () {
            btn = $(this);
            simpleLoad(btn, true)

            // Ajax example
//                $.ajax().always(function () {
//                    simpleLoad($(this), false)
//                });

            simpleLoad(btn, false)
        });
    });

    function simpleLoad(btn, state) {
        if (state) {
            btn.children().addClass('fa-spin');
            btn.contents().last().replaceWith(" Loading");
        } else {
            setTimeout(function () {
                btn.children().removeClass('fa-spin');
                btn.contents().last().replaceWith(" Refresh");
            }, 2000);
        }
    }
</script>
</body>

</html>
