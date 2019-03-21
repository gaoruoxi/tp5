<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"D:\xampp\htdocs\thinkphp_5.0.24\public/../application/index\view\index\welcome.html";i:1553138909;s:70:"D:\xampp\htdocs\thinkphp_5.0.24\application\index\view\index\meta.html";i:1553137612;}*/ ?>
﻿<!DOCTYPE HTML>
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

<title>我的桌面</title>
</head>
<body>
<div class="page-container">
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th colspan="7" scope="col">菜品信息统计</th>
        </tr>
        <tr class="text-c">
            <th>菜品名称</th>
            <th>票数</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($food as $v): ?>
        <tr class="text-c">
            <td><?php echo $v['name']; ?></td>
            <td><?php echo $v['counts']; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <table class="table table-border table-bordered table-bg" style="margin-top: 20px;">
        <thead>
        <tr>
            <th colspan="7" scope="col">站点信息统计</th>
        </tr>
        <tr class="text-c">
            <th>站点名称</th>
            <th>人数</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($site as $v): ?>
        <tr class="text-c">
            <td><?php echo $v['name']; ?></td>
            <td><?php echo $v['counts']; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>