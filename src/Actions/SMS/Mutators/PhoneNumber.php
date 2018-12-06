<?php

namespace Syzn\MicropayClient\Actions\SMS\Mutators;

class PhoneNumber
{
    public static function clean($value)
    {
        // strip spaces and dashes
        return str_replace(
            ' ',
            '',
            str_replace('-', '', $value)
        );
    }
}
