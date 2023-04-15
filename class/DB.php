<?php

class DB
{
    private static $DB;

    /**
     * @return mysqli
     */
    public static function connect()
    {
        if (!isset(self::$DB))
        {
            try
            {
                self::$DB = new mysqli(DB_SERVER, DB_USER, DB_PASSWD, DB_NAME);

                if (strlen(self::$DB->connect_error) > 0)
                {
                    // im Fehlerfall 'Datenbankverbindung klappt nicht', wird in die log-Datei geschrieben
                    $dateStr = (new DateTime('now', new DateTimeZone('Europe/Berlin')))->format('Y-m-d H:i:s');

                    $errorText = $dateStr . ' ' . self::connect()->connect_error . ' ' . __FILE__ . ' in line: ' . __LINE__;

                    file_put_contents('errorlog/log.txt', $errorText . "\r\n", FILE_APPEND);

                    throw new Exception(self::$DB->connect_error);
                }
            }
            catch (Exception $e)
            {
                // Info für user
                throw new Exception("Keine Verbindung zur Datenbank.");
            }
        }

        return self::$DB;
    }
}