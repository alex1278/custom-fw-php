<!--<code>--><?//=__FILE__?><!--</code>-->
<?php
/**
 * Основной принцип работы фреймворка: Одна страница - один контроллер - один конкретный экшен
 * */
 ?>
<div class="container">
    <div id="answer"></div>
    <button id="send">Button Ajax</button>
    <br>
    <?php new \fw\widgets\menu\Menu([
//        'tpl' => WWW . '/menu/my_menu.php',
        'tpl' => WWW . '/menu/select.php',
        'container' => 'select',
        'class' => 'my_menu',
        'table' => 'categories',
        'cache' => 60,
        'cacheKey' => 'menu_select',
    ]);
    ?>
    <br>
    <?php new \fw\widgets\menu\Menu([
        'tpl' => WWW . '/menu/my_menu.php',
//        'tpl' => WWW . '/menu/select.php',
        'container' => 'ul',
        'class' => 'my_menu',
        'table' => 'categories',
        'cache' => 60,
        'cacheKey' => 'menu_ul',
    ]);
    ?>
    <?php if (!empty($posts)):?>
    <?php foreach ($posts as $post):?>
        <div class="panel panel-default">
            <div class="panel-heading"><?=$post['title']?></div>
            <div class="panel-body">
                <?=$post['text']?>
            </div>
        </div>
    <?php endforeach;?>
    <?php endif; ?>
</div>
<script src="/js/test.js"></script>
<script>
    $(function(){
        $('#send').click(function(){
            $.ajax({
                url: '/main/test', // controller - main, шаблон - default, экшен - test
                type: 'post',
                data: {'id' : 2},
                success: function(res){
//                    var data = JSON.parse(res);
//                    $('#answer').html('<p>Ответ: '+data.answer+ ' | Код: '+ data.code+'</p>');
                    $('#answer').html(res);
                    console.log(res);
                },
                error: function(){
                    alert('Error!');
                }
            });
        });

    });
</script>