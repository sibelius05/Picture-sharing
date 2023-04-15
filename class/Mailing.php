<?php

class Mailing
{
    static function fetchContent(string $content, string $email, string $firstname, string $lastname, array $vars): string
    {
        $var = $vars;
        $email = $email;
        $firstname = $firstname;
        $lastname = $lastname;

        $text = '';

        include "templates/" . $content;

        return $text;
    }

    static function sendMail(string $email, string $firstname, string $lastname, string $content, array $vars, string $subject="Nachricht von halbanalog.de"): void
    {
        require_once "Mail.php";

        $_mailbox = Mail::factory('smtp', array(
            'host' => SMTP_HOST,
            'port' => SMTP_PORT,
            'auth' => true,
            'username' => MAIL_USER,
            'password' => MAIL_PASSWD
        ));

        $_boundary1 = '----=_Part_' . rand(1000000, 9999999) . '_' . rand(1000000000, 9999999999) . '.' . rand(1000000000000, 9999999999999);

        $_boundary2 = '----=_Part_' . rand(1000000, 9999999) . '_' . rand(1000000000, 9999999999) . '.' . rand(1000000000000, 9999999999999);

        $_headers = array(
            'From' => 'Ulrich Grefe<ulrich.grefe@halbanalog.info>',
            'To' => '=?UTF-8?Q?' . quoted_printable_encode($firstname . ' ' . $lastname) . '?= <' . $email . '>',
            'Subject' => $subject,
            'MIME-Version' => '1.0',
            'Content-Type' => 'multipart/mixed; boundary=' . $_boundary1,
            'X-Priority' => '3',
            'Importance' => 'Normal',
            'X-Mailer' => 'Open-Xchange Mailer v7.10.6-Rev22',
            'X-Originating-Client' => 'open-xchange-appsuite'
        );

        $output = self::fetchContent($content, $email, $firstname, $lastname, $vars);

        $_inline_txt = strip_tags($output);

        $_inline_html = $output;

        $_eml_body = <<<HDS
--{$_boundary1}
Content-Type: multipart/alternative; 
	boundary="{$_boundary2}"

--{$_boundary2}
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: quoted-printable

{$_inline_txt}
--{$_boundary2}
MIME-Version: 1.0
Content-Type: text/html; charset=UTF-8
Content-Transfer-Encoding: quoted-printable

{$_inline_html}

--{$_boundary2}--

--{$_boundary1}--
HDS;

        $_to_eml = $_headers['To'];

        $_mailbox->send($_to_eml, $_headers, $_eml_body);
    }
}