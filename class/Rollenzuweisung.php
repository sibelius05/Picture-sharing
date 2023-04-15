<?php

class Rollenzuweisung
{



    public static function recreateTable()
    {
        $mysqli = DB::connect();
        $sql = "CREATE TABLE rollenzuweisung(id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, rolle_id INT)";
        $mysqli->query($sql);
        $sql = "INSERT INTO rollenzuweisung VALUES(NULL, 1,1)";
        $mysqli->query($sql);
        // seed
        $sql = "INSERT INTO rollenzuweisung VALUES(NULL, 1,2)";
        $mysqli->query($sql);
        $sql = "INSERT INTO rollenzuweisung VALUES(NULL, 2,2)";
        $mysqli->query($sql);
        $sql = "ALTER TABLE rollenzuweisung ADD FOREIGN KEY (user_id) REFERENCES user(id)";
        $mysqli->query($sql);
        $sql = "ALTER TABLE rollenzuweisung ADD FOREIGN KEY (rolle_id) REFERENCES rolle(id)";
        $mysqli->query($sql);

    }

    /**
     * @param int $user_id
     * @return array<int>
     * die tabelle rollenzuweisung enthält rolle_ids zu der user_id
     */
    public static function getRollenIdsByUserId(int $user_id): array
    {
        $rolleIds = [];
        $mysqli = DB::connect();
        $stmt = $mysqli->prepare("SELECT * FROM rollenzuweisung WHERE user_id=?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = mysqli_fetch_assoc($result)) {
            $rolleIds[] = $row['rolle_id'];
        }
        return $rolleIds;
    }

    /**
     * @param User $param
     * @param array<int> $rollen_ids
     *
     * löscht DS für einen user und fügt DS für einen user bei Bedarf hinzu
     */
    public static function saveRollenidsByUser(User $user, array $rollen_ids): void
    {
        $mysqli = DB::connect();
        // vorhandene DS löschen, in denen die user_id vorkommt
        $stmt = $mysqli->prepare( "DELETE FROM rollenzuweisung WHERE user_id=?");
        $user_id = $user->getId();
        $stmt->bind_param("i",$user_id);
        $stmt->execute();

        // neue DS bei Bedarf einfügen
        $stmt = $mysqli->prepare( "INSERT INTO rollenzuweisung VALUES(NULL, ?,?)");
        foreach ($rollen_ids as $rolle_id){
            $user_id = $user->getId();
            $stmt->bind_param("ii", $user_id, $rolle_id);
            $stmt->execute();
        }
    }
}