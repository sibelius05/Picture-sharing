<?php
$pictures = Bilder::erstelleArray(0, false);
?>
<main>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 g-3">
                <?php $count = 1; for ($i = 0; $i < count($pictures); $i++) { ?>
                <nav class="navbar navbar-light" style="background-color: #e3f2fd;" aria-label="First navbar example">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><?php echo $pictures[$i]->getNameBild(); ?></a>
                        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar<?php echo $count; ?>" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="navbar-collapse collapse" id="navbar<?php echo $count++; ?>" style="">
                            <ul class="navbar-nav me-auto mb-2">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/images/<?php echo (isset ($_SESSION['userRollen']) && in_array('User', $_SESSION['userRollen'])) ?  "1100" : "600" ?>/<?php echo $pictures[$i]->getNameBild() ?>" data-toggle="lightbox" data-gallery="example-gallery"><img loading="lazy" class="bd-placeholder-img" src="/images/400/<?php echo $pictures[$i]->getNameBild() . "\" alt=\"" . $pictures[$i]->getNameBild() ?>" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false" /></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled">Disabled</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form role="search">
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                    </div>
                </nav>
                <?php } ?>
             </div>
        </div>
    </div>
</main>
