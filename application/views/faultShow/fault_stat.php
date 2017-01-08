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

    <script>
        <?php switch($type['type']):case 0:?>
        window.onload = function () {
            <?php if($barData!=null): ?>
            var ticks = [
                <?php $count=0; ?>
                <?php foreach($barData->result() as $dataRow): ?>
                [<?= $count ?>,'<?= $this->User_model->get_account_by_id($dataRow->creator_id) ?>'],
                <?php $count++; ?>
                <?php endforeach; ?>
            ];
            <?php else: ?>
            var ticks = [
            ];
            <?php endif; ?>
            var barOptions = {
                series: {
                    bars: {

                        show: true,
                        barWidth: 0.6,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.8
                            }, {
                                opacity: 0.8
                            }]
                        }
                    }
                },
                xaxis: {
                    //tickDecimals: 0
                    ticks: ticks
                },
                colors: ["#1ab394"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: "<?= $xy==null?'x':$xy['x'] ?>:%x,<?= $xy==null?'x':$xy['y'] ?>:%y"
                }
            };
            var barData = {
                label: "bar",
                data: [
                        <?php if($barData!=null): ?>
                    <?php $count=0; ?>
                    <?php foreach($barData->result() as $dataRow): ?>
                    [<?= $count ?>, <?= $dataRow->creator_cnt ?>],
                    <?php $count++; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                ],
            };
            $.plot($("#flot-bar-chart"), [barData], barOptions);

            <?php if($barData==null):?>
            var data = [];
            <?php else: ?>
            var data = [
                <?php foreach($barData->result() as $dataRow): ?>
                {
                label: "<?= $this->User_model->get_account_by_id($dataRow->creator_id) ?>",
                data: "<?= $dataRow->creator_cnt ?>",
                color: "#"+("00000"+((Math.random()*16777215+0.5)>>0).toString(16)).slice(-6)
            },
                <?php endforeach; ?>
                ];
            <?php endif; ?>

            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });

        };
        <?php break; ?>
        <?php case 1: ?>
        window.onload = function () {
            <?php if($barData!=null): ?>
            var ticks = [
                [0,'低'],[1,'中'],[2,'高'],
            ];
            <?php else: ?>
            var ticks = [
            ];
            <?php endif; ?>
            var barOptions = {
                series: {
                    bars: {

                        show: true,
                        barWidth: 0.6,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.8
                            }, {
                                opacity: 0.8
                            }]
                        }
                    }
                },
                xaxis: {
                    //tickDecimals: 0
                    ticks: ticks
                },
                colors: ["#1ab394"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: "<?= $xy==null?'x':$xy['x'] ?>:%x,<?= $xy==null?'x':$xy['y'] ?>:%y"
                }
            };
            var barData = {
                label: "bar",
                data: [
                    <?php if($barData!=null): ?>
                    <?php foreach($barData->result() as $dataRow): ?>
                    [<?= $dataRow->fault_level ?>, <?= $dataRow->level_cnt ?>],
                    <?php endforeach; ?>
                    <?php endif; ?>
                ],
            };
            $.plot($("#flot-bar-chart"), [barData], barOptions);

            <?php if($barData==null):?>
            var data = [];
            <?php else: ?>
            var data = [
                <?php foreach($barData->result() as $dataRow): ?>
                {
                    label: "<?php switch ($dataRow->fault_level) {
                                                    case 0:
                                                        echo '低';
                                                        break;
                                                    case 1:
                                                        echo '中';
                                                        break;
                                                    case 2:
                                                        echo '高';
                                                        break;
                                                } ?>",
                    data: "<?= $dataRow->level_cnt ?>",
                    color: "#"+("00000"+((Math.random()*16777215+0.5)>>0).toString(16)).slice(-6)
                },
                <?php endforeach; ?>
            ];
            <?php endif; ?>

            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });

        };
        <?php break; ?>
        <?php case 2: ?>
        window.onload = function () {
            <?php if($barData!=null): ?>
            var ticks = [
                [0,'草稿'],[1,'待审核'],[2,'待定位'],[3,'待修改'],[4,'待验证'],[5,'待完成'],[6,'已完成'],[7,'未过申'],[8,'已挂起'],[9,'定位失败'],[10,'修改失败'],[11,'验证失败']
            ];
            <?php else: ?>
            var ticks = [
            ];
            <?php endif; ?>
            var barOptions = {
                series: {
                    bars: {

                        show: true,
                        barWidth: 0.6,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.8
                            }, {
                                opacity: 0.8
                            }]
                        }
                    }
                },
                xaxis: {
                    //tickDecimals: 0
                    ticks: ticks
                },
                colors: ["#1ab394"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: "<?= $xy==null?'x':$xy['x'] ?>:%x,<?= $xy==null?'x':$xy['y'] ?>:%y"
                }
            };
            var barData = {
                label: "bar",
                data: [
                    <?php if($barData!=null): ?>
                    <?php foreach($barData->result() as $dataRow): ?>
                    [<?= $dataRow->fault_status ?>, <?= $dataRow->status_cnt ?>],
                    <?php endforeach; ?>
                    <?php endif; ?>
                ],
            };
            $.plot($("#flot-bar-chart"), [barData], barOptions);

            <?php if($barData==null):?>
            var data = [];
            <?php else: ?>
            var data = [
                <?php foreach($barData->result() as $dataRow): ?>
                {
                    label: "<?php switch ($dataRow->fault_status) {
                                                        case 0:
                                                            echo '草稿';
                                                            break;
                                                        case 1:
                                                            echo '待审核';
                                                            break;
                                                        case 2:
                                                            echo '待定位';
                                                            break;
                                                        case 3:
                                                            echo '待修改';
                                                            break;
                                                        case 4:
                                                            echo '待验证';
                                                            break;
                                                        case 5:
                                                            echo '待完成';
                                                            break;
                                                        case 6:
                                                            echo '已完成';
                                                            break;
                                                        case 7:
                                                            echo '未过申';
                                                            break;
                                                        case 8:
                                                            echo '已挂起';
                                                            break;
                                                        case 9:
                                                            echo '定位失败';
                                                            break;
                                                        case 10:
                                                            echo '修改失败';
                                                            break;
                                                        case 11:
                                                            echo '验证失败';
                                                            break;
                                                    } ?>",
                    data: "<?= $dataRow->status_cnt ?>",
                    color: "#"+("00000"+((Math.random()*16777215+0.5)>>0).toString(16)).slice(-6)
                },
                <?php endforeach; ?>
            ];
            <?php endif; ?>

            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });

        };
        <?php break; ?>
        <?php default:break; ?>
        <?php endswitch; ?>        <?php switch($type['type']):case 0:?>
        window.onload = function () {
            <?php if($barData!=null): ?>
            var ticks = [
                <?php $count=0; ?>
                <?php foreach($barData->result() as $dataRow): ?>
                [<?= $count ?>,'<?= $this->User_model->get_account_by_id($dataRow->creator_id) ?>'],
                <?php $count++; ?>
                <?php endforeach; ?>
            ];
            <?php else: ?>
            var ticks = [
            ];
            <?php endif; ?>
            var barOptions = {
                series: {
                    bars: {

                        show: true,
                        barWidth: 0.6,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.8
                            }, {
                                opacity: 0.8
                            }]
                        }
                    }
                },
                xaxis: {
                    //tickDecimals: 0
                    ticks: ticks
                },
                colors: ["#1ab394"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: "<?= $xy==null?'x':$xy['x'] ?>:%x,<?= $xy==null?'x':$xy['y'] ?>:%y"
                }
            };
            var barData = {
                label: "bar",
                data: [
                    <?php if($barData!=null): ?>
                    <?php $count=0; ?>
                    <?php foreach($barData->result() as $dataRow): ?>
                    [<?= $count ?>, <?= $dataRow->creator_cnt ?>],
                    <?php $count++; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                ],
            };
            $.plot($("#flot-bar-chart"), [barData], barOptions);

            <?php if($barData==null):?>
            var data = [];
            <?php else: ?>
            var data = [
                <?php foreach($barData->result() as $dataRow): ?>
                {
                    label: "<?= $this->User_model->get_account_by_id($dataRow->creator_id) ?>",
                    data: "<?= $dataRow->creator_cnt ?>",
                    color: "#"+("00000"+((Math.random()*16777215+0.5)>>0).toString(16)).slice(-6)
                },
                <?php endforeach; ?>
            ];
            <?php endif; ?>

            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });

        };
        <?php break; ?>
        <?php case 1: ?>
        window.onload = function () {
            <?php if($barData!=null): ?>
            var ticks = [
                [0,'低'],[1,'中'],[2,'高'],
            ];
            <?php else: ?>
            var ticks = [
            ];
            <?php endif; ?>
            var barOptions = {
                series: {
                    bars: {

                        show: true,
                        barWidth: 0.6,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.8
                            }, {
                                opacity: 0.8
                            }]
                        }
                    }
                },
                xaxis: {
                    //tickDecimals: 0
                    ticks: ticks
                },
                colors: ["#1ab394"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: "<?= $xy==null?'x':$xy['x'] ?>:%x,<?= $xy==null?'x':$xy['y'] ?>:%y"
                }
            };
            var barData = {
                label: "bar",
                data: [
                    <?php if($barData!=null): ?>
                    <?php foreach($barData->result() as $dataRow): ?>
                    [<?= $dataRow->fault_level ?>, <?= $dataRow->level_cnt ?>],
                    <?php endforeach; ?>
                    <?php endif; ?>
                ],
            };
            $.plot($("#flot-bar-chart"), [barData], barOptions);

            <?php if($barData==null):?>
            var data = [];
            <?php else: ?>
            var data = [
                <?php foreach($barData->result() as $dataRow): ?>
                {
                    label: "<?php switch ($dataRow->fault_level) {
                                                    case 0:
                                                        echo '低';
                                                        break;
                                                    case 1:
                                                        echo '中';
                                                        break;
                                                    case 2:
                                                        echo '高';
                                                        break;
                                                } ?>",
                    data: "<?= $dataRow->level_cnt ?>",
                    color: "#"+("00000"+((Math.random()*16777215+0.5)>>0).toString(16)).slice(-6)
                },
                <?php endforeach; ?>
            ];
            <?php endif; ?>

            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });

        };
        <?php break; ?>
        <?php case 2: ?>
        window.onload = function () {
            <?php if($barData!=null): ?>
            var ticks = [
                [0,'草稿'],[1,'待审核'],[2,'待定位'],[3,'待修改'],[4,'待验证'],[5,'待完成'],[6,'已完成'],[7,'未过申'],[8,'已挂起'],[9,'定位失败'],[10,'修改失败'],[11,'验证失败']
            ];
            <?php else: ?>
            var ticks = [
            ];
            <?php endif; ?>
            var barOptions = {
                series: {
                    bars: {

                        show: true,
                        barWidth: 0.6,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.8
                            }, {
                                opacity: 0.8
                            }]
                        }
                    }
                },
                xaxis: {
                    //tickDecimals: 0
                    ticks: ticks
                },
                colors: ["#1ab394"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: "<?= $xy==null?'x':$xy['x'] ?>:%x,<?= $xy==null?'x':$xy['y'] ?>:%y"
                }
            };
            var barData = {
                label: "bar",
                data: [
                    <?php if($barData!=null): ?>
                    <?php foreach($barData->result() as $dataRow): ?>
                    [<?= $dataRow->fault_status ?>, <?= $dataRow->status_cnt ?>],
                    <?php endforeach; ?>
                    <?php endif; ?>
                ],
            };
            $.plot($("#flot-bar-chart"), [barData], barOptions);

            <?php if($barData==null):?>
            var data = [];
            <?php else: ?>
            var data = [
                <?php foreach($barData->result() as $dataRow): ?>
                {
                    label: "<?php switch ($dataRow->fault_status) {
                                                        case 0:
                                                            echo '草稿';
                                                            break;
                                                        case 1:
                                                            echo '待审核';
                                                            break;
                                                        case 2:
                                                            echo '待定位';
                                                            break;
                                                        case 3:
                                                            echo '待修改';
                                                            break;
                                                        case 4:
                                                            echo '待验证';
                                                            break;
                                                        case 5:
                                                            echo '待完成';
                                                            break;
                                                        case 6:
                                                            echo '已完成';
                                                            break;
                                                        case 7:
                                                            echo '未过申';
                                                            break;
                                                        case 8:
                                                            echo '已挂起';
                                                            break;
                                                        case 9:
                                                            echo '定位失败';
                                                            break;
                                                        case 10:
                                                            echo '修改失败';
                                                            break;
                                                        case 11:
                                                            echo '验证失败';
                                                            break;
                                                    } ?>",
                    data: "<?= $dataRow->status_cnt ?>",
                    color: "#"+("00000"+((Math.random()*16777215+0.5)>>0).toString(16)).slice(-6)
                },
                <?php endforeach; ?>
            ];
            <?php endif; ?>

            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });

        };
        <?php break; ?>
        <?php default:break; ?>
        <?php endswitch; ?>


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
                <?php if ($this->session->userdata('user_authority') == 0): ?>
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
                        <?php if ($this->session->userdata('user_authority') == 0 || $this->session->userdata('user_authority') == 1): ?>
                            <li><a href="<?= site_url('FaultManage/Fault/addFault') ?>">缺陷报告</a></li>
                            <li><a href="<?= site_url('FaultManage/Fault/watchMyFault') ?>">我的缺陷</a></li>
                        <?php endif; ?>
                        <li><a href="<?= site_url('FaultManage/FaultShow') ?>">缺陷查询</a></li>

                        <li><a href="<?= site_url('FaultManage/FaultShow/showStatistic') ?>">缺陷统计</a></li>
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
                <h2>缺陷统计</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">首页</a>
                    </li>
                    <li>
                        <a>缺陷管理</a>
                    </li>
                    <li class="active">
                        <strong>缺陷统计</strong>
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="ibox-content m-b-sm border-bottom">
                <form action="<?= site_url('FaultManage/FaultShow/generateStat') ?>" method="post">
                    <div class="row"><!-- col-md-offset-1 -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">项目ID</label>
                                <select name="projectID" id="status" class="form-control">
                                    <?php foreach ($project->result() as $projectRow): ?>
                                        <option
                                            value="<?= $projectRow->project_id ?>"><?= $projectRow->project_id ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label ">统计条件</label>
                                <select name="type" id="status" class="form-control">
                                    <option value="0" selected>创建人</option>
                                    <option value="1">严重程度</option>
                                    <option value="2">缺陷状态</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label invisible">X</label>

                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        搜索
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>柱状图</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-bar-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>饼图</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-pie-content" id="flot-pie-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                 <div class="col-lg-6">
                     <div class="ibox float-e-margins">
                         <div class="ibox-title">
                             <h5>折线图</h5>
                             <div class="ibox-tools">
                                 <a class="collapse-link">
                                     <i class="fa fa-chevron-up"></i>
                                 </a>
                                 <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                     <i class="fa fa-wrench"></i>
                                 </a>
                                 <ul class="dropdown-menu dropdown-user">
                                     <li><a href="#">设置 1</a>
                                     </li>
                                     <li><a href="#">设置 2</a>
                                     </li>
                                 </ul>
                                 <a class="close-link">
                                     <i class="fa fa-times"></i>
                                 </a>
                             </div>
                         </div>
                         <div class="ibox-content">

                             <div class="flot-chart">
                                 <div class="flot-chart-content" id="flot-line-chart"></div>
                             </div>
                         </div>
                     </div>
                 </div>
                <div class="col-lg-6">
                     <div class="ibox float-e-margins">
                         <div class="ibox-title">
                             <h5>实时图</h5>
                             <div class="ibox-tools">
                                 <a class="collapse-link">
                                     <i class="fa fa-chevron-up"></i>
                                 </a>
                                 <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                     <i class="fa fa-wrench"></i>
                                 </a>
                                 <ul class="dropdown-menu dropdown-user">
                                     <li><a href="#">设置 1</a>
                                     </li>
                                     <li><a href="#">设置 2</a>
                                     </li>
                                 </ul>
                                 <a class="close-link">
                                     <i class="fa fa-times"></i>
                                 </a>
                             </div>
                         </div>
                         <div class="ibox-content">

                             <div class="flot-chart">
                                 <div class="flot-chart-content" id="flot-line-chart-moving"></div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>-->
            <!--<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>组合曲线图 </h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">设置 1</a>
                                    </li>
                                    <li><a href="#">设置 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-line-chart-multi"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
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
<!--<script src="<? /*= base_url('assets/js/inspinia.js')  */ ?>"></script>
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


<!-- Flot -->
<script src="<?= base_url('assets/js/plugins/flot/jquery.flot.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/flot/jquery.flot.tooltip.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/flot/jquery.flot.resize.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/flot/jquery.flot.pie.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/flot/jquery.flot.time.js') ?>"></script>

<!-- Custom and plugin javascript -->
<!--<script src="<? /*= base_url('assets/js/inspinia.js') */ ?>"></script>
-->
<script src="<?= base_url('assets/js/plugins/pace/pace.min.js') ?>"></script>

<!-- Flot demo data -->
<!--<script src="<? /*= base_url('assets/js/demo/flot-demo.js') */ ?>"></script>
-->


</body>

</html>
