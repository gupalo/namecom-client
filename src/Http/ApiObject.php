<?php

namespace Gupalo\NamecomClient\Http;

use JsonSerializable;

interface ApiObject extends JsonSerializable
{
    /**
     * @param array|string|JsonSerializable $data
     * @return static
     */
    public static function createFromJson($data): self;
}
