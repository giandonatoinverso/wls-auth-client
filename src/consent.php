<?php

require_once 'config/config.php';
require_once BASE_PATH . '/lib/OauthServerConnector/OauthServerConnector.php';
session_start();

if(!isset($_SESSION["callback"]) ||
    !isset($_SESSION["clientId"]) ||
    !isset($_SESSION["clientSecret"]) ||
    !isset($_SESSION["client_name"]) ||
    !isset($_SESSION["username"]) ||
    !isset($_SESSION["userInfoToken"])
)
    die("Missing session parameters");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST["allow"])) {
        $authorizationCode = null;
        try {
            $authorizationCode = $_SESSION["oauthServerConnector"]->getAuthorizationCode($_SESSION["userInfoToken"]);

            $url = base64_decode($_SESSION["callback"]) . "?username=" . base64_encode($_SESSION["username"]) . "&authorizationCodeEncoded=" . base64_encode($authorizationCode["data"]);

            header('Location: ' . $url);
            exit;

        } catch(Exception $e) {
            $httpCode = $e->getCode();
            $error = $e->getMessage();

            $_SESSION['consent_failure'] = $httpCode . " " . $error;
            header('Location: consent.php');
            exit;
        }
    }

    if(isset($_POST["deny"])) {
        $url = base64_decode($_SESSION["callback"]) . "?deny=true";

        header('Location: ' . $url);
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<title>Oauth - Consent page</title>
<?php include './includes/head.php'; ?>

<body class="login-page" style="min-height: 512.391px;">
<div class="login-box" style="width: 560px !important;">

    <div class="card card-outline">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>Consent page</b></a>
        </div>
        <div class="card-body">
            <p class="mb-1">
                <strong><?php echo $_SESSION["client_name"];?></strong> vorrebbe accedere alle seguenti informazioni su di te:
            </p>
            <ul class="mb-1">
                <li>Dati anagrafici (nome, cognome, username)</li>
                <li>Scopes (privilegi)</li>
            </ul>
            <br>
            <form action="consent.php" method="post">
                <input type="hidden" name="allow" class="form-control" value="true">
                <button type="submit" class="btn btn-primary btn-block">Allow</button>
            </form>
            <br>
            <form action="consent.php" method="post">
                <input type="hidden" name="deny" class="form-control" value="true">
                <button type="submit" class="btn btn-danger btn-block">Deny</button>
            </form>

            <?php if (isset($_SESSION['consent_failure'])): ?>
                <br>
                <div class="text-center mb-3">
                    <div class="card-body p-0">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php
                            echo $_SESSION['consent_failure'];
                            unset($_SESSION['consent_failure']);
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>