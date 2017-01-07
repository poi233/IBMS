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
        function toURL(url)
        {
            window.location.href = url;
        }

        function setModifyInfo(account,name,authority)
        {
            $('#modifyUserAccount').val(account);
            $('#modifyUserName').val(name);
            $('#modifyUserAuthority').val(authority);
            $('#modifyUserForm').attr("action", "<?=site_url('SystemManage/UserManage/modifyUser/')?>"+account)
        }

        function setDeleteInfo(user_id)
        {
            $('#deleteUserForm').attr("action", "<?=site_url('SystemManage/UserManage/deleteUser/')?>"+user_id);
            $('#confirmDelete').attr('onclick','deleteToSubmit(\''+user_id+'\')');
        }

        function deleteToSubmit(user_id)
        {
            var url = '<?= site_url('SystemManage/UserManage/deleteCheck/')?>'+user_id;
            //alert(url);
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                error: deleteErrFunction,  //错误执行方法
                success: deleteSuccFunction //成功执行方法
            })
        }

        function deleteErrFunction(data)
        {
            alert('用户有参与项目,无法删除');
        }

        function deleteSuccFunction(data)
        {
            $('#deleteUserForm').submit();
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
                    <li class="active">
                        <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">用户信息</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= site_url('SystemManage/userManage') ?>">用户管理</a></li>
                        </ul>
                    </li>

                    <li>
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
                <div class="col-lg-10">
                    <h2>用户信息</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?= site_url('index') ?>">首页</a>
                        </li>
                        <li class="active">
                            <strong>用户信息</strong>
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
                                <input type="text" placeholder="搜索用户 " class="input form-control" name="search" value="<?= set_value('search') ?>">
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
                                                    <td class="client-avatar"><img alt="image" src="<?= base_url('assets/img/user_authority_'.$allUserRow->user_authority.'.png') ?>"> </td>
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
                                                        <button type="button" style="float:right;margin:0px 5px;" class="btn btn btn-danger" data-toggle="modal" data-target="#deleteUserModal" onclick="setDeleteInfo('<?=$allUserRow->user_id?>')">删除用户</button>
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

    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">确认删除</h4>
                </div>
                <form action="" method="post" id="deleteUserForm">
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDelete" onclick="">确认删除
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
                </form>
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
