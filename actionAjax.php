<?php
include 'config.php';

spl_autoload_register(function ($className)
{
    include 'class/' . $className . '.php';
});

$action = $_POST['action'] ?? "";

if ($action == "sendActivationMail")
{
    $id = $_POST['id'] ?? "";

    try
    {
        $user = Registration::notActivatedSingleUser($id);

        $vars = array('firstname' => $user[0]->getFirstname(), 'lastname' => $user[0]->getLastname(), 'link' => $user[0]->getLink());

        if ($user)
        {
            Mailing::sendMail($user[0]->getEmail(), $user[0]->getFirstname(),  $user[0]->getLastname(), 'aktivierung.php', $vars, 'Dein Aktivierungslink');

            Registration::setTimeSendActivationLink($id);

            echo "<a class=\"nav-link active\">" . $user[0]->getLink() . "</a>";
        }
    }
    catch (Exception $e)
    {
        echo '<div class="fehlermeldung">' . $e->getMessage() . '</div>';
    }
}
elseif ($action == "activatePic" || $action == "modActivatePic")
{
    file_put_contents('notizen.txt', date('d.m.Y h:i:s', time()));

    $userId = intval($_POST['userId']) ?? "";

    $pictureId = intval($_POST['pictureId']) ?? "";

    $state = ($_POST['state'] == 'inactive') ? 1 : 0 ?? "";

    try
    {
        Bilder::activateUsersPicture($userId, $pictureId, $state);

        echo '<button type="button" id="' . $userId . '_' . $pictureId . '" class="btn btn-sm btn-outline-secondary" data-toggle="activatePic_' . $userId . '_' . $pictureId . '" data-state="';

        if ($state == 1)
        {
            echo 'active">Sperren</button>';
        }
        else
        {
            echo 'inactive">Bild freischalten</button>';
        }
    }
    catch (Exception $e)
    {
        echo '<div class="fehlermeldung">' . $e->getMessage() . '</div>';
    }
}
elseif ($action == "fileDelete")
{
    $picId = $_POST['picId'] ?? "";

    try
    {
        Bilder::deletePicture($picId);

        echo "<div class=\"card-body\">Eintrag erfolgreich gelöscht.<br /><br />Bitte Seite neu laden.</div>";
    }
    catch (Exception $e)
    {
        echo "irgendwas!";
    }
}
elseif ($action == "countPicture")
{
    $path = $_POST['path'] ?? ""; file_put_contents("test.txt", "irgendwas", FILE_APPEND);

    try
    {
        $path = trim($path, '/');

        $fileSize = null;

        $i = 0;

        while ($fileSize == null && $i < 10)
        {
            sleep(1);

            if (is_file($path))
            {
                $fileSize = filesize($path);
            }

            $i++;
        }

        Bilder::logImages($path, $fileSize);

        echo "x";
    }
    catch (Exception $e)
    {
        echo "noch was!";
    }
}
