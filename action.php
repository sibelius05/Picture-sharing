<?php ini_set('display_errors', 1); ?>
<?php
$action = $_POST['action'] ?? "";

if ($action == "doLogin")
{
    $login = $_POST['login'] ?? "";
    $password = $_POST['password'] ?? "";

    try
    {
        $user = User::getUserByNameAndPasswrd($login, $password);

        if ($user)
        {
            $_SESSION['ID'] = $_COOKIE['PHPSESSID'] ??  session_id();

            $_SESSION['userId'] = $user->getId();

            $_SESSION['userName'] = $user->getUsername();

            $currentSession = new Session($_SESSION['ID'], $_SESSION['userName'], $_SESSION['userId'], time(), time(), 1);

            $currentSession->save();

            $loggedin = true;

            header("location: /" . $user->getUsername());
        }
    }
    catch (Exception $e)
    {
        echo '<div class="fehlermeldung">' . $e->getMessage() . '</div>';
    }
}
elseif ($action == "doRegister")
{
    $vorname = $_POST['vorname'] ?? "";
    $nachname = $_POST['nachname'] ?? "";
    $login = $_POST['login'] ?? "";
    $email = $_POST['email'] ?? "";
    $rollen_ids = $_POST['rollen_ids'] ?? [];

    try
    {
        $registration = new Registration($vorname, $nachname, '1965-10-05', 'm', $login, '', $email, $rollen_ids, null);

        if ($registration->getId())
        {
            $registration->setLink(Registration::createActivationLink($registration->getId(), $registration->getUsername(), $registration->getPassword()));

            $password = $registration->getPassword();

            $registration->setPassword(User::newHash($registration->getPassword()));

            $registration->save();

            $vars = array('birthday' => $registration->getBirthday(), 'gender' => $registration->getGender(), 'username' => $registration->getUsername(), 'password' => $password);

            Mailing::sendMail($registration->getEmail(), $registration->getFirstname(), $registration->getLastname(), 'registrierung.php', $vars, 'Deine Registrierung bei halbanalog.de');

            $vars = array('firstname' => $registration->getFirstname(), 'lastname' => $registration->getLastname(), 'birthday' => $registration->getBirthday(), 'gender' => $registration->getGender(), 'username' => $registration->getUsername());

            Mailing::sendMail(EMAIL_ADMIN, FIRSTNAME_ADMIN, LASTNAME_ADMIN, 'benachrichtigung.php', $vars, 'Eine neue Registrierung');

            $user = User::getUserByNameAndPasswrd($registration->getUsername(), $password);

            if ($user)
            {
                $_SESSION['ID'] = $_COOKIE['PHPSESSID'] ?? session_id();

                $_SESSION['userId'] = $user->getId();

                $_SESSION['userName'] = $user->getUsername();

                $currentSession = new Session($_SESSION['ID'], $_SESSION['userName'], $_SESSION['userId'], time(), time(), 1);

                $currentSession->save();

                $loggedin = true;

                header("location: /" . $user->getUsername());
            }
        }
    }
    catch (Exception $e)
    {
        echo '<div class="fehlermeldung">' . $e->getMessage() . '</div>';
    }
}
elseif ($action == "doUpdate")
{
    $userId = $_POST['userId'] ?? "";
    $firstname = $_POST['firstname'] ?? "";
    $lastname = $_POST['lastname'] ?? "";
    $birthday = date('Y-m-d', strtotime($_POST['birthday'])) ?? "";
    $gender = $_POST['salutation'];
    $email = $_POST['email'] ?? "";

    try
    {
        $user = User::getById($userId);

        if ($user)
        {
            $user->setFirstname($firstname);

            $user->setLastname($lastname);

            $user->setBirthday($birthday);

            $user->setGender($gender);

            $user->setEmail($email);

            $user->save();
        }
    }
    catch (Exception $e)
    {
        echo '<div class="fehlermeldung">' . $e->getMessage() . '</div>';
    }
}
elseif ($action == "doActivate")
{
    $login = $_POST['login'] ?? "";
    $passwordOld = $_POST['passwortAlt'] ?? "";
    $passwordNew = $_POST['passwortNeu'] ?? "";
    $passwordRpt = $_POST['passwortWdh'] ?? "";
    $rollen_ids[0] = 1;
    $rollen = $rollen_ids;

    try
    {
        if ($passwordNew != $passwordOld && $passwordNew == $passwordRpt && User::proofPassword($passwordNew))
        {
            $user = User::getUserByNameAndPasswrd($login, $passwordOld);

            if ($user && User::newHash($passwordOld) == $user->getPassword())
            {
                $user->setPassword(User::newHash($passwordNew));

                $user->setRollen($rollen);

                $user->save();

                Registration::setTimeExecutedActivationLink($user->getId());

                $_SESSION['successActivation'] = true;

                header("location: /" . $user->getUsername());
            }
            else
            {
                echo "something strange";
            }
        }
        else
        {
            session_destroy();

            header('location: /');
        }
    }
    catch (Exception $e)
    {
        echo "irgendwas!";
    }
}
elseif ($action == "fileUpload")
{
    $userId = $_POST['userId'] ?? "";
    $fileToUpload = $_POST['fileToUpload'] ?? "";
    $fileDescription = $_POST['fileDescription'] ?? "";
    $fileRatio = $_POST['fileRatio'] ?? "";

    try
    {
        $image = new Bilder($userId, '', substr(md5(time()), 1, 16), $fileToUpload, $fileDescription, time(), time(), $fileRatio, 0);
    }
    catch (Exception $e)
    {
        echo "irgendwas!";
    }
}
elseif ($action == "countPicture")
{
    $path = $_POST['path'] ?? "";

    try
    {
        Bilder::logImages($path); echo "Happened!";
    }
    catch (Exception $e)
    {
        echo "irgendwas!";
    }
}
