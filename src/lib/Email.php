<?php
namespace AutoTest\Lib;

use AutoTest\Config;

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class Email
{
    public $host;
    public $port;
    public $security;
    public $userName;
    public $password;
    public $from;

    public $driver;
    public $subject;
    public $receiver;
    public $body;

    public function __construct()
    {
        $fileMailPath = dirname(dirname(__DIR__)).'/config/email.php';
        $email = (new Config())->load($fileMailPath);
        
        $this->host = $email['host'];
        $this->port = $email['port'];
        $this->from = $email['from'];
        $this->security = null;
        $this->userName = $email['username'];
        $this->password = $email['password'];
        $this->driver = $email['driver'];
        $this->subject = $email['subject'];
        $this->receiver = $email['receiver'];
    }

    public function sendMail()
    {
       $transport = \Swift_SmtpTransport::newInstance($this->host,$this->port,$this->security)
            ->setUsername($this->userName)
            ->setPassword($this->password);

          $mailer =\Swift_Mailer::newInstance($transport);
          $message=\Swift_Message::newInstance()
              ->setSubject($this->subject)
              ->setFrom([$this->from['address'] => $this->from['name']])
              ->setTo($this->receiver)
              ->setContentType("text/html")
              ->setBody($this->body);

          $mailer->protocol = $this->driver;
          $mailer->send($message);
      }
}
