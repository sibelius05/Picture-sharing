<?php

class Registration extends User
{
    private string $dateCreate;
    private string $dateTransmit;
    private string $dateExecute;
    private string $link;
    private int $status;

    /**
     * @param int|null $id
     * @param string $firstname
     * @param string $lastname
     * @param string $birthday
     * @param string $gender
     * @param string $username
     * @param string $password
     * @param string $email
     * @param array<Rolle> $rollen
     * @param string $dateCreate
     * @param string $dateTransmit
     * @param string $dateExecute
     * @param string $link
     * @param string $status
     */
    public function __construct(string $firstname, string $lastname, string $birthday, string $gender, string $username, string $password, string $email, array $rollen, ?int $id = null, string $dateCreate = null, string $dateTransmit = null, string $dateExecute = null, string $link = null, int $status = null)
    {
        parent::__construct($firstname, $lastname, $birthday, $gender, $username, $password, $email, $rollen, $id);
        $this->dateCreate = $dateCreate ?? time();
        $this->dateTransmit = $dateTransmit ?? '';
        $this->dateExecute = $dateExecute ?? '';
        $this->link = $link ?? '';
        $this->status = $status ?? 0;
    }

    /**
     * @return string
     */
    public function getDateCreate(): string
    {
        return $this->dateCreate;
    }

    /**
     * @param string $dateCreate
     */
    public function setDate(string $dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return string
     */
    public function getDateTransmit(): string
    {
        return $this->dateTransmit;
    }

    /**
     * @param string $dateTransmit
     */
    public function setDateTransmit(string $dateTransmit): void
    {
        $this->dateTransmit = $dateTransmit;
    }

    /**
     * @return string
     */
    public function getDateExecute(): string
    {
        return $this->dateExecute;
    }

    /**
     * @param string $dateExecute
     */
    public function setDateExecute(string $dateExecute): void
    {
        $this->dateExecute = $dateExecute;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return array<User>
     */
    public static function notActivatedUsers(): array
    {
        $mysqli = DB::connect();
        $stmt = $mysqli->prepare("SELECT user.*, activation.* FROM `user` LEFT JOIN `rollenzuweisung` ON user.id = rollenzuweisung.user_id LEFT JOIN `activation` ON user.id = activation.user_id WHERE rollenzuweisung.user_id IS NULL AND activation.dateCreate IS NOT NULL ORDER BY activation.dateTransmit, activation.dateCreate");
        $stmt->execute();
        $result = $stmt->get_result();
        return self::buildArrayFromDbResult($result);
    }

    public static function notActivatedSingleUser(int $id): array
    {
        $mysqli = DB::connect();
        $stmt = $mysqli->prepare("SELECT user.*, activation.* FROM `user` LEFT JOIN `rollenzuweisung` ON user.id = rollenzuweisung.user_id LEFT JOIN `activation` ON user.id = activation.user_id WHERE rollenzuweisung.user_id IS NULL AND activation.dateCreate IS NOT NULL AND activation.dateTransmit = 0 AND user.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return self::buildArrayFromDbResult($result);
    }

    private static function buildArrayFromDbResult(Object $result): array
    {
        $users = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $birthday = $row['birthday'];
            $gender = $row['gender'];
            $username = $row['username'];
            $password = $row['password'];
            $email = $row['email'];
            $rollen = [];
            $id = $row['user_id'];
            $dateCreate = $row['dateCreate'];
            $dateTransmit = $row['dateTransmit'];
            $dateExecute = $row['dateExecute'];
            $link = $row['link'];
            $status = $row['status'];
            $users[] = new Registration($firstname, $lastname, $birthday, $gender, $username, $password, $email, $rollen, $id, $dateCreate, $dateTransmit, $dateExecute, $link, $status);
        }

        return $users;
    }

    public static function createActivationLink(int $id, string $username, string $password): string
    {
        $date = time();
        $a = (Abstracts::encrypt($username . '|' . $password));

        $mysqli = DB::connect();
        $sql = "INSERT INTO activation (id, dateCreate, user_id, link, decrkey) VALUES( NULL, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssss", $date, $id, $a[0], $a[1]);
        $stmt->execute();

        return $a[0];
    }

    public static function executeActivationLink(string $link): string
    {
        $mysqli = DB::connect();
        $sql = "SELECT decrkey, dateTransmit, status FROM activation WHERE link LIKE ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $link);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        $key = $result['decrkey'] ?? '';
        $date = $result['dateTransmit'] ?? '';
        $status = $result['status'] ?? '';

        if ($status == 1 || $date < time() - DAYS_REGISTRATION * 86400)
        {
            return $status . "|" . $date;
        }

        return Abstracts::decrypt($link, $key);
    }

    public static function setTimeSendActivationLink(int $id): void
    {
        $mysqli = DB::connect();
        $sql = "UPDATE activation SET dateTransmit = " . time() . " WHERE user_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public static function setTimeExecutedActivationLink(int $id): void
    {
        $mysqli = DB::connect();
        $sql = "UPDATE activation SET dateExecute = " . time() . ", status = 1 WHERE user_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    /*public function getStatus(): string
    {
        $mysqli = DB::connect();
        $stmt = $mysqli->prepare("SELECT status FROM `activation` WHERE user_id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc())
        {
            $state = $row['status'];
        }

        return $state;
    }*/
}