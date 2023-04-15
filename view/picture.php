<?php
ini_set('display_errors', true);

spl_autoload_register(/**
 * @param $className
 */ function ($className)
{
    include '../class/' . $className . '.php';
});

include "../config.php";

session_start();

if ($_GET['breite'] < 50) exit;

$userId = 0;

if (empty($_SESSION))
{
    if ($_GET['breite'] > SIZE_VISITOR) $_GET['breite'] = SIZE_VISITOR;
}
else
{
    if (isset($_SESSION['userId']))
    {
        $user = User::getById($_SESSION['userId']);

        $isUser = $user->isUser();

        if ($isUser)
        {
            $userId = $user->getId();
        }

        if (!$isUser)
        {
            if ($_GET['breite'] > SIZE_UNACTIVE_USER) $_GET['breite'] = SIZE_UNACTIVE_USER;
        }
    }
}

$bild = Bilder::erstelleBild($_GET['titel']);

if ($bild->isActive() === true || (isset($user) && $user->isAdmin()) || ($bild->isActive() === false && isset($user) && $user->getId() == $bild->getUserId()))
{
    $imagick = new Imagick();

    $imagick->readImageBlob($bild->getDatenBild());

    $imagick->scaleImage($_GET['breite'], $_GET['breite'], true);

    $imagick->autoLevelImage();

    $imagick->sharpenimage(5, 1);

    $imagick->setImageFormat(COMPRESSION_TYPE);

    //$imagick->setImageCompression(Imagick::COMPRESSION_W);

    $imagick->setImageCompressionQuality(COMPRESSION_LEVEL_VIEW);

    if (!is_dir("../images/" . $_GET['breite'])) mkdir("../images/" . $_GET['breite']);

    $imagick->writeImage("../images/" . $_GET['breite'] . "/" . $_GET['titel']);

    header("Content-Type: image/" . COMPRESSION_TYPE);

    echo $imagick->getImageBlob();
}

