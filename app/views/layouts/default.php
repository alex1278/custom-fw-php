<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=\fw\core\base\View::getMeta()?>
    <!-- Bootstrap -->
    <link href="/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <ul class="nav nav-pills">
        <li role="presentation"><a href="/">Home</a></li>
        <li role="presentation"><a href="page/about">About</a></li>
        <li role="presentation"><a href="/admin">Admin</a></li>
        <li role="presentation"><a href="/user/signup">Signup</a></li>
        <li role="presentation"><a href="/user/login">Login</a></li>
        <li role="presentation"><a href="/user/logout">Logout</a></li>
    </ul>
    <?php if(!empty($menu)): ?>
<!--        --><?php //foreach($menu as $item): ?>
<!--            <li role="presentation"><a href="category/--><?//=$item['id']?><!--">--><?//=$item['title']?><!--</a></li>-->
<!--        --><?php //endforeach; ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?=$_SESSION['error']; unset($_SESSION['error']);?></div>
    <?php endif;?>
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?=$_SESSION['success']; unset($_SESSION['success']);?></div>
    <?php endif;?>

    <span>Default layout!</span>
    <h1>Hello, world!</h1>
<!--    --><?php //debug($_SESSION)?>
    <?=$content?>
</div>

<!--query debugger-->
<?//=debug(\vendor\core\Db::$countSql)?>
<?//=debug(\vendor\core\Db::$queries)?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<?php
    foreach($scripts as $script){
        echo $script;
    }
?>
</body>
</html>