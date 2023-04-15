<?php
$users = Registration::notActivatedUsers();

/*echo "<pre>";
print_r ($users);
echo "</pre>";*/

?>
    <main>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row row-cols-1 g-3">
                    <h1> Neu registrierte Nutzer</h1>
                    <?php $count = 1;
                    for ($i = 0; $i < count($users); $i++) { ?>
                        <nav class="navbar navbar-light" style="background-color: #e3f2fd;" aria-label="First navbar example">
                            <div class="container">
                                <div class="row">
                                    <h2 class="navbar-light"><?php echo $users[$i]->getFirstname() . " " . $users[$i]->getLastname(); ?></h2>
                                    <p class="navbar-light">registriert
                                        am: <?php echo date('d.m.Y', $users[$i]->getDateCreate()); ?></p>
                                    <p class="navbar-light"><?php echo ($users[$i]->getDateTransmit() == 0) ? "Status: unbearbeitet" : "Mail am: " . date('d.m.Y', $users[$i]->getDateTransmit()); ?></p>
                                </div>
                                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar<?php echo $count; ?>" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="navbar-collapse collapse" id="navbar<?php echo $count++; ?>" style="">
                                    <ul class="navbar-nav me-auto mb-2">
                                        <li class="nav-item">
                                            <a class="nav-link active">Geburtsdatum: <?php echo date('d.m.Y', strtotime($users[$i]->getBirthday())); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active">Geschlecht: <?php echo ($users[$i]->getGender() == 'f') ? "weiblich" : "männlich"; ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active">Username: <?php echo $users[$i]->getUsername(); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active">Email: <?php echo $users[$i]->getEmail(); ?></a>
                                        </li>
                                        <?php if ($users[$i]->getDateTransmit() == 0) { ?>
                                        <li class="nav-item">
                                            <span id="container_<?php echo $users[$i]->getId(); ?>"><button class="btn btn-secondary" type="btn" id="<?php echo $users[$i]->getId(); ?>">Aktivierung</button></span>
                                        </li>
                                        <?php } else if ($users[$i]->getDateTransmit() > 0 && $users[$i]->getDateTransmit() < time() - 5 * 86400) { ?>
                                        <li class="nav-item">
                                            <span id="container_<?php echo $users[$i]->getId(); ?>"><button class="btn btn-secondary" type="btn" id="<?php echo $users[$i]->getId(); ?>">Löschen</button></span>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <?php
                        if ($users[$i]->getDateTransmit() == 0 && $users[$i + 1]->getDateTransmit() != 0)
                        {
                            ?>
                            <h1> Bereits benachrichtigte Nutzer</h1>
                            <?php if ($users[$i + 1]->getDateTransmit() < time() - 5 * 86400)
                            {
                                ?>
                                <h2> Bereits abglaufene Benachrichtigungen</h2>
                            <?php } ?>
                        <?php } ?>
                        <?php if (isset ($users[$i + 1]) && $users[$i]->getDateTransmit() <= time() - 5 * 86400 && $users[$i + 1]->getDateTransmit() > time() - 5 * 86400)
                        {
                            ?>
                            <h2> Laufende Benachrichtigungen</h2>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <script src="/js/registrations.js"></script>
        </div>
    </main>
<?php