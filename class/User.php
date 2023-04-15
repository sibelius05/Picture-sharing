<?php

class User extends Abstracts implements Handling
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $birthday;
    private string $gender;
    private string $username;
    private string $password;
    private string $email;
    private array $rollen = [];

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }

    /**
     * @param string $birthday
     */
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return Rolle[]
     */
    public function getRollen(): array
    {
        return $this->rollen;
    }

    /**
     * @param Rolle[] $rollen
     */
    public function setRollen(array $rollen): void
    {
        $this->rollen = $rollen;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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
     */
    public function __construct(string $firstname, string $lastname, string $birthday, string $gender, string $username, string $password, string $email, array $rollen, ?int $id = null)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
        $this->gender = $gender;
        $this->username = $username;
        if($password != '') {$this->password = $password;} else {$this->password = $this->getNewPassword();}
        $this->email = $email;
        $this->rollen = $rollen;

        if (isset($id)) {
            $this->id = $id;
        }
        else {
            try {
                $this->save();
            } catch (Exception $e){
                throw new Exception($e->getMessage() . " ==> user kann nicht erstellt werden");
            }
        }
    }

    private static function createArrayOfCharacters(string $char): array
    {
        for ($i = 0; $i < strlen($char); $i++)
        {
            $array[] = $char[$i];
        }

        return $array;
    }

    private function getNewPassword(): string
    {
        $special = SPECIAL_CHARS;

        $all = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'), self::createArrayOfCharacters($special));

        $pattern = "/([" . addcslashes($special, '/') . "])/";

        do
        {
            $string = '';

            for ($i = 0; $i < 12; $i++)
            {
                $string .= $all[random_int(0, count($all) - 1)];
            }

            preg_match_all($pattern, $string, $result);
        } while (!Abstracts::proofPassword($string) || count($result[1]) > 2);

        return $string;
    }

    public function save(): void
    {
        // Überprüfen, ob $name und $passwd den gegebenen Vorgaben entsprechen
        $isNameValid = $this->isNameValid();
        $isPasswdValid = $this->isPasswdValid();
        if (isset($this->id)) {
            // gibt es $name schon bei einem anderen user?
            $isNameAvailable = $this->isNameAvailable($this->id);
        } else {
            // gibt es $name schon in DB.tabelle
            $isNameAvailable = $this->isNameAvailable();
        }
        // Fehlermeldungen für user erzeugen
        if (!$isNameValid) {
            throw new Exception('name is ungültig');
        } elseif
        (!$isPasswdValid) {
            throw new Exception('passwort is ungültig');
        } elseif (!$isNameAvailable) {
            throw new Exception('name is vergeben');
        }

        // Wenn Überprüfung okay ist (keine Exception geworfen)
        // dann in DB speichern
        if (!isset($this->id)) {
            // falls es diese $id nicht gibt, muss DS erzeugt werden
            $this->insert();
        } else {
            $this->update();
        }
    }

    private function isNameValid(): bool
    {
        // $name muss mindestens 4 Zeichen enthalten, alle Zeichen müssen alphanumerisch sein
        if (strlen($this->username) > 4 && ctype_alnum($this->username)) {
            return true;
        }
        return false;
    }

    private function isPasswdValid(): bool
    {
        if (strlen($this->password) > 8) {
            return true;
        }
        return false;
    }

    private function isNameAvailable(int $id = Null): bool
    {
        // überprüfen, ob es den Namen schon in der Tabelle user gibt
        $mysqli = DB::connect();
        $sql = "SELECT id FROM user WHERE username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        // assoc: der Spaltenname (id) wird zum Schlüssel des Arrays $user
        // falls es einen Wert in der Ausgabe von mysqli gibt, dann kann ich ihn mit $user['id'] ansprechen

        if ($user && $user['id'] != $id) return false; // Kurzschreibweise

        return true;
    }

    /**
     * @throws Exception
     * speichert Daten in neuem DS, PK wird an $this->id übergeben
     */
    private function insert()
    {
        $mysqli = DB::connect();
        $sql = "INSERT INTO user(id, firstname, lastname, birthday, gender, username, password, email) VALUES( NULL, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssssss", $this->firstname, $this->lastname, $this->birthday, $this->gender, $this->username, $this->password, $this->email);
        $stmt->execute();
        $this->id = $stmt->insert_id;
        $this->saveRollenids($this->rollen);
    }

    /**
     * @throws Exception
     */
    private function update()
    {
        $mysqli = DB::connect();
        $sql = "UPDATE user SET firstname = ?, lastname = ?, birthday = ?, gender = ?, username = ?, password = ?, email = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssssssi", $this->firstname, $this->lastname, $this->birthday, $this->gender, $this->username, $this->password, $this->email, $this->id);
        $stmt->execute();
        $this->saveRollenids($this->rollen);
    }

    /**
     * @return array<User>
     * $name dient zum Filtern von den ersten Buchstaben von $name
     */
    public static function getAllAsObjects(string $name = ''): array
    {
        $users = [];
        $mysqli = DB::connect();
        $stmt = $mysqli->prepare("SELECT * FROM user WHERE username like CONCAT(?,'%')");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return self::buildArrayFromDbResult($result);
    }

    /**
     * @return array<User>
     * $name dient zum Filtern von den ersten Buchstaben von $name
     */
    public static function getAllUsersHavingNotActivatedPictures(string $name = ''): array
    {
        $users = [];
        $mysqli = DB::connect();
        $stmt = $mysqli->prepare("SELECT u.* FROM user u JOIN bilder b ON u.id = b.user_id WHERE b.active = 0 AND u.username like CONCAT(?,'%') GROUP BY u.id");
        $stmt->bind_param("s", $name);
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
            $id = $row['id']; // wenn Werte wie $row['id'] mehrfach gebraucht werden, muss ich
            // sie in Variablen retten $id = ...
            $rollen = [];
            $users[] = new User($firstname, $lastname, $birthday, $gender, $username, $password, $email, $rollen, $id);
        }

        return $users;
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function deleteUserById(int $id): bool
    {
        // zuerst müssen die DS in tabelle rollenzuweisung gelöscht werden,
        // dann der user in tabelle user, um FK Constraint zu bedienen
        //
        // da 2. Parameter ein leeres Array ist, werden die DS gelöscht, die zu der user-id gehören
        // kein neuer Eintrag in die Tabelle rollenzuweisung
        Rollenzuweisung::saveRollenidsByUser(User::getById($id), []); // hier wird in tabelle rollenzuweisung gelöscht
        $mysqli = DB::connect();
        $sql = "DELETE FROM user WHERE id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        // falls wir dem user positives feeDBack geben wollen, erstellen wir einen Rückgabewert
        $success = $stmt->execute();
        return $success;
    }

    /**
     * @param int $id
     * @return User
     * @throws Exception
     */
    public static function getById(int $id): User
    {
        $mysqli = DB::connect();
        $sql = "SELECT * FROM user WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return self::buildUserFromDbResult($result);
    }

    /**
     * @param Object $result
     * @return User
     */
    private static function buildUserFromDbResult(Object $result): User
    {
        if ($row = $result->fetch_assoc()) {
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $birthday = $row['birthday'];
            $gender = $row['gender'];
            $username = $row['username'];
            $password = $row['password'];
            $email = $row['email'];
            $id = $row['id'];
            $rollen = Rolle::buildRollenFromRolleIds(Rollenzuweisung::getRollenIdsByUserId($id));
            $user = new User($firstname, $lastname, $birthday, $gender, $username, $password, $email, $rollen, $id);
        }

        return $user;
    }

    /**
     * @param string $name
     * @param string $passwd
     * @return User
     * @throws Exception
     */
    public static function getUserByNameAndPasswrd(string $name, string $passwd): User
    {
        $passwdHashed = md5($passwd);
        $mysqli = DB::connect();
        $sql = "SELECT * FROM user WHERE username = ? AND password = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $name, $passwdHashed);
        $stmt->execute();
        $result = $stmt->get_result();
        if (($result->num_rows === 0)) {
            throw new Exception("das Login hat nicht geklappt");
        }
        return self::buildUserFromDbResult($result);
    }

    /**
     * @return array<Rolle>
     */
    public function getAlleRollen(): array
    {
        // die Klammern werden von innen nach außen gelesen, um den Gesamtsinn zu verstehen:
        // $this->id ist der PK des aktuellen User-Objekts.
        // Rollenzuweisung::getRollenIdsByUserId($this->id) ist ein Array mit allen rollen_ids,
        // ausgelesen aus der Zuordnungstabelle rollenzuweisung
        // Rolle::buildRollenFromRolleIds( ... ) erstellt ein Array mit den Rollen, zu dem obigen Array
        // mit den rollenIds( ... ) des users
        return Rolle::buildRollenFromRolleIds(Rollenzuweisung::getRollenIdsByUserId($this->id));
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        foreach ($this->rollen as $userRolle) {
            if ($userRolle->getName() === 'Administrator') {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        foreach ($this->rollen as $userRolle) {
            if ($userRolle->getName() === 'User') {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array<int> $rollen_ids
     */
    public function saveRollenids(array $rollen_ids): void
    {
        // Klasse user darf nicht auf die tabelle rollenzuweisung zugreifen
        Rollenzuweisung::saveRollenidsByUser($this, $rollen_ids);
    }
}