<?php

namespace Gupalo\NamecomClient\Helper;

use JsonSerializable;
use RuntimeException;
use Throwable;

class JsonHelper
{
    /**
     * @param array|string|JsonSerializable|null $data
     * @return array
     */
    public static function toArray($data = null): array
    {
        if ($data === null) {
            $data = [];
        }

        if (is_string($data)) {
            try {
                $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
            } catch (Throwable $e) {
                throw new RuntimeException($e->getMessage());
            }
        } elseif ($data instanceof JsonSerializable) {
            $data = $data->jsonSerialize();
        }

        return $data;
    }
}
