<?php ini_set('display_errors', 1); ?>
<?php $users = User::getAllUsersHavingNotActivatedPictures();

echo "<pre>";
//print_r ($users);
echo "</pre>";

?>
    <main>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row row-cols-1 g-3">
                    <?php $count = 1;

                    $count0 = 1;

                    for ($i = 0; $i < count($users); $i++)
                    { ?>
                        <nav class="navbar navbar-light" style="background-color: #e3f2fd;" aria-label="First navbar example">
                            <div class="container-fluid">
                                <a class="navbar-brand" href="#"><?php echo $users[$i]->getFirstname() . " " . $users[$i]->getLastname(); ?></a>
                                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar<?php echo $count; ?>" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="navbar-collapse collapse" id="navbar<?php echo $count++; ?>" style="">
                                    <ul class="navbar-nav me-auto mb-2">
                                        <li class="nav-item">
                                            <a class="nav-link active">Vorname: <?php echo $users[$i]->getFirstname(); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active">Nachname: <?php echo $users[$i]->getLastname(); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active">Geburtsdatum: <?php echo $users[$i]->getBirthday(); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active">Geschlecht: <?php echo $users[$i]->getGender(); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active">Username: <?php echo $users[$i]->getUsername(); ?></a>
                                        </li>
                                        <?php if ($users[$i]->getAlleRollen() && count($users[$i]->getAlleRollen()) > 0) { ?>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Rollen</a>
                                                <ul class="dropdown-menu">
                                                    <?php foreach ($users[$i]->getAlleRollen() as $rolle) { ?>
                                                        <li><?php echo $rolle->getName(); ?></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <nav class="navbar navbar-light mt-0" style="background-color: #e3f2fd;" aria-label="First navbar example">
                            <div class="container-fluid">
                                <a class="navbar-brand" href="#"></a>
                                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1_<?php echo $i . '_' . $count0; ?>" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="navbar-collapse collapse" id="navbar1_<?php echo $i . '_' . $count0++; ?>" style="">
                                    <div class="album py-5 bg-light">
                                        <div class="container">

                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                                                <?php
                                                $pictures = Bilder::erstelleArray($users[$i]->getId(), false);

                                                $count1 = 1;

                                                for ($j = 0; $j < count($pictures); $j++)
                                                { ?>
                                                    <div class="col">
                                                        <div class="card shadow-sm">
                                                            <img loading="lazy" id="img_<?php echo $pictures[$j]->getId(); ?>" data-source="<?php echo $pictures[$j]->getNameBild(); ?>" data-id="<?php echo $users[$i]->getId(); ?>_<?php echo $pictures[$j]->getId(); ?>" class="bd-placeholder-img" src="/images/400/<?php echo $pictures[$j]->getNameBild() . "\" alt=\"" . $pictures[$j]->getNameBild() ?>" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"/>
                                                            <div class="card-body">
                                                                <p class="card-text"><?php echo $pictures[$j]->getNameBild(); ?></p>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div class="btn-group" id="container0_<?php echo $users[$i]->getId(); ?>_<?php echo $pictures[$j]->getId(); ?>">
                                                                        <button type="button" id="<?php echo $users[$i]->getId(); ?>_<?php echo $pictures[$j]->getId(); ?>" class="btn btn-sm btn-outline-secondary" data-toggle="activatePic_<?php echo $users[$i]->getId(); ?>_<?php echo $pictures[$j]->getId(); ?>" data-state="inactive">
                                                                            Bild freischalten
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-lg modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen-xl-down">
                    <div class="modal-content">
                        <div class="modal-header pt-1 pb-1">
                            <h6 class="modal-title" id="exampleModalLabel"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img style="height: auto;" loading="lazy" id="img_modal" data-source="" class="bd-placeholder-img card-img-top" alt="" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"/>                        </div>
                        <div class="modal-footer pt-1 pb-0">
                            <button id="btn-close" type="button" class="btn btn-secondary btn-sm mt-0 mb-0" data-bs-dismiss="modal">Ansicht schließen</button>
                            <div class="btn-group" id="container1">
                            <button type="button" class="btn btn-primary btn-sm mt-0 mb-0">Bild freischalten</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="/js/activatePictures.js"></script>
        </div>
    </main>
<?php
