<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>缺陷审核</title>

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

        function check_idea() {
            var check_idea = $("#faultStatus").find("option:selected").text();
            if (check_idea == "通过") {
                $('#select_next').show();
                $('#feedback').hide();
            }
            else if (check_idea == "不通过") {
                $('#select_next').hide();
                $('#feedback').show();
            }
            else if (check_idea == "延迟处理") {
                $('#select_next').hide();
                $('#feedback').hide();
            }
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
                             <?php if ($this->session->userdata('user_authority') == 0): ?>
                                 <img alt="image" class="img-circle"
                                      src="<?= base_url('assets/img/user_authority_0.png') ?>"/>
                             <?php elseif ($this->session->userdata('user_authority') == 1): ?>
                                 <img alt="image" class="img-circle"
                                      src="<?= base_url('assets/img/user_authority_1.png') ?>"/>
                             <?php elseif ($this->session->userdata('user_authority') == 2): ?>
                                 <img alt="image" class="img-circle"
                                      src="<?= base_url('assets/img/user_authority_2.png') ?>"/>
                             <?php endif; ?>
                           </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs">
                                   <strong class="font-bold"><?= $this->session->userdata('user_account') ?></strong>

                            <span class="text-muted text-xs block">
                                    <?php if ($this->session->userdata('user_authority') == 0): ?>
                                        <?= "超级管理员" ?>
                                    <?php elseif ($this->session->userdata('user_authority') == 1): ?>
                                        <?= "授权用户" ?>
                                    <?php elseif ($this->session->userdata('user_authority') == 2): ?>
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
                    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">用户信息</span> <span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url('SystemManage/userManage') ?>">用户管理</a></li>

                    </ul>
                </li>

                <li>
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">项目管理</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url('SystemManage/Project/addProjectIndex') ?>">项目信息登记</a></li>
                        <li><a href="<?= site_url('SystemManage/Project') ?>">项目信息维护</a></li>
                        <li><a href="#">系统信息导入</a></li>
                    </ul>
                </li>

                <li class="active">
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">缺陷管理</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url('FaultManage/Fault/addFault') ?>">缺陷报告</a></li>
                        <li><a href="#">缺陷跟踪处理</a></li>
                        <li><a href="#">缺陷查询</a></li>
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
                <h2>缺陷审核</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">首页</a>
                    </li>
                    <li>
                        <a>缺陷管理</a>
                    </li>
                    <li>
                        <a>缺陷跟踪处理</a>
                    </li>
                    <li class="active">
                        <strong>缺陷审核</strong>
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
                                    <fieldset class="form-horizontal">
                                        <form method="post" action="<?= site_url('FaultManage/Fault/locateFaultFailSend') ?>"
                                              id="checkFaultForm">
                                            <input hidden="hidden" name="faultID" id="faultID"
                                                   value="<?= $fault->fault_id ?>">

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">所属项目:</label>

                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" placeholder="项目"
                                                           readonly="readonly" name="Project" id="Project"
                                                           value="<?= $fault->project_id ?>">

                                                    <div style="color:red" id="ProjectError"></div>
                                                    <!--这里是错误提醒-->
                                                </div>
                                                <label class="col-sm-1 control-label">提交人:</label>

                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" placeholder="creator"
                                                           readonly="readonly" name="creatorID" id="creatorID"
                                                           value="<?= $this->User_model->get_account_by_id($fault->creator_id) ?>">

                                                    <div style="color:red" id="creatorIdError"></div>
                                                    <!--这里是错误提醒-->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">缺陷级别:</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" placeholder="Fault level"
                                                           readonly="readonly" name="faultLevel" id="faultLevel"
                                                           value="<?php
                                                           switch ($fault->fault_level) {
                                                               case 0:
                                                                   echo '低';
                                                                   break;
                                                               case 1:
                                                                   echo '中';
                                                                   break;
                                                               case 2:
                                                                   echo '高';
                                                                   break;
                                                           } ?>">

                                                    <div style="color:red" id="faultLevelError"></div>
                                                    <!--这里是错误提醒-->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">缺陷描述:</label>

                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="3" readonly="readonly"
                                                              name="faultDetail"
                                                              id="faultDetail"><?= $fault->fault_detail ?></textarea>
                                                </div>
                                                <div style="color:red" id="faultDetailError"></div>
                                                <!--这里是错误提醒-->
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">缺陷重现:</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control"
                                                           readonly="readonly" name="faultReappearInfo"
                                                           id="faultReappearInfo"
                                                           value="<?= $fault->fault_reappear_info ?>">
                                                </div>
                                                <div style="color:red" id="faultReappearInfoError"></div>
                                                <!--这里是错误提醒-->
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">审核人:</label>

                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" placeholder="审核人"
                                                           readonly="readonly" name="checkerID" id="checkerID"
                                                           value="<?= $this->User_model->get_account_by_id($fault->checker_id) ?>">

                                                    <div style="color:red" id="checkerIdError"></div>
                                                    <!--这里是错误提醒-->
                                                </div>
                                                <label class="col-sm-1 control-label">审核意见:</label>

                                                <div class="col-sm-2">
                                                    <select class="form-control" required="required" id="faultStatus"
                                                            name="faultStatus" onchange="check_idea()">
                                                        <option value="2">通过</option>
                                                        <option value="7">不通过</option>
                                                        <option value="8">延迟处理</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group" id="select_next"> <!--style="display: none;"-->
                                                <label class="col-sm-2 control-label">下一步 定位人:</label>

                                                <div class="col-sm-2">
                                                    <select class="form-control" name="locatorID" id="locatorID">
                                                        <?php foreach ($user->result() as $locatorRow): ?>
                                                            <?php if ($locatorRow->user_id != $fault->creator_id && $locatorRow->user_id != $fault->checker_id && $locatorRow->user_id!=$fault->modifier_id): ?>
                                                                <option
                                                                    value="<?= $locatorRow->user_id ?>" <?php if($locatorRow->user_id == $fault->locator_id) ?>selected="selected"><?= $this->User_model->get_account_by_id($locatorRow->user_id) ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>

                                                    <div style="color:red" id="locatorIDError"></div>
                                                    <!--这里是错误提醒-->
                                                </div>

                                                <label class="col-sm-1 control-label">修改人:</label>

                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" placeholder="审核人"
                                                           readonly="readonly" name="modifierID" id="modifierID" value="<?=$this->User_model->get_account_by_id($fault->modifier_id) ?>
">
                                                    <div style="color:red" id="modifierIDError"></div>
                                                    <!--这里是错误提醒-->
                                                </div>

                                            </div>

                                            <div class="form-group" id="feedback" style="display: none;">
                                                <label class="col-sm-2 control-label">反馈信息:</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" placeholder="反馈信息"
                                                           id="errorInfo" name="errorInfo">
                                                </div>
                                            </div>

                                            <div class="form-group has-error">
                                                <label class="col-sm-2 control-label">返回理由:</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" placeholder="返回理由" readonly="readonly" value="<?= $fault->error_info ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-11">
                                                    <button class="btn btn-primary pull-right" type="submit">确定</button>
                                                </div>
                                            </div>
                                        </form>
                                    </fieldset>

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
<!--<script src="<? /*= base_url('assets/js/inspinia.js') */ ?>"></script>
-->
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
