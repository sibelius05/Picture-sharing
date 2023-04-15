<?php

abstract class Abstracts
{
    public static function newHash($value): string
    {
        return md5($value);
    }

    public static function proofPassword(string $password): bool
    {
        $length = strlen($password);

        $z = false; $ziffern = implode(range(0, 9));

        $k = false; $kleinbuchstaben = implode(range('a', 'z'));

        $g = false; $grossbuchstaben = implode(range('A', 'Z'));

        $s = false; $sonderzeichen = SPECIAL_CHARS;

        $a = false;

        if ($length > 9)
        {
            $a = true;

            for($i = 0; $i < $length; $i++)
            {
                if(strpos($ziffern, $password[$i])) $z |= true;

                if(strpos($kleinbuchstaben, $password[$i])) $k |= true;

                if(strpos($grossbuchstaben, $password[$i])) $g |= true;

                if(strpos($sonderzeichen, $password[$i])) $s |= true;

                if(!strpos($ziffern . $kleinbuchstaben . $grossbuchstaben . $sonderzeichen, $password[$i])) $a &= false;
            }
        }

        return $z & $k & $g & $s & $a;
    }

    public static function encrypt(string $str): array
    {
        $key = openssl_random_pseudo_bytes(32);

        $plaintext = $str;
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");

        do
        {
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
            $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
        } while (strstr($ciphertext, '/') != false || strstr($ciphertext, '+') != false);

        $arr = array($ciphertext, base64_encode($key));

        return $arr;
    }

    public static function decrypt(string $str, string $key): string
    {
        $str = base64_decode($str) ?? '';
        $key = base64_decode($key) ?? '';

        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($str, 0, $ivlen);
        $hmac = substr($str, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($str, $ivlen + $sha2len);

        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);

        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);

        return $original_plaintext;
    }
}