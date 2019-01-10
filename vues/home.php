<!DOCTYPE html>
<html>
    <head>
        <?php require($rep.$vues['head']); ?>
        <title>Home</title> 
    </head>
    <body>
        <?php require($rep.$vues['nav']); ?>
        <div class="d-flex flex-wrap news justify-content-around">
        <?php
            if (isset($listNews)) {
                if (empty($listNews)) {
                    echo '<h1>Pas de news</h1>';
                }
                foreach ($listNews as $news) {
                    ?>
                    <a href="<?= $news->getUrl() ?>" class="shadow card">
                        <div class="info">
                            <span><?= $news->getWebsite() ?></span>
                            <br>
                            <span><?= $news->getDate() ?></span>
                        </div>
                        <?php if ($news->getImage()): ?>
                            <img class="card-img-top" src="<?= $news->getImage() ?>" alt="Card image cap">
                        <?php endif ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $news->getTitle() ?></h5>
                            <p class="card-text ellipsis"><?= $news->getDescription() ?></p>
                        </div>
                        <div class="grad"></div>
                    </a>
                <?php
                }
            }
            ?>
        </div>
        <div class="d-flex justify-content-center" id="pagination">
            <div class="btn-group" role="group">
            <?php if ($previousPage): ?>
                <a href="index.php?page=<?= $previousPage ?>"><button type="button" class="btn btn-primary">Précédent</button></a>
            <?php endif ?>
            <?php if ($nextPage): ?>
                <a href="index.php?page=<?= $nextPage ?>"><button type="button" class="btn btn-primary">Suivant</button></a>
            <?php endif ?>
            </div>
        </div>
    </body>
</html>
