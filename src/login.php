<?php

require_once 'config/config.php';
require_once BASE_PATH . '/lib/OauthServerConnector/OauthServerConnector.php';
session_start();

if(!isset($_SESSION["callback"]) ||
    !isset($_SESSION["clientId"]) ||
    !isset($_SESSION["clientSecret"])
)
    die("Missing session parameters");

if (!isset($_SESSION['oauthServerConnector']))
    $_SESSION["oauthServerConnector"] = new OauthServerConnector($_SESSION["clientId"], $_SESSION["clientSecret"]);

$clientInfo = null;
try {
    $clientInfo = $_SESSION["oauthServerConnector"]->getClientInfo();
    $_SESSION["client_name"] = $clientInfo["data"][0]["nome"];

} catch(Exception $e) {
    $httpCode = $e->getCode();
    $error = $e->getMessage();

    $_SESSION["oauthServerConnector"]->debug($httpCode . " " . $error);
}


?>

<!DOCTYPE html>
<html lang="en">
<title>Oauth - Login</title>
<?php include './includes/head.php'; ?>

<body class="login-page" style="min-height: 512.391px;">
<div class="login-box">

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Accedi con le tue credenziali</p>

            <form method="POST" action="authenticate.php">
                <div class="input-group mb-3">
                    <input type="email" name="username" class="form-control" placeholder="Username" required="required" value="user@company.com">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="required" value="user">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </div>

            </form>

            <?php if (isset($_SESSION['login_failure'])): ?>
                <br>
                <div class="text-center mb-3">
                    <div class="card-body p-0">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php
                            echo $_SESSION['login_failure'];
                            unset($_SESSION['login_failure']);
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>