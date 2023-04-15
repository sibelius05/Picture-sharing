<?php

class Bilder implements Handling
{
    private int $userId;
    private string $pfadBild;
    private string $nameBild;
    private string $datenBild;
    private string $description;
    private int $created;
    private int $updated;
    private float $ratio;
    private bool $active;
    private int $id;

    /**
     * @param int $userId
     * @param string $pfadBild
     * @param string $nameBild
     * @param string $datenBild
     * @param string $description
     * @param int $created
     * @param int $updated
     * @param float $ratio
     * @param bool $active
     * @param int $id
     */
    public function __construct(int $userId, string $pfadBild, string $nameBild, string $datenBild, string $description, int $created, int $updated, float $ratio, bool $active, int $id = null)
    {
        $this->userId = $userId;
        $this->pfadBild = $pfadBild;
        $this->nameBild = $nameBild;
        $this->datenBild = $datenBild;
        $this->description = $description;
        $this->created = $created;
        $this->updated = $updated;
        $this->ratio = $ratio;
        $this->active = $active;

        if (isset($id))
        {
            $this->id = $id;
        }
        else
        {
            try
            {
                $this->save();
            }
            catch (Exception $e)
            {
                throw new Exception($e->getMessage() . " ==> Bild kann nicht gespeichert werden");
            }
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getNameBild(): string
    {
        return $this->nameBild;
    }

    /**
     * @param string $nameBild
     */
    public function setNameBild(string $nameBild): void
    {
        $this->nameBild = $nameBild;
    }

    /**
     * @return string
     */
    public function getPfadBild(): string
    {
        return $this->pfadBild;
    }

    /**
     * @param string $pfadBild
     */
    public function setPfadBild(string $pfadBild): void
    {
        $this->pfadBild = $pfadBild;
    }

    /**
     * @return string
     */
    public function getDatenBild(): string
    {
        return $this->datenBild;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * @return int
     */
    public function getUpdated(): int
    {
        return $this->updated;
    }

    /**
     * @return float
     */
    public function getRatio(): float
    {
        return $this->ratio;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    public function save(): void
    {
        if (!isset($this->id))
        {
            $this->insert();
        }
        else
        {
            $this->update();
        }
    }

    private function insert()
    {
        $mysqli = DB::connect();
        $sql = "INSERT INTO bilder (id, user_id, pfad, titel, bild, description, created, updated, ratio, active) VALUES( NULL, ?, ?, ?, FROM_BASE64(?), ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("issssiidi", $this->userId, $this->pfadBild, $this->nameBild, $this->datenBild, $this->description, $this->created, $this->updated, $this->ratio, $this->active);
        $stmt->execute();
        $this->id = $stmt->insert_id;
    }

    static function deletePicture(int $id): bool
    {
        $mysqli = DB::connect();
        $sql = "DELETE FROM bilder WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return true;
    }

    static function erstelleArray(int $id = 0, bool $active = null): array
    {
        $mysqli = DB::connect();

        if ($id)
        {
            $query = "SELECT id, user_id, pfad, titel, description, created, updated, ratio, active FROM bilder WHERE user_id = ?";

            if ($active === null)
            {
                $query .= '';
            }
            else if ($active)
            {
                $query .= " AND active = 1";
            }
            else
            {
                $query .= " AND active = 0";
            }

            $query .= " ORDER BY id DESC";

            $stmt = $mysqli->prepare($query);

            $stmt->bind_param("i", $id);
        }
        else
        {
            $stmt = $mysqli->prepare("SELECT * FROM bilder");
        }

        $stmt->execute();

        $result = $stmt->get_result();

        // speichern in array
        $bilder = [];

        while ($row = $result->fetch_assoc())
        {
            $bilder[] = new Bilder ($row['user_id'], $row['pfad'], $row['titel'], '', $row['description'], $row['created'], $row['updated'], $row['ratio'], $row['active'], $row['id']);
        }

        return $bilder;
    }

    static function erstelleBild(string $title): object
    {
        $mysqli = DB::connect();

        $stmt = $mysqli->prepare("SELECT * FROM bilder WHERE titel LIKE ?");

        $title = str_replace('.' . COMPRESSION_TYPE, '', $title);

        $stmt->bind_param("s", $title);

        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        if ($row['active'] == 0) $active = false;

        if ($row['active'] == 1) $active = true;

        $bild = new Bilder($row['user_id'], $row['pfad'], $row['titel'], $row['bild'], $row['description'], $row['created'], $row['updated'], $row['ratio'], $active, $row['id']);

        return $bild;
    }

    static function activateUsersPicture (int $userId, int $pictureId, int $state): void
    {
        $mysqli = DB::connect();

        $stmt = $mysqli->prepare("UPDATE bilder SET active = ? WHERE id = ? AND user_id = ?");

        $stmt->bind_param("iii", $state, $pictureId, $userId);

        $stmt->execute();
    }

    static function logImages (string $path, int $fileSize = 0): void
    {
        $mysqli = DB::connect();

        $stmt = $mysqli->prepare("UPDATE log_images SET date = " . time() . ", avgdate = (avgdate * counter + " . time() . ") / (counter + 1), counter = counter + 1 WHERE path = ?");

        $stmt->bind_param("s", $path);

        $stmt->execute();

        if ($stmt->affected_rows === 0)
        {
            $stmt = $mysqli->prepare("INSERT INTO log_images (path, size, date, avgdate, counter) VALUES (?, ?, " . time() . ", " . time() . ", 1)");

            $stmt->bind_param("si", $path, $fileSize);

            $stmt->execute();
        }
    }

    static function updateSizeToLogImages (string $path, int $size): void
    {
        $mysqli = DB::connect();

        $stmt = $mysqli->prepare("UPDATE log_images SET size = ? WHERE path = ?");

        $stmt->bind_param("is", $size, $path);

        $stmt->execute();
    }

    static public function recursive(string $dir): void
    {
        $handle =  opendir($dir);

        while ($datei = readdir($handle))
        {
            if ($datei != "." && $datei != "..")
            {
                if (is_dir($dir.$datei))
                {
                    self::recursive($dir.$datei.'/');
                }
                else
                {
                    self::updateSizeToLogImages("/" . $dir.$datei, filesize ($dir.$datei));
                }
            }
        }

        closedir($handle);
    }

    static public function giveSizeAllImages(string $dir): void
    {
        file_put_contents("images.json", "[\n{\"name\": \"\", \"date\": 0, \"size\": 0}");

        self::recursive($dir);

        file_put_contents("images.json", "]", FILE_APPEND);

        $files = json_decode(file_get_contents("images.json"), true);

        foreach ($files as $key => $row)
        {
            $date[$key] = $row['date'];
        }

        array_multisort($date, SORT_DESC, $files);

//        $sum = 0;
//
//        foreach ($files as $key=>$file) {
//            $sum += $file['size'];
//        }

        $sum = 0;

        foreach ($files as $file)
        {
            $sum += $file['size'];

            if ($sum > 26214400)
            {
                unlink($file['name']);
            }
        }
    }
}