<?php

namespace RKocak\Gravatar\Traits;

use RKocak\Gravatar\Facades\Gravatar;
use RKocak\Gravatar\Generator;

trait HasGravatar
{
    /**
     * @return string
     */
    public function getGravatar(): string
    {
        return Gravatar::url($this->email);
    }

    /**
     * @return Generator
     */
    public function getGravatarGenerator(): Generator
    {
        return Gravatar::for($this->email);
    }
}
