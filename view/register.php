<?php // if ($_POST) print_r($_POST); ?>
<main>
    <?php
    //if (isset($registration))
    if (2<1)
    {
        echo "<pre>";
        print_r($registration);
        echo "</pre>";
    }
    else
    { ?>
        <div class="container">
            <h2 class="mt-4">Registrierung</h2>
            <p>... und noch irgendein Text.</p>
            <form action="/register/" method="post">
                <div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-header p-5 pb-4 border-bottom-0">
                                <!-- <h5 class="modal-title">Modal title</h5> -->
                                <h2 class="fw-bold mb-0">Registriere dich kostenlos</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body p-5 pt-0">
                                <form action="/register" method="POST" id="" class="">
                                    <input class="" type="hidden" name="action" id="actionRegister" value="doRegister">
                                    <div class="form-floating mb-3">
                                        <input type="text" id="vorname" name="vorname" class="form-control rounded-3" placeholder="Vorname">
                                        <label for="vorname">Vorname</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" id="nachname" name="nachname" class="form-control rounded-3" placeholder="Nachname">
                                        <label for="nachname">Nachname</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" id="login" name="login" class="form-control rounded-3" placeholder="Benutzername - mind. 5 Zeichen">
                                        <label for="login">Benutzername (mind. 5 Zeichen)</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" id="email" name="email" class="form-control rounded-3" placeholder="Email">
                                        <label for="email">Email</label>
                                    </div>
                                    <button id="button" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" disabled>
                                        Registrieren
                                    </button>
                                    <small class="text-muted">By clicking Sign up, you agree to the terms of
                                        use.</small>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            <h2 class="mt-4">Full width, single column</h2>
            <p class="text-warning">
                No grid classes are necessary for full-width elements.
            </p>
        </div>
        <script src="/js/register.js"></script>
    <?php } ?>
</main>
