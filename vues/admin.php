<!DOCTYPE html>
<html>
    <head>
        <?php require($rep.$vues['head']); ?>
        <title>Admin</title>
        <script src="js/admin.js"></script>
    </head>
    <body>
        <?php require($rep.$vues['nav']); ?>
        <div class="card shadow" id="flux-card">
            <h3>RSS feeds</h3>
            <?php
                if (isset($listFlux)) {
                    if (empty($listFlux)) {
                        echo '<h1>Pas de flux</h1>';
                    }
                    echo "<ul class='list-group'>";
                    foreach ($listFlux as $flux) {
                        ?>
                        <li class="list-group-item d-flex flex-row align-items-center flux-el">
                            <?= $flux->getName() ?>
                            <a href="<?= $flux->getUrl() ?>"><?= $flux->getUrl() ?></a>
                            <button class="btn btn-danger btn-del d-flex flex-row align-items-center" onclick="deleteFeed('<?= $flux->getUrl() ?>');">
                                <i class="material-icons">delete_forever</i>
                            </button>
                        </li>
                        <?php
                    }
                    echo "</ul>";
                }
                ?>
            <div class="card form-card">
                <h4>Add feed</h4>
                <form class="form-inline d-flex justify-content-between" action="index.php?action=addFeed" method="post">
                    <input class="form-control" type="text" name="name" placeholder="Feed name" size="30" autocomplete="off" required>
                    <input class="form-control" column type="url" name="url" placeholder="url (ex : http://example.com/rss)" size="60" autocomplete="off" required>
                    <button type="submit" class="btn btn-primary">add</button>
                </form>
            </div>
        </div>
        <div class="card shadow" id="setting-card">
            <h3>Settings</h3>
            <div class="card form-card">
                <h4>Number of news per page</h4>
                <form class="form-inline d-flex justify-content-between" action="index.php?action=setNbNewsPerPage" method="post">
                    <input class="form-control" type="number" name="nbNews" id="nbNews" value="<?=(isset($nbNewsPerPage))? $nbNewsPerPage : 10 ?>" required>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </body>
</html>
