<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>缺陷查看</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/plugins/summernote/summernote.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/plugins/summernote/summernote-bs3.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/plugins/datapicker/datepicker3.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/animate.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

    <script type="text/javascript">
        function projectIDValidation() {
            if ($('#projectID').val() != '') {
                var url = '<?= site_url('SystemManage/Project/projectCheck/')?>' + $('#projectID').val();
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    error: errFunction,  //错误执行方法
                    success: successFunction //成功执行方法
                })
            }
        }

        function successFunction(data) {
            var json = eval(data);
            if (json != null)
                $('#projectIDError').html('<p>项目已存在</p>');
            else
                $('#projectIDError').html('');
        }

        function errFunction(data) {
            alert('error');
        }

        function addMember() {
            var $member_id = $("select[name=projectMember]").val();
            var $member_account = $("select[name=projectMember] option:selected").text();
            if ($member_account != '') {
                var $label = $('<label style=\"margin-right:10px\" id=\"toAdd' + $member_id + '\">' + '<label name=\"toAdd\">' + $member_account + '</label>' + '<a  href=\"javascript:cancelAddMember(' + $member_id + ',' + '\'' + $member_account + '\'' + ');\"><i class="fa fa-times"></i></a></label>')
                $('#toAddMembers').append($label);
                $("select[name=projectMember] option:selected").remove();
            } else {
                alert('无用户');
            }
        }

        function addSubsystem() {
            var $subSys = $('#projectSubsystem').val();
            if ($subSys != '') {
                var $flag = true;
                $("label[name='toAddSubsystem']").each(function (index, item) {
                        if ($(this).html() == $subSys)
                            $flag = false;
                    }
                );
                if ($flag) {
                    var $label = $('<label style=\"margin-right:10px\" id=\"toAddSubsystem' + $subSys + '\">' + '<label name=\"toAddSubsystem\">' + $subSys + '</label>' + '<a  href=\"javascript:cancelAddSubsystem(' + '\'' + $subSys + '\'' + ');\"><i class="fa fa-times"></i></a></label>');
                    $('#toAddSubsystems').append($label);
                } else {alert('子系统已存在');}
            } else {
                alert('请输入需添加子系统名');
            }

        }

        function cancelAddMember($member_id, $member_account) {
            var $option = $('<option value=\"' + $member_id + '\">' + $member_account + '</option>');
            $("select[name=projectMember]").append($option);
            var $loc = $('#toAdd' + $member_id);
            $(document).find($loc).remove();
        }

        function cancelAddSubsystem($subSys) {
            var $loc = $('#toAddSubsystem' + $subSys);
            $(document).find($loc).remove();
        }

        function toSubmit() {
            $toAddValue = '';
            $("label[name='toAdd']").each(function (index, item) {
                    $toAddValue += $(this).html();
                    $toAddValue += ',';
                }
            );
            $toAddSubsystemValue ='';
            $("label[name='toAddSubsystem']").each(function (index, item) {
                    $toAddSubsystemValue += $(this).html();
                    $toAddSubsystemValue += ',';
                }
            );
            $('#allAddMembers').val($toAddValue);
            $('#allAddSubsystems').val($toAddSubsystemValue);

            //错误处理
            if ($('#projectID').val() == '')
                $('#projectIDError').html('<p>内容不能为空</p>');
            else if ($('#projectIDError').html() == '<p>内容不能为空</p>')
                $('#projectIDError').html('');

            if ($('#projectName').val() == '')
                $('#projectNameError').html('<p>内容不能为空</p>');
            else
                $('#projectNameError').html('');

            if ($('#projectVersion').val() == '')
                $('#projectVersionError').html('<p>内容不能为空</p>');
            else
                $('#projectVersionError').html('');

            if ($('#allAddSubsystems').val() == '')
                $('#projectSubsysError').html('<p>内容不能为空</p>');
            else
                $('#projectSubsysError').html('');

            if ($('#allAddMembers').val() == '')
                $('#projectMemberError').html('<p>参与者不能为空</p>');
            else
                $('#projectMemberError').html('');

            if ($('#projectIDError').html() == '' && $('#projectNameError').html() == '' && $('#projectVersionError').html() == '' && $('#projectSubsysError').html() == '' && $('#projectMemberError').html() == '') {
                $('#addProjectForm').submit();
            }
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

        function locater_feedback() {
            var locate_feedback=$("#locater_feedback").find("option:selected").text();
            if(locate_feedback=="否")
            {
                $('#sub_system').show();
                $('#locater_information').show();
                $('#locater_back_reason').hide();
            }
            else if(locate_feedback=="是")
            {
                $('#sub_system').hide();
                $('#locater_information').hide();
                $('#locater_back_reason').show();
            }
            else{
                $('#sub_system').hide();
                $('#locater_information').hide();
                $('#locater_back_reason').hide();
            }
        }

        function modifier_feedback() {
            var modify_feedback=$("#modifier_feedback").find("option:selected").text();
            if(modify_feedback=="否")
            {
                $('#modifier_information').show();
                $('#modifier_back_reason').hide();
            }
            else if(modify_feedback=="是")
            {
                $('#modifier_information').hide();
                $('#modifier_back_reason').show();
            }
            else{
                $('#modifier_information').hide();
                $('#modifier_back_reason').hide();
            }
        }

        function validation_feedback() {
            var validation_feedback=$("#validationFeedback").find("option:selected").text();
            if(validation_feedback=="否")
            {
                $('#validation_information').show();
                $('#validation_back_reason').hide();
            }
            else if(validation_feedback=="是")
            {
                $('#validation_information').hide();
                $('#validation_back_reason').show();
            }
            else{
                $('#validation_information').hide();
                $('#validation_back_reason').hide();
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
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">用户信息</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url('SystemManage/userManage') ?>">用户管理</a></li>

                    </ul>
                </li>

                <li  class="active">
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">项目管理</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url('SystemManage/Project/addProjectIndex') ?>">项目信息登记</a></li>
                        <li><a href="<?= site_url('SystemManage/Project') ?>">项目信息维护</a></li>
                        <li><a href="#">系统信息导入</a></li>
                    </ul>
                </li>

                <li>
                    <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">缺陷管理</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="#">缺陷报告</a></li>
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
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary "><i class="fa fa-bars"></i> </a>


                </div>
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                    <i class="fa fa-angle-left " id="leftVersion"></i>
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
                <h2>缺陷查看</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">首页</a>
                    </li>
                    <li>
                        <a>缺陷管理</a>
                    </li>
                    <li class="active">
                        <strong>缺陷查看</strong>
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="ibox-content m-b-sm border-bottom">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="order_id">所属项目</label>
                            <input type="text" id="Project" name="Project" value="" placeholder="" class="form-control" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="status">子系统</label>
                            <input type="text" id="faultSubsystem" name="faultSubsystem" value="" placeholder="" class="form-control" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="amount">创建人</label>
                            <input type="text" id="creatorId" name="creatorId" value="" placeholder="" class="form-control" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="date_added">添加日期</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="fault_open_date" type="text" class="form-control" value="03/04/2014" readonly="readonly">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row animated fadeInRight">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-content" id="ibox-content">

                            <div id="vertical-timeline" class="vertical-container dark-timeline center-orientation">
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon lazur-bg">
                                        <i class="fa fa-upload"></i>
                                    </div>

                                    <div class="vertical-timeline-content">
                                        <h2>缺陷描述</h2>
                                        <p>这里是缺陷描述
                                        </p>
                                        <br>
                                        <!--<a href="#" class="btn btn-sm btn-primary"> More info</a>-->
                                        <h2>缺陷重现</h2>
                                        <p>这里是缺陷重现
                                        </p>
                                        <!--<a href="#" class="btn btn-sm btn-primary"> More info</a>-->
                                    <span class="vertical-date">提交人<br/>
                                        <small>admin</small>
                                    </span>
                                    </div>
                                </div>

                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon yellow-bg">
                                        <i class="fa fa-location-arrow"></i>
                                    </div>

                                    <div class="vertical-timeline-content">
                                        <h2>定位信息</h2>
                                        <p>这里是定位信息</p>
                                        <span class="vertical-date">定位人<br/>
                                        <small>poi</small>
                                    </span>
                                    </div>
                                </div>

                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon blue-bg">
                                        <i class="fa fa-file-text"></i>
                                    </div>

                                    <div class="vertical-timeline-content">
                                        <h2>修改信息</h2>
                                        <p>这里是修改信息</p>
                                        <span class="vertical-date">修改人<br/><small>poi</small></span>
                                    </div>
                                </div>

                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon navy-bg">
                                        <i class="fa fa-check"></i>
                                    </div>

                                    <div class="vertical-timeline-content">
                                        <h2>验证信息:</h2>
                                        <p>这里是验证信息</p>
                                        <span class="vertical-date">验证人<br/><small>poi</small></span>
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
<!--<script src="<?/*= base_url('assets/js/inspinia.js') */?>"></script>-->
<script src="<?= base_url('assets/js/plugins/pace/pace.min.js') ?>"></script>

<!-- SUMMERNOTE -->
<script src="<?= base_url('assets/js/plugins/summernote/summernote.min.js') ?>"></script>

<!-- Data picker -->
<script src="<?= base_url('assets/js/plugins/datapicker/bootstrap-datepicker.js') ?>"></script>

<!-- Ladda -->
<script src="<?= base_url('assets/js/plugins/ladda/spin.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/ladda/ladda.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/ladda/ladda.jquery.min.js') ?>"></script>

<!-- Peity -->
<script src="<?= base_url('assets/js/plugins/peity/jquery.peity.min.js') ?>"></script>
<script src="<?= base_url('assets/js/demo/peity-demo.js') ?>"></script>

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

<script>
    $(document).ready(function(){

        // Local script for demo purpose only
        $('#lightVersion').click(function(event) {
            event.preventDefault()
            $('#ibox-content').removeClass('ibox-content');
            $('#vertical-timeline').removeClass('dark-timeline');
            $('#vertical-timeline').addClass('light-timeline');
        });

        $('#darkVersion').click(function(event) {
            event.preventDefault()
            $('#ibox-content').addClass('ibox-content');
            $('#vertical-timeline').removeClass('light-timeline');
            $('#vertical-timeline').addClass('dark-timeline');
        });

        $('#leftVersion').click(function(event) {
            event.preventDefault()
            $('#vertical-timeline').toggleClass('center-orientation');
        });


    });
</script>


</body>

</html>
