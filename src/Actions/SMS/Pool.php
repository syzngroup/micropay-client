<?php

namespace Syzn\MicropayClient\Actions\SMS;

use Syzn\MicropayClient\SMS\SMS;

class Pool extends SMS
{
    /**
     * @var int
     */
    protected $pool_id;

    /**
     * Initialize new pool sms instance
     *
     * @param int $pool_id
     */
    public function __construct(int $pool_id)
    {
        $this->pool_id = $pool_id;
    }

    /**
     * Retrieve pool id
     */
    public function getPoolID(): int
    {
        return $this->pool_id;
    }

    /**
     * Retrieve action's values
     *
     * @return array
     */
    public function getValues(): array
    {
        $values = parent::getValues();
        $values['pid'] = $this->getPoolID();

        return $values;
    }
}
