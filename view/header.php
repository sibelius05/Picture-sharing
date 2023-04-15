<?php  ?>
<header class="masthead">
    <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                    <h4 class="text-white">halbanalog.info</h4>
                    <p class="text-muted">Hier sind alle Informationen.</p>
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                    <h4 class="text-white">Kontakt</h4>
                    <ul class="list-unstyled">
                        <li><a href="/paris" class="text-white">Paris</a></li>
                        <li><a href="/rom" class="text-white">Rom</a></li>
                        <li><a href="/siena" class="text-white">Siena</a></li>
                        <li><a href="/florenz" class="text-white">Florenz</a></li>
                    </ul>
                    <?php if (isset($_SESSION['userId'])) { ?>
                    <ul class="list-unstyled">
                        <li><a href="/logout" class="text-white">Logout</a></li>
                    </ul>
                    <?php } ?>
                </div>
            </div>
            <?php if (empty($_SESSION['userId']) && $_GET['alias'] != 'register') { ?>
            <div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header p-5 pb-4 border-bottom-0">
                            <!-- <h5 class="modal-title">Modal title</h5> -->
                            <h2 class="fw-bold mb-0">Melde dich kostenlos an</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-5 pt-0">
                            <form action="index.php" method="POST" id="" class="">
                                <input class="" type="hidden" name="action" id="action" value="doLogin">
                                <div class="form-floating mb-3">
                                    <input type="text" name="login" class="form-control rounded-3" id="floatingInput" placeholder="Benutzername">
                                    <label for="floatingInput">Benutzername</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" class="form-control rounded-3" id="floatingPassword" placeholder="Passwort">
                                    <label for="floatingPassword">Passwort</label>
                                </div>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Melde dich an</button>
                                <small class="text-muted">By clicking Sign up, you agree to the terms of use.</small>
                                <a href="/register">Registrierung</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
                <strong>halbanalog.de</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
    <?php if (empty($_GET['alias'])) { ?>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <h1 class="fw-light">Vertically Centered Masthead Content</h1>
                <p class="lead">A great starter layout for a landing page</p>
            </div>
        </div>
    </div>
    <?php } ?>
</header>


