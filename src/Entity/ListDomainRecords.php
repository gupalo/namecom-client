<?php

namespace Gupalo\NamecomClient\Entity;

use Gupalo\NamecomClient\Helper\JsonHelper;
use JsonSerializable;

/**
 * @link https://www.name.com/api-docs/DNS#ListRecords
 */
class ListDomainRecords implements JsonSerializable
{
    /** Records contains the records in the zone */
    private DomainRecords $domainRecords;

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
        DomainRecords $domainRecords,
        int $nextPage = null,
        int $lastPage = null
    ) {
        $this->domainRecords = $domainRecords;
        $this->nextPage = $nextPage;
        $this->lastPage = $lastPage;
    }

    public static function create($data): self
    {
        $data = JsonHelper::toArray($data);

        return new self(
            DomainRecords::create($data['records']),
            isset($data['nextPage']) ? (int)$data['nextPage'] : null,
            isset($data['lastPage']) ? (int)$data['lastPage'] : null
        );
    }

    public function jsonSerialize(): array
    {
        $result = [
            'records' => $this->domainRecords->jsonSerialize(),
        ];
        if (isset($this->nextPage)) {
            $result['nextPage'] = $this->nextPage;
        }
        if (isset($this->lastPage)) {
            $result['lastPage'] = $this->lastPage;
        }

        return $result;
    }

    public function getDomainRecords(): DomainRecords
    {
        return $this->domainRecords;
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
