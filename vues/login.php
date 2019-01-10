<!DOCTYPE html>
<html>
<head>
    <?php require($rep . $vues['head']); ?>
    <title>Login</title>
</head>
<body>
<?php require($rep . $vues['nav']); ?>
<div class="d-flex justify-content-center align-items-center login-parent">
    <div class="card card-login shadow">
        <h2>Login</h2>
        <form action="index.php?action=login" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="username" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>
</body>
</html>
