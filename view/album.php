<?php ?>
<main>
    <?php
    $isUser = false;

    if (isset($_SESSION['userId']))
    {
        $user = User::getById($_SESSION['userId']);

        $isUser = $user->isUser();
    }

    if ((isset($user) && $isUser) || (isset($user) && !$isUser && $user->getId() !== $n->getNavId()) || !$_SESSION)
    {
        ?>
        <section class="py-0 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light"><?php echo $n->getHeadline() ?></h1>
                    <?php
                    if (isset($_SESSION['successActivation']))
                    {
                        ?>
                        <p class="lead text-muted">Herzlichen Glückwunsch. Das hat ja gut geklappt.</p>
                        <?php
                        unset ($_SESSION['successActivation']);
                    }
                    ?>
                </div>
            </div>
        </section>
        <?php
    }
    else if (empty($user))
    {
        echo "Sitzung beendet!";
    }
    else if ($user->getId() === $n->getNavId())
    {
        ?>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Noch kein User</h1>
                    <div class="modal-body p-5 pt-0">
                        <form action="/<?php echo $user->getUsername(); ?>" method="POST" id="" class="">
                            <input class="" type="hidden" name="action" id="actionUpdate" value="doUpdate">
                            <input class="" type="hidden" name="userId" id="userId" value="<?php echo $user->getId(); ?>">
                            <div class="form-floating mb-3">
                                <select type="text" id="salutation" name="salutation" class="form-control rounded-3" placeholder="Anrede">
                                    <option value="f"<?php echo ($user->getGender() == 'f') ? " selected" : "" ?>>Frau
                                    </option>
                                    <option value="m"<?php echo ($user->getGender() == 'm') ? " selected" : "" ?>>Herr
                                    </option>
                                </select>
                                <label for="floatingInput">Anrede</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" id="firstname" name="firstname" class="form-control rounded-3" id="firstname" placeholder="Vorname" value="<?php echo $user->getFirstname(); ?>">
                                <label for="floatingInput">Vorname</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" id="nachname" name="lastname" class="form-control rounded-3" id="lastname" placeholder="Nachname" value="<?php echo $user->getLastname(); ?>">
                                <label for="floatingInput">Nachname</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" id="birthday" name="birthday" class="form-control rounded-3" id="birthday" placeholder="Geburtsdatum" value="<?php echo date('d.m.Y', strtotime($user->getBirthday())); ?>">
                                <label for="floatingInput">Geburtsdatum</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" id="email" name="email" class="form-control rounded-3" placeholder="Email" value="<?php echo $user->getEmail(); ?>">
                                <label for="floatingPassword">Email</label>
                            </div>
                            <button id="button" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">
                                Ändern
                            </button>
                            <small class="text-muted">By clicking Sign up, you agree to the terms of
                                use.</small>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }

   ?>
    <div class="album py-0 bg-light">
        <div class="container">
            <?php  if (isset ($user) && $user->getId() === $ui)
            { ?>
                <button type="button" class="btn btn-sm btn-outline-secondary mb-1">
                    <a href="/upload">neues Bild</a>
                </button>
            <?php } ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            for ($i = 0; $i < count($ausgabe); $i++)
            { ?>
                <div class="col">
                    <div id="col_<?php echo $ausgabe[$i]->getId() ?>" class="card shadow-sm">
                        <img loading="lazy" id="img_<?php echo $ausgabe[$i]->getId() ?>" class="mx-auto d-block" data-source="/images/source/<?php echo $ausgabe[$i]->getNameBild() . "\" alt=\"" . $ausgabe[$i]->getNameBild() ?>" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"/>
                        <div class="card-body">
                            <p class="card-text"><?php echo $ausgabe[$i]->getDescription() ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button id="opn_<?php echo $ausgabe[$i]->getId() ?>" type="button" class="btn btn-sm btn-outline-secondary">
                                        Öffnen
                                    </button>
                                    <?php if (isset ($user) && $user->getId() === $ui) { ?>
                                        <button id="dlt_<?php echo $ausgabe[$i]->getId() ?>" type="button" class="btn btn-sm btn-outline-secondary">
                                            Löschen
                                        </button>
                                        <?php if (!$ausgabe[$i]->isActive()) { ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-info">
                                                nicht freigeschaltet
                                            </button>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <small id="txt_<?php echo $ausgabe[$i]->getId() ?>" class="text-muted">&nbsp</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="modal fade" id="exampleModalXl" tabindex="-1" aria-labelledby="exampleModalXlLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="">
                            <div id="carouselExampleControls" class="carousel carousel-dark slide" data-bs-touch="false">
                                <div class="carousel-inner">
                                    <?php for ($i = 0; $i < count($ausgabe); $i++)
                                    { ?>
                                        <div id="item_<?php echo $ausgabe[$i]->getId() ?>" class="carousel-item <?php if ($i == 0) echo 'active' ?>">
                                            <div class="col">
                                                <div class="card shadow-sm">
                                                    <div id="loading-img_<?php echo $ausgabe[$i]->getId() ?>" class="mx-auto d-block" data-ratio="<?php echo $ausgabe[$i]->getRatio() ?>">
                                                        <img loading="lazy" id="imgCar_<?php echo $ausgabe[$i]->getId() ?>" class="mx-auto d-block" data-source="/images/source/<?php echo $ausgabe[$i]->getNameBild() . "\" alt=\"" . $ausgabe[$i]->getNameBild() ?>" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"/>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            Copyright: <?php echo $n->getHeadline() ?></p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="btn-group">
                                                                <?php if (isset ($user) && $user->getId() === $ui) { ?>
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                                                        Bearbeiten
                                                                    </button>
                                                                    <?php if (!$ausgabe[$i]->isActive()) { ?>
                                                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-info">
                                                                            nicht freigeschaltet
                                                                        </button>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                            <small class="text-muted"><?php echo $ausgabe[$i]->getNameBild() ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-black" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-black" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/album.js"></script>
</main><?php //Bilder::giveSizeAllImages("images/"); ?>