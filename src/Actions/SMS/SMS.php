<?php

namespace Syzn\MicropayClient\Actions\SMS;

use Exception;
use Syzn\MicropayClient\Interfaces\ActionInterface;
use Syzn\MicropayClient\Actions\SMS\Mutators\PhoneNumber;

abstract class SMS implements ActionInterface
{
    const ENDPOINT_URI = 'ScheduleSms.php';

    private $required_properties = [
        'message',
        'charset',
        'from',
        'method'
    ];

    private $allowed_methods = [
        'get',
        'post'
    ];

    private $allowed_charsets = [
        'iso-8859-8',
        'utf-8'
    ];

    protected $message;
    protected $charset = 'utf-8';
    protected $from;
    protected $method;

    /**
     * Retrieve sms body, url decoded
     *
     * @return string;
     */
    public function getMessage(): string
    {
        return urldecode($this->message);
    }

    /**
     * Set sms body
     *
     * @param string message
     *
     * @return Syzn\MicropayClient\Actions\SMS\SMS
     */
    public function setMessage(string $message): SMS
    {
        $this->message = urlencode($message);
        return $this;
    }

    /**
     * Retrieve sms charset
     *
     * @return string;
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * Set sms charset
     *
     * @param enum(iso-8859-8|utf-8) $charset
     *
     * @return Syzn\MicropayClient\Actions\SMS\SMS
     */
    public function setCharset(string $charset): SMS
    {
        if (!in_array($charset, $this->allowed_charsets)) {
            // throw BadValue exception
        }

        $this->charset = $charset;
        return $this;
    }

    /**
     * Retrieve sender's number
     *
     * @return string;
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * Set sender's number
     *
     * @param string $from
     *
     * @return Syzn\MicropayClient\Actions\SMS\SMS
     */
    public function setFrom(string $from): SMS
    {
        $this->from = PhoneNumber::clean($from);
        return $this;
    }

    /**
     * Retrieve sms request method
     *
     * @return string;
     */
    public function getMethod(): string
    {
        return strtolower($this->method);
    }

    /**
     * Set sms request method
     *
     * @param enum(get|post) $method
     *
     * @return Syzn\MicropayClient\Actions\SMS\SMS
     */
    public function setMethod(string $method): SMS
    {
        if (!in_array($method, $this->allowed_methods)) {
            // throw BadValue exception
        }

        $this->method = $method;
        return $this;
    }

    /**
     * Retrieve action's values
     *
     * @return array
     */
    public function getValues(): array
    {
        foreach ($this->required_properties as $required) {
            if (!$this->$required) {
                // throw MissingRequiredField exception
            }
        }

        $method = $this->getMethod();

        return [
            'msg' => $this->getMessage(),
            'from' => $this->getFrom(),
            'charset' => $this->getCharset(),
            $method => $this->getMethodValue($method)
        ];
    }

    /**
     * Retrieve action's endpoint uri
     *
     * @return string
     */
    public static function getEndpointUri(): string
    {
        return self::ENDPOINT_URI;
    }

    /**
     * Retrieve method numeric value
     *
     * @param string $method
     *
     * @return int
     */
    private function getMethodValue(string $method): int
    {
        return $method == 'get' ? 1 : 2;
    }
}
