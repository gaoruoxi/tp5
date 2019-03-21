<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"D:\xampp\htdocs\thinkphp_5.0.24\public/../application/index\view\emp\index.html";i:1553128580;s:70:"D:\xampp\htdocs\thinkphp_5.0.24\application\index\view\index\meta.html";i:1553137612;s:72:"D:\xampp\htdocs\thinkphp_5.0.24\application\index\view\index\footer.html";i:1553137612;}*/ ?>
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
    员工管理
    <span class="c-gray en">&gt;</span>
    员工列表
    <a class="btn btn-success radius r" style="line-height: 1.6em; margin-top: 3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			<a class="btn btn-primary radius" onclick="addEmp()" href="javascript:;">
				<i class="Hui-iconfont">&#xe600;</i>
				员工信息导入
			</a>
            <a class="btn btn-primary radius" href="<?php echo url('/index/emp/expEmp'); ?>">
				<i class="Hui-iconfont">&#xe600;</i>
				员工密码导出
			</a>
             <a class="btn btn-primary radius" href="<?php echo url('/index/emp/addemp'); ?>">
				<i class="Hui-iconfont">&#xe600;</i>
				新增员工
			</a>
            <form action="<?php echo url('/index/emp/index'); ?>" style="display: inline-block;">
                姓名: <input type="text" class="input-text" name="name" value="<?php echo $name; ?>" style="width:150px" placeholder="输入员工名称"  >
                 手机号: <input type="text" class="input-text" name="phone" value="<?php echo $phone; ?>"  style="width:150px" placeholder="输入员工手机号"  >
        <button type="submit" class="btn btn-success"  name=""><i class="Hui-iconfont">&#xe665;</i> 搜员工</button>
                <button type="reset" class="btn btn-success" id="reset-btn"  name=""><i class="Hui-iconfont">&#xe665;</i> 重置</button>
            </form>

		</span>
    </div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="60">ID</th>
                <th>姓名</th>
                <th>性别</th>
                <th>联系电话</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $k=>$v): ?>
            <tr>
                <td style="text-align: center;"><?php echo $v['id']; ?></td>
                <td style="text-align: center;"><?php echo $v['name']; ?></td>
                <td style="text-align: center;"><?php echo $v['gender']; ?></td>
                <td style="text-align: center;"><?php echo $v['phone']; ?></td>
                <td style="text-align: center;"><a href="javascript:;" onclick="editPass(<?php echo $v['id']; ?>)">修改密码</a><a
                        href="<?php echo url('/index/emp/delemp',['id'=>$v['id']]); ?>" style="margin-left: 10px;">删除</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <style>
            .pagination{
                margin-top: 20px;
                text-align: center;
                clear: both;
            }
            .pagination li {
                float: left;
            }
            .pagination li a,.pagination li span{
                padding: 5px 10px;
                margin-left: 10px;

            }
            .pagination li a{
                background: #0e90d2;
                border: 1px solid #0e90d2;
                border-radius: 10px;
            }
        </style>
        <?php echo $data->render(); ?>
    </div>
</div>
<div id="layer_tip" style="display: none;text-align: center;margin-top: 10px;">
    <input type="text" style="width: 200px;" id="new_pass" class="input-text" placeholder="请输入新密码">
    <input class="btn btn-primary radius" type="button" onclick="edit()" value="修改">
    <input class="btn btn-primary radius" type="hidden" id="emp_id">
</div>
<script type="text/javascript" src="/static/h-ui//lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script>
    //导入弹窗
    function addEmp() {
        var title = '员工信息导入';
        var url = "<?php echo url('/index/emp/add'); ?>";
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    var layer_index;

    //修改密码弹窗
    function editPass(id) {
        var layer_tip = $('#layer_tip');
        //页面层
        layer_index = layer.open({
            type: 1,
            skin: 'layui-layer-rim', //加上边框
            area: ['420px', '140px'], //宽高
            content: layer_tip
        });
        $('.layui-layer-title').html('修改密码');
        $('#emp_id').val(id);
    }

    //修改密码
    function edit() {
        var editUrl = "<?php echo url('/index/emp/editPass'); ?>";
        var id = $('#emp_id').val();
        var pass = $('#new_pass').val();
        $.ajax({
            url: editUrl,
            data: {
                'id': id,
                'pass': pass
            },
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.result) {
                    layer.msg(data.msg);
                    //关闭弹窗
                    layer.close(layer_index);
                } else {
                    layer.msg(data.msg);
                }
            }
        });
    }
    $('#reset-btn').click(function () {
        window.location.href="<?php echo url('/index/emp/index'); ?>";
    });
</script>
<script type="text/javascript" src="/public/static/h-ui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/public/static/h-ui/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/public/static/h-ui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/public/static/h-ui/static/h-ui.admin/js/H-ui.admin.js"></script>
