<?php

namespace Gupalo\NamecomClient\Entity;

use Gupalo\NamecomClient\Helper\JsonHelper;
use JsonSerializable;

class DomainRecords implements JsonSerializable
{
    /** @var DomainRecord[] */
    private array $records;

    /**
     * @param DomainRecord[] $records
     */
    public function __construct(array $records)
    {
        $this->records = $records;
    }

    public static function create($data): self
    {
        $data = JsonHelper::toArray($data);

        return new self(
            array_map(fn($a) => DomainRecord::create($a), $data)
        );
    }

    public function jsonSerialize(): array
    {
        return array_map(fn(DomainRecord $a) => $a->jsonSerialize(), $this->records);
    }

    /**
     * @return DomainRecord[]
     */
    public function all(): array
    {
        return $this->records;
    }
}
