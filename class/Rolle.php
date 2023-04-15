<?php

class Rolle
{
    /**
     * @var int
     * PK
     */
    private int $id;
    /**
     * @var string
     * maxLänge 45 Zeichen
     */
    private string $name;

    /**
     * @param int|null $id
     * @param string $name
     * @throws Exception
     */
    public function __construct(string $name, ?int $id = null)
    {

        $this->name = $name;
        if (isset($id)) {
            $this->id = $id;
        } else {
            try {
                $this->save();
            } catch (Exception $e){
                throw new Exception($e->getMessage() . " ==> kann Rolle nicht erstellen");
            }

        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @throws Exception
     * tabelle rolle wird neu erstellt
     */
    public static function recreateTable()
    {
        $mysqli = DB::connect();
        $sql = "CREATE TABLE rolle(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(45))";
        $mysqli->query($sql);
        // seed
        $sql = "INSERT INTO rolle VALUES(NULL, 'User')";
        $mysqli->query($sql);
        $sql = "INSERT INTO rolle VALUES(NULL, 'Admin')";
        $mysqli->query($sql);
    }

    /**
     * @param int $id
     * @return Rolle
     */
    public static function getRolleById(int $id): Rolle
    {
        $rolle = [];
        $mysqli = DB::connect();
        $stmt = $mysqli->prepare("SELECT * FROM rolle WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = mysqli_fetch_assoc($result)) {
            $rolle = new Rolle($row['name'], $row['id']);
        }
        return $rolle;
    }

    /**
     * @param string $name
     * @return array<Rolle>
     */
    public static function getAllAsObjects(string $name = ''): array
    {
        $rollen = [];
        $mysqli = DB::connect();
        $stmt = $mysqli->prepare("SELECT * FROM rolle WHERE name like CONCAT(?,'%')");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_Result();
        while ($row = mysqli_fetch_assoc($result)) {
            $rollen[] = new Rolle($row['name'], $row['id']);
        }
        return $rollen;
    }

    /**
     * @param array $rollen
     * @return string
     */
    public static function getHTMLTable(array $rollen): string
    {
        $html = '<table>';
        /**
         * @array<Rolle>
         */
        foreach ($rollen as $rolle) {
            $html .= '<tr>';
            $html .= "<td>{$rolle->getName()}</td>";
            $html .= "<td>" . Rolle::getButton($rolle->getId()) . "</td>"; // alternative Schreibweise
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }

    /**
     * @param int $id
     * @return string
     */
    public static function getButton(int $id): string
    {
        return '<a href="index.php?action=showAendern&area=rolle&id=' . $id . '"><button>ändern</button></a>';
    }

    /**
     * @param int $id
     * @return Rolle
     */
    public static function getById(int $id): Rolle
    {
        $mysqli = DB::connect();
        $sql = "SELECT * FROM rolle WHERE id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $rolle = new Rolle($row['name'], $row['id']);
        }
        return $rolle;
    }

    /**
     * @throws Exception
     */
    public function save(): void
    {
        $isNameValid = $this->isNameValid();
        if (isset($this->id)) {
            $isNameAvailable = $this->isNameAvailable($this->id);
        } else {
            $isNameAvailable = $this->isNameAvailable();
        }

        if (!$isNameValid) {
            throw new Exception('name is ungültig');
        } elseif (!$isNameAvailable) {
            throw new Exception('name is vergeben');
        }

        if (!isset($this->id)) {
            // wenn keine $this->id vorhanden ist, erfolgt insert()
            $this->insert();
        } else {
            $this->update();
        }

    }

    private function isNameValid(): bool
    {
        // $name muss mindestens 3 Zeichen enthalten, alle Zeichen müssen alphanumerisch sein
        if (strlen($this->name) > 3 && ctype_alnum($this->name)) {
            return true;
        }
        return false;
    }

    /**
     * @param int|null $id
     * @return bool
     * @throws Exception
     */
    private function isNameAvailable(int $id = Null): bool
    {
        // überprüfen, ob es den Namen schon in der Tabelle user gibt
        $mysqli = DB::connect();
        $sql = "SELECT id FROM rolle WHERE name=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $this->name);
        $stmt->execute();
        $result = $stmt->get_result();
        $rolle = $result->fetch_assoc();
        if ($rolle && $rolle['id'] != $id) {
            return false;
        }
        return true;
    }

    /**
     * @throws Exception
     */
    private function insert()
    {
        $mysqli = DB::connect();
        $sql = "INSERT INTO rolle(id, name )VALUES( NULL, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $this->name);
        $stmt->execute();
        $this->id = $stmt->insert_id;
    }

    /**
     * @throws Exception
     */
    private function update()
    {
        $mysqli = DB::connect();
        $sql = "UPDATE rolle SET name=? WHERE id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $this->name, $this->id);
        $stmt->execute();
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function deleteRolleById(int $id): bool
    {
        $mysqli = DB::connect();
        $sql = "DELETE FROM rolle WHERE id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        return  $stmt->execute();
    }


    /**
     * @param array<int> $rollenIds
     * @return array<Rolle>
     */
    public static function buildRollenFromRolleIds(array $rollenIds): array
    {
        // buildRollenFromRolleIds([2,1]) hat den Return-Wert:
        // [new Rolle('admin', 2), new Rolle('user', 1)]
        $rollen = [];
        foreach ($rollenIds as $rolleId) {
            $rollen[] = Rolle::getRolleById($rolleId);
        }
        return $rollen;
    }

}