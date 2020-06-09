<?php

namespace Gupalo\NamecomClient\Entity;

use Gupalo\NamecomClient\Helper\JsonHelper;
use JsonSerializable;

/**
 * @link https://www.name.com/api-docs/Domains#ListDomains
 */
class ListDomains implements JsonSerializable
{
    /** Domains is the list of domains in your account. */
    private Domains $domains;

    /**
     * NextPage is the identifier for the next page of results.
     * It is only populated if there is another page of results after the current page.
     */
    private ?int $nextPage;

    /**
     * LastPage is the identifier for the final page of results.
     * It is only populated if there is another page of results after the current page.
     */
    private ?int $lastPage;

    public function __construct(
        Domains $domains,
        int $nextPage = null,
        int $lastPage = null
    ) {
        $this->domains = $domains;
        $this->nextPage = $nextPage;
        $this->lastPage = $lastPage;
    }

    public static function create($data): self
    {
        $data = JsonHelper::toArray($data);

        return new self(
            Domains::create($data['domains']),
            isset($data['nextPage']) ? (int)$data['nextPage'] : null,
            isset($data['lastPage']) ? (int)$data['lastPage'] : null
        );
    }

    public function jsonSerialize(): array
    {
        $result = [
            'domains' => $this->domains->jsonSerialize(),
        ];
        if (isset($this->nextPage)) {
            $result['nextPage'] = $this->nextPage;
        }
        if (isset($this->lastPage)) {
            $result['lastPage'] = $this->lastPage;
        }

        return $result;
    }

    public function getDomains(): Domains
    {
        return $this->domains;
    }

    public function getNextPage(): int
    {
        return $this->nextPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }
}
