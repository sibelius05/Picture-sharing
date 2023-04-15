<?php

class Navigation
{
    private string $title;
    private string $view;
    private string $headline;
    private int $nav_id;

    /**
     * @param string $title
     * @param string $view
     * @param string $headline
     * @param int $nav_id
     */
    public function __construct(string $title, string $view, string $headline, int $nav_id)
    {
        $this->title = $title;
        $this->view = $view;
        $this->headline = $headline;
        $this->nav_id = $nav_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @param string $view
     */
    public function setView(string $view): void
    {
        $this->view = $view;
    }

    /**
     * @return int
     */
    public function getNavId(): int
    {
        return $this->nav_id;
    }

    /**
     * @return string
     */
    public function getHeadline(): string
    {
        return $this->headline;
    }

    /**
     * @param string $headline
     */
    public function setHeadline(string $headline): void
    {
        $this->headline = $headline;
    }



        /**
     * @param int $nav_id
     */
    public function setNavId(int $nav_id): void
    {
        $this->nav_id = $nav_id;
    }

    public static function loadSiteById(string $alias): object
    {
        $alias = trim($alias,"/");
        $userId = $_SESSION['userId'] ?? 0;

        if (strlen($alias) > 50)
        {
            $site = new Navigation('', 'confirm', 'Bestätigung', 0);

            return $site;
        }

        $mysqli = DB::connect();

        $stmt = $mysqli->prepare("SELECT ? as id, title, view, headline FROM navigation WHERE title LIKE ? UNION ALL SELECT id, username as title, 'album' as view, CONCAT(firstname, ' ', lastname) as headline FROM user WHERE username LIKE ?");
        $stmt->bind_param("iss",$userId, $alias, $alias);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        if ($row)
        {
            $title = $row['title'];
            $view = $row['view'];
            $headline = $row['headline'];
            $id = $row['id'];
        }
        else
        {
            $title = 'Fehler 404';
            $view = '404';
            $headline = 'Seitenfehler';
            $id = 0;
        }

        $site = new Navigation($title, $view, $headline, $id);

        return $site;
    }

    public function accessableActiveSite(): void
    {
        if (isset($_GET['alias']) && $_GET['alias'] != '' && $this->getNavId() != 0 && !User::getById($this->getNavId())->isUser())
        {
            if (isset($_SESSION['userId']))
            {
                if (User::getById($_SESSION['userId']) && $_SESSION['userId'] != $this->getNavId())
                {
                    header('location: /' . $_SESSION['userName']);
                }
            }
            else
            {
                header('location: /');
            }
        }
    }

    public function validUserRights(): void
    {
        if (isset($_GET['alias']) && strstr($this->getTitle(), 'admin'))
        {
            if (isset($_SESSION['userId']))
            {
                $isAdmin = User::getById($_SESSION['userId'])->isAdmin();

                if (!$isAdmin)
                {
                    session_destroy();

                    header('location: /');
                }
            }
            else
            {
                header('location: /');
            }
        }
    }
}