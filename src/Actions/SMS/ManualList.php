<?php

namespace Syzn\MicropayClient\Actions\SMS;

use Syzn\MicropayClient\Actions\SMS\SMS;
use Syzn\MicropayClient\Actions\SMS\Mutators\PhoneNumber;

class ManualList extends SMS
{
    /**
     * @var int
     */
    protected $list;

    /**
     * Initialize new list sms instance
     *
     * @param array $list
     */
    public function __construct(array $list = [])
    {
        $this->list = $list;
    }

    /**
     * Add number to the list
     *
     * @param string $number
     *
     * @return Syzn\MicropayClient\SMS\List
     */
    public function add(string $number): ManualList
    {
        $this->list[] = PhoneNumber::clean($number);
        return $this;
    }

    /**
     * Retrieve the list of recipients
     *
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * Retrieve action's values
     *
     * @return array
     */
    public function getValues(): array
    {
        $values = parent::getValues();
        $values['list'] = implode(',', $this->getList());

        return $values;
    }
}
