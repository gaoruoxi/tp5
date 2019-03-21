<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"D:\xampp\htdocs\thinkphp_5.0.24\public/../application/index\view\site\site_count.html";i:1553046238;s:70:"D:\xampp\htdocs\thinkphp_5.0.24\application\index\view\index\meta.html";i:1553137612;s:72:"D:\xampp\htdocs\thinkphp_5.0.24\application\index\view\index\footer.html";i:1553137612;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="Bookmark" href="/favicon.ico">
    <link rel="Shortcut Icon" href="/favicon.ico"/>
    <script type="text/javascript" src="/public/static/h-ui/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/public/static/h-ui/lib/respond.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/static/h-ui/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/public/static/h-ui/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/public/static/h-ui/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/public/static/h-ui/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/public/static/h-ui/static/h-ui.admin/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/public/static/laydate/theme/default/laydate.css"/>

    <script type="text/javascript" src="/public/static/h-ui/lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script type="text/javascript" src="/public/static/h-ui/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/public/static/laydate/laydate.js"></script>
    <script>DD_belatedPNG.fix('*');</script>

<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i>
    首页
    <span class="c-gray en">&gt;</span>
    站点管理
    <span class="c-gray en">&gt;</span>
    站点路线统计列表
    <a class="btn btn-success radius r" style="line-height: 1.6em; margin-top: 3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<div class="page-container">
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="60">ID</th>
                <th>适用时间(开车时间)</th>
                <th>发布时间</th>
                <th>修改截止时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $k=>$v): ?>
            <tr>
                <td style="text-align: center;"><?php echo $v['id']; ?></td>
                <td style="text-align: center;"><?php echo $v['apply_time']; ?></td>
                <td style="text-align: center;"><?php echo $v['add_time']; ?></td>
                <td style="text-align: center;"><?php echo $v['end_time']; ?></td>
                <td style="text-align: center;">
                    <!--<a href="javascript:;" onclick="delSiteLine(<?php echo $v['id']; ?>)">删除</a>-->
                    <a href="javascript:;" onclick="querySiteLine(<?php echo $v['id']; ?>)">详情</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" src="/static/h-ui//lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script>
    //详情弹窗
    function querySiteLine(id) {
        var title = '站点线路统计详情';
        var url = "<?php echo url('/index/site/querysitelinecountinfo'); ?>?id="+id;
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    //删除站点路线
    function delSiteLine(id) {
        var url = "<?php echo url('/index/site/delsiteline'); ?>";
        $.ajax({
            url: url,
            data: {
                'id': id
            },
            dataType: 'json',
            type: 'POST',
            success: function (data) {
                layer.msg(data.msg);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        });
    }
</script>
<script type="text/javascript" src="/public/static/h-ui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/public/static/h-ui/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/public/static/h-ui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/public/static/h-ui/static/h-ui.admin/js/H-ui.admin.js"></script>
