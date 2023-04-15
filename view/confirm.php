<?php
$c = rawurldecode($_GET['alias']);

$arr = explode("|", Registration::executeActivationLink($c));

$login = $arr[0] ?? "";
$password = $arr[1] ?? "";

try
{
    $user = User::getUserByNameAndPasswrd($login, $password);

    if ($user)
    {
        $_SESSION['ID'] = $_COOKIE['PHPSESSID'] ?? session_id();

        $_SESSION['userId'] = $user->getId();

        $_SESSION['userName'] = $user->getUsername();

        $currentSession = new Session($_SESSION['ID'], $_SESSION['userName'], $_SESSION['userId'], time(), time(), 1);

        $currentSession->save();

        $loggedin = true;
        ?>
        <div class="container">
            <h2 class="mt-4">Registrierung</h2>
            <p>... und noch irgendein Text.</p>
            <div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-4 shadow">

                        <div class="modal-header p-5 pb-4 border-bottom-0">
                            <!-- <h5 class="modal-title">Modal title</h5> -->
                            <h2 class="fw-bold mb-0">Aktiviere deinen Account mit einem neuen Passwort</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-5 pt-0">
                            <form action="" method="POST" id="" class="">
                                <input class="" type="hidden" name="action" id="action" value="doActivate">
                                <div class="form-floating mb-3">
                                    <input type="text" id="login" name="login" class="form-control rounded-3" value="<?php echo $login ?>" placeholder="Benutzername">
                                    <label for="login">Benutzername</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" id="passwort0" name="passwortAlt" class="form-control rounded-3" value="" placeholder="Altes Passwort">
                                    <label for="passwort0">Altes Passwort</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" id="passwort1" name="passwortNeu" class="form-control rounded-3" placeholder="Neues Passwort">
                                    <label for="passwort1">Neues Passwort</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" id="passwort2" name="passwortWdh" class="form-control rounded-3" placeholder="Neues Passwort wiederholen">
                                    <label for="passwort2">Neues Passwort wiederholen</label>
                                </div>
                                <div id="zahl" class="fw-bold text-dark">mindestens 10</div>
                                <div id="erlaubt" class="fw-bold text-dark">erlaubte Zeichen:</div>
                                <div id="ziffern" class="fw-bold text-dark">0 - 1</div>
                                <div id="klein" class="fw-bold text-dark">a - z</div>
                                <div id="gross" class="fw-bold text-dark">A - Z</div>
                                <div id="spezial" class="fw-bold text-dark">! # $ % & ( ) * + , - . : ; / < > = ? @ ^ _
                                    { | } ~
                                </div>
                                <button id="button" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" disabled>
                                    Aktivierung
                                </button>
                                <small class="text-muted">By clicking Sign up, you agree to the terms of use.</small>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="/js/confirm.js"></script>
        <?php
    }
}
catch (Exception $e)
{
    ?>
    <div class="container">
        <h2 class="mt-4">Registrierung</h2>
        <p>... und noch irgendein Text.</p>
        <form action="/register/" method="post">
            <div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
                <div class="modal-dialog" role="document">
                    <?php
                    if ($login == '' || $password == '')
                    {
                        ?>
                        <h2 class="mt-4">Ungültiger oder bereits abgelaufener Link ...</h2>
                        <?php
                    }
                    else
                    {
                        if ($arr[0] == 0 || $arr[0] == 1)
                        {
                            if ($arr[0] == 1)
                            {
                                ?>
                                <h2 class="mt-4">Bereits aktivierter Link ...</h2>
                                <?php
                            }
                            else
                            {
                                ?>
                                <h2 class="mt-4">Bereits
                                    am <?php echo date('d.m.Y, H:i', intval($arr[1]) + DAYS_REGISTRATION * 86400); ?>
                                    Uhr abgelaufen</h2>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
    <?php
}

