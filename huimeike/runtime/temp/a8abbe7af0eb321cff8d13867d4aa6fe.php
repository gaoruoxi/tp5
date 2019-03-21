<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"D:\xampp\htdocs\huimeike\public/../application/index\view\login\login.html";i:1553137517;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/public/static/h-ui/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/public/static/h-ui/lib/respond.min.js"></script>
    <![endif]-->
    <link href="/public/static/h-ui/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="/public/static/h-ui/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css"/>
    <link href="/public/static/h-ui/static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/public/static/h-ui/lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="/public/static/h-ui/lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>后台登录</title>
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value=""/>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <form class="form form-horizontal" action="<?php echo url('login'); ?>" method="post">
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <input id="username" name="username" type="text" placeholder="账户" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <input id="password" name="password" type="password" placeholder="密码" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input class="input-text size-L" type="text" placeholder="验证码"
                           onblur="if(this.value==''){this.value='验证码:'}"
                           onclick="if(this.value=='验证码:'){this.value='';}" id="code"  name="code" value="验证码:" style="width:150px;">
                    <img src="<?php echo captcha_src(); ?>" width="145" id="code_img"> <a id="kanbuq"
                                                                              href="javascript:;">看不清，换一张</a></div>
            </div>
            <!--<div class="row cl">-->
                <!--<div class="formControls col-xs-8 col-xs-offset-3">-->
                    <!--<label for="online">-->
                        <!--<input type="checkbox" name="online" id="online" value="1">-->
                        <!--使我保持登录状态</label>-->
                <!--</div>-->
            <!--</div>-->
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input name="" type="submit" class="btn btn-success radius size-L"
                           value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                    <input name="" type="reset" class="btn btn-default radius size-L"
                           value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
                </div>
            </div>
        </form>
    </div>
</div>
<div id="modal-demo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content radius">
            <div class="modal-header">
                <h3 class="modal-title">对话框标题</h3>
                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
            </div>
            <div class="modal-body">
                <p>对话框内容…</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">确定</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
    </div>
</div>
<div class="footer">Copyright 你的公司名称</div>
<script type="text/javascript" src="/public/static/h-ui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/public/static/h-ui/static/h-ui/js/H-ui.min.js"></script>
<script>
    $('#kanbuq').on('click', function () {
        var url = "<?php echo captcha_src(); ?>?" + Math.random();
        $('#code_img').attr('src', url);
    })
    $('form').submit(function () {
        var username = $.trim($('#username').val());
        var password = $.trim($('#password').val());
        var code = $.trim($('#code').val());
        if (username == '') {
            modalalertdemo('账户不能为空');
            return false;
        }
        if (password == '') {
            modalalertdemo('密码不能为空');
            return false;
        }
        if (code == '') {
            modalalertdemo('验证码不能为空');
            return false;
        }
    });
    function modalalertdemo(msg) {
        $.Huimodalalert(msg, 2000)
    }
</script>
</body>
</html>