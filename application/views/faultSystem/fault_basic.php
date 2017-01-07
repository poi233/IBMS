<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>缺陷报告</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/plugins/summernote/summernote.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/plugins/summernote/summernote-bs3.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/plugins/datapicker/datepicker3.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/animate.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

    <script type="text/javascript">
        function changePasswordToSubmit() {
            if ($('#passwordChangeFormer').val() == '')
                $('#formerPasswordError').html('<p>输入不能为空</p>');
            else
                $('#formerPasswordError').html('');

            if ($('#passwordChange').val() == '')
                $('#changePasswordError').html('<p>输入不能为空</p>');
            else
                $('#changePasswordError').html('');

            if ($('#passwordChangeConfirm').val() == '')
                $('#confirmPasswordError').html('<p>输入不能为空</p>');
            else
                $('#confirmPasswordError').html('');

            if ($('#passwordChange').val() != '' && $('#passwordChangeConfirm').val() != '' && ($('#passwordChange').val() != $('#passwordChangeConfirm').val()))
                $('#confirmPasswordError').html('<p>请输入两次相同的密码</p>');

            if ($('#changePasswordError').html() == '' && $('#confirmPasswordError').html() == '' && $('#formerPasswordError').html() == '') {
                var url = '<?= site_url('SystemManage/UserManage/passwordCheck/')?>' + $('#passwordChangeFormer').val();
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
                <?php if($this->session->userdata('user_authority')==0): ?>
                    <li>
                        <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">用户信息</span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= site_url('SystemManage/userManage') ?>">用户管理</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">项目管理</span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= site_url('SystemManage/Project/addProjectIndex') ?>">项目信息登记</a></li>
                            <li><a href="<?= site_url('SystemManage/Project') ?>">项目信息维护</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="active">
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">缺陷管理</span></a>
                    <ul class="nav nav-second-level">
                        <?php if($this->session->userdata('user_authority')==0||$this->session->userdata('user_authority')==1):?>
                            <li><a href="<?= site_url('FaultManage/Fault/addFault') ?>">缺陷报告</a></li>
                            <li><a href="<?= site_url('FaultManage/Fault/watchMyFault') ?>">我的缺陷</a></li>
                        <?php endif; ?>
                        <li><a href="<?= site_url('FaultManage/FaultShow') ?>">缺陷查询</a></li>

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
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
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
                <h2>缺陷报告</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">首页</a>
                    </li>
                    <li>
                        <a>缺陷管理</a>
                    </li>
                    <li class="active">
                        <strong>缺陷报告</strong>
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight ecommerce">

            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body ">
                                    <form method="post" action="<?= site_url('FaultManage/Fault/addFaultSend') ?>"
                                          id="addFaultForm" name="addFaultForm">
                                        <fieldset class="form-horizontal">
                                            <div class="form-group"><label class="col-sm-2 control-label">缺陷级别:</label>

                                                <div class="col-sm-2">
                                                    <select class="form-control" name="faultLevel" id="faultLevel">
                                                        <option value="0">低</option>
                                                        <option value="1">中</option>
                                                        <option value="2">高</option>
                                                    </select>

                                                    <div style="color:red" id="faultLevelError"></div>
                                                    <!--这里是错误提醒-->
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">缺陷描述:</label>

                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="3" name="faultDetail"
                                                              id="faultDetail" required="required"></textarea>
                                                </div>
                                                <div style="color:red" id="faultDetailError"></div>
                                                <!--这里是错误提醒-->
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">缺陷重现:</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" placeholder=""
                                                           name="faultReappearInfo" id="faultReappearInfo"
                                                           required="required">
                                                </div>
                                                <div style="color:red" id="faultReappearInfoError"></div>
                                                <!--这里是错误提醒-->
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">所属项目:</label>

                                                <div class="col-sm-3">
                                                    <select class="form-control" name="projectID" id="projectID">
                                                        <?php foreach ($project->result() as $projectRow): ?>
                                                            <option
                                                                value="<?= $projectRow->project_id ?>"><?= $projectRow->project_name ?>
                                                                (<?= $projectRow->project_id ?>)
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>

                                                    <div style="color:red" id="faultProjectError"></div>
                                                    <!--这里是错误提醒-->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">审核人:</label>

                                                <div class="col-sm-2">
                                                    <select class="form-control" name="checkerID" id="checkerID">
                                                        <?php foreach ($user->result() as $userRow): ?>
                                                            <?php if ($userRow->user_id != $this->session->userdata('user_id')): ?>
                                                                <option
                                                                    value="<?= $userRow->user_id ?>"><?= $this->User_model->get_account_by_id($userRow->user_id) ?>
                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>

                                                    <div style="color:red" id="checkIDError"></div>
                                                    <!--这里是错误提醒-->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">下步处理安排:</label>

                                                <div class="col-sm-2">
                                                    <select class="form-control" id="faultStatus" name="faultStatus">
                                                        <option value="0">保存缺陷</option>
                                                        <option value="1">提交缺陷</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-11">
                                                    <button class="btn btn-primary pull-right" type="submit">提交</button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
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

<div class="modal fade" id="passwordChangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="modal-body">
                <form class="m-t" role="form" action="<?= site_url('SystemManage/UserManage/changePassword') ?>"
                      method="post" id="changePasswordForm">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="原密码" name="user_password"
                               required="required" maxlength="30" pattern="^[\w\d_]*$" id="passwordChangeFormer">

                        <div style="color:red" id="formerPasswordError"></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="新密码" name="newPassword"
                               required="required" maxlength="30" pattern="^[\w\d_]*$" id="passwordChange">

                        <div style="color:red" id="changePasswordError"></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="确认新密码" name="newPasswordConfirm"
                               required="required" maxlength="30" pattern="^[\w\d_]*$" id="passwordChangeConfirm">

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
<!--<script src="<?/*= base_url('assets/js/inspinia.js') */?>"></script>
--><script src="<?= base_url('assets/js/plugins/pace/pace.min.js') ?>"></script>

<!-- SUMMERNOTE -->
<script src="<?= base_url('assets/js/plugins/summernote/summernote.min.js') ?>"></script>

<!-- Data picker -->
<script src="<?= base_url('assets/js/plugins/datapicker/bootstrap-datepicker.js') ?>"></script>

<!-- Ladda -->
<script src="<?= base_url('assets/js/plugins/ladda/spin.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/ladda/ladda.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/ladda/ladda.jquery.min.js') ?>"></script>


<script>
    $(document).ready(function () {

        $('.summernote').summernote();

        $('.input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

    });
</script>

<script>

    $(document).ready(function () {

        // Bind normal buttons
        $('.ladda-button').ladda('bind', {timeout: 2000});

        // Bind progress buttons and simulate loading progress
        Ladda.bind('.progress-demo .ladda-button', {
            callback: function (instance) {
                var progress = 0;
                var interval = setInterval(function () {
                    progress = Math.min(progress + Math.random() * 0.1, 1);
                    instance.setProgress(progress);

                    if (progress === 1) {
                        instance.stop();
                        clearInterval(interval);
                    }
                }, 200);
            }
        });


        var l = $('.ladda-button-demo').ladda();

        l.click(function () {
            // Start loading
            l.ladda('start');

            // Timeout example
            // Do something in backend and then stop ladda
            setTimeout(function () {
                l.ladda('stop');
            }, 12000)


        });

    });

</script>


</body>

</html>
