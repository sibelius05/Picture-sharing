<?php

class Session
{
    private string $sessionId;
    private string $username;
    private string $user_Id;
    private string $timeSince;
    private string $timeLast;
    private int $active;

    /**
     * @param string $sessionId
     * @param string $username
     * @param string $user_Id
     * @param string $timeSince
     * @param string $timeLast
     * @param int $active
     */
    public function __construct(string $sessionId, string $username, string $user_Id, string $timeSince, string $timeLast, int $active)
    {
        $this->sessionId = $sessionId;
        $this->username = $username;
        $this->user_Id = $user_Id;
        $this->timeSince = $timeSince;
        $this->timeLast = $timeLast;
        $this->active = $active;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
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
    public function getUserId(): string
    {
        return $this->user_Id;
    }

    /**
     * @param string $user_Id
     */
    public function setUserId(string $user_Id): void
    {
        $this->user_Id = $user_Id;
    }

    /**
     * @return string
     */
    public function getTimeSince(): string
    {
        return $this->timeSince;
    }

    /**
     * @param string $timeSince
     */
    public function setTimeSince(string $timeSince): void
    {
        $this->timeSince = $timeSince;
    }

    /**
     * @return string
     */
    public function getTimeLast(): string
    {
        return $this->timeLast;
    }

    /**
     * @param string $timeLast
     */
    public function setTimeLast(string $timeLast): void
    {
        $this->timeLast = $timeLast;
    }

    public function save(): void
    {
        $this->update();
    }

    private function update(): void
    {
        $mysqli = DB::connect();

        $sql = "DELETE FROM session WHERE timeLast < ?";
        $stmt = $mysqli->prepare($sql);
        $currentTiming = time() - 86400;
        $stmt->bind_param("i", $currentTiming);
        $stmt->execute();

        $sql = "UPDATE session SET active = 0 WHERE sessionId NOT LIKE ? AND username LIKE ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $this->sessionId, $this->username);
        $stmt->execute();

        $sql = "REPLACE INTO session(sessionId, username, user_Id, timeSince, timeLast, active) VALUES( ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssissi", $this->sessionId, $this->username, $this->user_Id, $this->timeSince, $this->timeLast, $this->active);
        $stmt->execute();
    }

    public function delete(): bool
    {
        $mysqli = DB::connect();
        $sql = "DELETE FROM session WHERE sessionId LIKE ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $this->sessionId);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function getCurrentSession(string $sessionId): mixed
    {
        $mysqli = DB::connect();
        $sql = "SELECT * FROM session WHERE sessionId LIKE ? AND active = 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $sessionId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1)
        {
            $row = mysqli_fetch_assoc($result);

            $session = new Session($row['sessionId'], $row['username'], $row['user_Id'], $row['timeSince'], $row['timeLast'], $row['active']);
        }
        else
        {
            return false;
        }

        return $session;
    }
}