<?php ini_set('display_errors', 1); ?>
<?php $users = User::getAllAsObjects();

echo "<pre>";
//print_r ($users);
echo "</pre>";

?>
    <main>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row row-cols-1 g-3">
                    <?php $count = 1;

                    for ($i = 0; $i < count($users); $i++) { ?>
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
                                    <li>
                                        <?php
                                        $pictures = Bilder::erstelleArray($users[$i]->getId());

                                        $count0 = 1;

                                        for ($j = 0; $j < count($pictures); $j++) { ?>
                                            <nav class="navbar navbar-light" style="background-color: #e3f2fd;" aria-label="First navbar example">
                                                <div class="container-fluid">
                                                    <a class="navbar-brand" href="#"><?php echo $pictures[$j]->getNameBild(); ?></a>
                                                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar_<?php echo $i . '_' . $count0; ?>" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>

                                                    <div class="navbar-collapse collapse" id="navbar_<?php echo $i . '_' . $count0++; ?>" style="">
                                                        <ul class="navbar-nav me-auto mb-2">
                                                            <li class="nav-item">
                                                                <img loading="lazy" class="bd-placeholder-img" src="/images/1200/<?php echo $pictures[$j]->getNameBild() . "\" alt=\"" . $pictures[$j]->getNameBild() ?>" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false" />
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </nav>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
<?php
