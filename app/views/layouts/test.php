<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test - No Menu | <?=$title?></title>

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
    <h1>Test Layout | Без главного меню</h1>
    <?=$content?>


    <!--query debugger-->
    <?//=debug(\vendor\core\Db::$countSql)?>
    <?//=debug(\vendor\core\Db::$queries)?>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>