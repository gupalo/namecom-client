<?php

namespace Gupalo\NamecomClient\Entity;

use Gupalo\NamecomClient\Helper\JsonHelper;
use JsonSerializable;

class Domains implements JsonSerializable
{
    /** @var Domain[] */
    private array $domains;

    /**
     * @param Domain[] $domains
     */
    public function __construct(array $domains)
    {
        $this->domains = $domains;
    }

    public static function create($data): self
    {
        $data = JsonHelper::toArray($data);

        return new self(
            array_map(fn($a) => Domain::create($a), $data)
        );
    }

    public function jsonSerialize(): array
    {
        return array_map(fn(Domain $a) => $a->jsonSerialize(), $this->domains);
    }

    /**
     * @return Domain[]
     */
    public function all(): array
    {
        return $this->domains;
    }
}
