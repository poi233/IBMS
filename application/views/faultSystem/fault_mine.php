<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>我的缺陷</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/plugins/summernote/summernote.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/plugins/summernote/summernote-bs3.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/plugins/datapicker/datepicker3.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/animate.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <script type="text/javascript">
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
                <h2>我的缺陷</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">首页</a>
                    </li>
                    <li>
                        <a>缺陷管理</a>
                    </li>
                    <li class="active">
                        <strong>我的缺陷</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="project-list">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th data-hide="phone" class="col-md-2">提交人</th>
                                        <th data-hide="phone" class="col-md-2">项目ID</th>
                                        <th data-hide="phone" class="col-md-2">严重程度</th>
                                        <th data-hide="phone" class="col-md-2">发起日期</th>
                                        <th data-hide="phone" class="col-md-2">当前状态</th>
                                        <th> </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php if($creator->num_rows()>0): ?>
                                    <?php foreach($creator->result() as $creatorRow): ?>
                                            <?php $rowInfo = $this->Fault_status_model->get_info_of_each_status($creatorRow->fault_id)->row() ?>
                                    <tr>
                                        <td class="fault-creator">
                                            <?= $this->User_model->get_account_by_id($rowInfo->creator_id) ?><?= $rowInfo->fault_status ?>
                                        </td>
                                        <td class="project-id">
                                            <span class=""><?= $rowInfo->project_id ?></span>
                                        </td>
                                        <td class="fault-level">
                                            <small><?php switch ($rowInfo->fault_level) {
                                                    case 0:
                                                        echo '低';
                                                        break;
                                                    case 1:
                                                        echo '中';
                                                        break;
                                                    case 2:
                                                        echo '高';
                                                        break;
                                                } ?></small>
                                        </td>
                                        <td  class="fault-date">
                                            <?= $rowInfo->fault_open_time ?>
                                        </td>
                                        <td class="fault-status">
                                            <?php switch ($rowInfo->fault_status) {
                                                    case 0:
                                                        echo '<span class="label label-info">草稿</span>';
                                                        break;
                                                    case 5:
                                                        echo '<span class="label label-warning">待完成</span>';
                                                        break;
                                                    case 6:
                                                        echo '<span class="label label-primary">已完成</span>';
                                                        break;
                                                    case 7:
                                                        echo '<span class="label label-danger">未过申</span>';
                                                        break;
                                                } ?>
                                        </td>
                                        <td class="project-actions">
                                            <a href="<?= site_url('FaultManage/Fault/choose_status/'.$rowInfo->fault_id) ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if($checker->num_rows()>0): ?>
                                        <?php foreach($checker->result() as $checkerRow): ?>
                                            <?php $rowInfo = $this->Fault_status_model->get_info_of_each_status($checkerRow->fault_id)->row() ?>
                                            <tr>
                                                <td class="fault-creator">
                                                    <?= $this->User_model->get_account_by_id($rowInfo->creator_id) ?>
                                                </td>
                                                <td class="project-id">
                                                    <span class=""><?= $rowInfo->project_id ?></span>
                                                </td>
                                                <td class="fault-level">
                                                    <small><?php switch ($rowInfo->fault_level) {
                                                            case 0:
                                                                echo '低';
                                                                break;
                                                            case 1:
                                                                echo '中';
                                                                break;
                                                            case 2:
                                                                echo '高';
                                                                break;
                                                        } ?></small>
                                                </td>
                                                <td  class="fault-date">
                                                    <?= $rowInfo->fault_open_time ?>
                                                </td>
                                                <td class="fault-status">
                                                    <?php switch ($rowInfo->fault_status) {
                                                        case 1:
                                                            echo '<span class="label label-warning">待审核</span>';
                                                            break;
                                                        case 8:
                                                            echo '<span class="label label-info">已挂起</span>';
                                                            break;
                                                        case 9:
                                                            echo '<span class="label label-danger">定位失败</span>';
                                                            break;
                                                    } ?>
                                                </td>
                                                <td class="project-actions">
                                                    <a href="<?= site_url('FaultManage/Fault/choose_status/'.$rowInfo->fault_id) ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if($locator->num_rows()>0): ?>
                                        <?php foreach($locator->result() as $locatorRow): ?>
                                            <?php $rowInfo = $this->Fault_status_model->get_info_of_each_status($locatorRow->fault_id)->row() ?>
                                            <tr>
                                                <td class="fault-creator">
                                                    <?= $this->User_model->get_account_by_id($rowInfo->creator_id) ?>
                                                </td>
                                                <td class="project-id">
                                                    <span class=""><?= $rowInfo->project_id ?></span>
                                                </td>
                                                <td class="fault-level">
                                                    <small><?php switch ($rowInfo->fault_level) {
                                                            case 0:
                                                                echo '低';
                                                                break;
                                                            case 1:
                                                                echo '中';
                                                                break;
                                                            case 2:
                                                                echo '高';
                                                                break;
                                                        } ?></small>
                                                </td>
                                                <td  class="fault-date">
                                                    <?= $rowInfo->fault_open_time ?>
                                                </td>
                                                <td class="fault-status">
                                                    <?php switch ($rowInfo->fault_status) {
                                                        case 2:
                                                            echo '<span class="label label-warning">待定位</span>';
                                                            break;
                                                        case 10:
                                                            echo '<span class="label label-danger">修改失败</span>';
                                                            break;
                                                    } ?>
                                                </td>
                                                <td class="project-actions">
                                                    <a href="<?= site_url('FaultManage/Fault/choose_status/'.$rowInfo->fault_id) ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if($modifier->num_rows()>0): ?>
                                        <?php foreach($modifier->result() as $modifierRow): ?>
                                            <?php $rowInfo = $this->Fault_status_model->get_info_of_each_status($modifierRow->fault_id)->row() ?>
                                            <tr>
                                                <td class="fault-creator">
                                                    <?= $this->User_model->get_account_by_id($rowInfo->creator_id) ?>
                                                </td>
                                                <td class="project-id">
                                                    <span class=""><?= $rowInfo->project_id ?></span>
                                                </td>
                                                <td class="fault-level">
                                                    <small><?php switch ($rowInfo->fault_level) {
                                                            case 0:
                                                                echo '低';
                                                                break;
                                                            case 1:
                                                                echo '中';
                                                                break;
                                                            case 2:
                                                                echo '高';
                                                                break;
                                                        } ?></small>
                                                </td>
                                                <td  class="fault-date">
                                                    <?= $rowInfo->fault_open_time ?>
                                                </td>
                                                <td class="fault-status">
                                                    <?php switch ($rowInfo->fault_status) {
                                                        case 3:
                                                            echo '<span class="label label-warning">待修改</span>';
                                                            break;
                                                        case 11:
                                                            echo '<span class="label label-danger">验证失败</span>';
                                                            break;
                                                    } ?>
                                                </td>
                                                <td class="project-actions">
                                                    <a href="<?= site_url('FaultManage/Fault/choose_status/'.$rowInfo->fault_id) ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if($validator->num_rows()>0): ?>
                                        <?php foreach($validator->result() as $validatorRow): ?>
                                            <?php $rowInfo = $this->Fault_status_model->get_info_of_each_status($validatorRow->fault_id)->row() ?>
                                            <tr>
                                                <td class="fault-creator">
                                                    <?= $this->User_model->get_account_by_id($rowInfo->creator_id) ?>
                                                </td>
                                                <td class="project-id">
                                                    <span class=""><?= $rowInfo->project_id ?></span>
                                                </td>
                                                <td class="fault-level">
                                                    <small><?php switch ($rowInfo->fault_level) {
                                                            case 0:
                                                                echo '低';
                                                                break;
                                                            case 1:
                                                                echo '中';
                                                                break;
                                                            case 2:
                                                                echo '高';
                                                                break;
                                                        } ?></small>
                                                </td>
                                                <td  class="fault-date">
                                                    <?= $rowInfo->fault_open_time ?>
                                                </td>
                                                <td class="fault-status">
                                                    <?php switch ($rowInfo->fault_status) {
                                                        case 4:
                                                            echo '<span class="label label-warning">待验证</span>';
                                                            break;
                                                    } ?>
                                                </td>
                                                <td class="project-actions">
                                                    <a href="<?= site_url('FaultManage/Fault/choose_status/'.$rowInfo->fault_id) ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
