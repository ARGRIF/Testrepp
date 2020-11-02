<header class="masthead" style="background-image: url('/public/materials/<?php echo $data['id']; ?>.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="page-heading">
                    <h1><?php echo htmlspecialchars($data['name'], ENT_QUOTES); ?></h1>
                    <span class="subheading"><?php echo htmlspecialchars($data['description'], ENT_QUOTES); ?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <p><?php echo htmlspecialchars($data['text'], ENT_QUOTES); ?></p>
        </div>
    </div>
</div>
<hr>

<div class="container mt-3">
    <div class="panel">
        <div class="panel-body">
            <form action="/post/<?php echo  htmlspecialchars($data['id'], ENT_QUOTES); ?>" method="post">
            <input class="form-control" type="text" placeholder=" Имя" name="author_name">
            <textarea class=" mar-top form-control" rows="2" placeholder=" Коментарий" name="comment"></textarea>

            <div class="mar-top clearfix">
                <button type="submit" class="btn btn-sm btn-primary pull-right" ><i class="fa fa-pencil fa-fw"></i> Добавить</button>
                <a class="btn btn-trans fa fa-camera add-tooltip" href="#"></a>

            </div>
            </form>
        </div>
    </div>

    <?php if (empty($comments_list)): ?>
        <p class="text-center" >Список коментариев пуст</p>
    <?php else: ?>
    <?php foreach ($comments_list as $val): ?>
    <div class="media">
        <img src="/public/icons/man.png" class="mr-3 mt-3 rounded-circle" style="width:60px;">
        <div class="media-body">
            <h4> <?php echo htmlspecialchars($val['author_name'], ENT_QUOTES); ?>
                <small>
                    <i>Posted on <?php echo htmlspecialchars($val['date'], ENT_QUOTES); ?> </i>
                </small>
            </h4>
            <p> <?php echo htmlspecialchars($val['comment'], ENT_QUOTES); ?> </p>
        </div>
    </div>

<?php endforeach; ?>
    <?php endif; ?>
</div>
