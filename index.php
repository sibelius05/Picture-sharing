<?php
ini_set('display_errors', 0);

include 'config.php';
spl_autoload_register(/**
 * @param $className
 */ function ($className)
{
    include 'class/' . $className . '.php';
});

session_start();

if (empty($loggedin)) $loggedin = false; // wird nach erfolgtem Login auf true gesetzt

include "action.php"; // hier werden alle Formular-Aktionen ausgeführt

if (isset($_SESSION['ID']) && isset($_SESSION['userId']) && $_COOKIE['PHPSESSID'] === $_SESSION['ID'])
{
    $currentSession = Session::getCurrentSession($_SESSION['ID']);

    if ($currentSession && $currentSession->getSessionId() == $_SESSION['ID'] && $currentSession->getTimeLast() > time() - DURATION_SESSION)
    {
        if (isset($_GET['alias']) && $_GET['alias'] == 'logout')
        {
            $username = $_SESSION['userName'];

            setcookie("PHPSESSID", $_SESSION['ID'], 1);

            session_destroy();

            $currentSession->delete();

            setcookie("PHPSESSID", session_create_id());

            header("location: /" . $username);
        }
        else
        {
            $currentSession->setTimeLast(time());

            $currentSession->save();

            $loggedin = true; // Login-Bedingung erfüllt, dann Übergabewert true

            $user = User::getById($_SESSION['userId']);
        }
    }
    else
    {
        setcookie("PHPSESSID", $_SESSION['ID'], 1);

        setcookie("PHPSESSID", session_create_id());

        unset($_SESSION['userId']);
    }
}

if ($loggedin)
{
    if (isset($_GET['alias']))
    {
        $alias = $_GET['alias'];

        $n = Navigation::loadSiteById($alias); // stellt ausgewählte Seite als Objekt bereit
    }
    else
    {
        header("location: /" . $_SESSION['userName']);
    }
}
else
{
    if (isset($_GET['alias']))
    {
        $n = Navigation::loadSiteById($_GET['alias']); // stellt ausgewählte Seite als Objekt bereit
    }
    else
    {
        $n = new Navigation("", "login", "Anmeldung", 0); // stellt Anmeldeseite als Objekt bereit
    }
}

$n->accessableActiveSite();

$n->validUserRights();

//echo '<pre>';
//if (isset($_GET)) print_r($_GET);
//if (isset($user)) print_r($user);
//if (isset($n)) print_r($n);
//if (!empty($_SESSION)) print_r($_SESSION);
//if (!empty($_COOKIE)) print_r($_COOKIE);
//echo '</pre>';

$n = $n ?? '';

$ui = $n->getNavId();

if ($n->getView() === 'album')
{
    if (isset($user) && $user->getId() === $ui)
    {
        $ausgabe = Bilder::erstelleArray($ui);
    }
    else
    {
        $ausgabe = Bilder::erstelleArray($ui, true);
    }
}

include "view/wrapper.php"; // Basislayout aller Seiten