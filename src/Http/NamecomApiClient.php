<?php

namespace Gupalo\NamecomClient\Http;

use Gupalo\NamecomClient\Entity\Domain;
use Gupalo\NamecomClient\Entity\DomainRecord;
use Gupalo\NamecomClient\Entity\DomainRecords;
use Gupalo\NamecomClient\Entity\ListDomains;
use Throwable;

class NamecomApiClient
{
    private const PATH_LIST_DOMAINS = '/domains';
    private const PATH_GET_DOMAIN = '/domains/{domainName}';
    private const PATH_SET_NAMESERVERS = '/domains/{domainName}:setNameservers';
    private const PATH_LIST_RECORDS = '/domains/{domainName}/records';
    private const PATH_GET_RECORD = '/domains/{domainName}/records/{id}';
    private const PATH_CREATE_RECORD = '/domains/{domainName}/records'; // POST
    private const PATH_UPDATE_RECORD = '/domains/{domainName}/records/{id}'; // PUT
    private const PATH_DELETE_RECORD = '/domains/{domainName}/records/{id}'; // DELETE

    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * ListDomains returns all domains in the account. It omits some information that can be retrieved from GetDomain.
     * @link https://www.name.com/api-docs/Domains#ListDomains
     *
     * @param int $page
     * @param int $perPage
     * @return ListDomains
     * @throws Throwable
     */
    public function listDomains(int $page = 1, int $perPage = 1000): ListDomains
    {
        return ListDomains::create($this->apiClient->get(self::PATH_LIST_DOMAINS, [
            'perPage' => $perPage,
            'page' => $page,
        ]));
    }

    /**
     * GetDomain returns details about a specific domain
     * @link https://www.name.com/api-docs/Domains#GetDomain
     *
     * @param string $domainName
     * @return Domain
     * @throws Throwable
     */
    public function getDomain(string $domainName): Domain
    {
        $url = str_replace('{domainName}', $domainName, self::PATH_GET_DOMAIN);

        return Domain::create($this->apiClient->get($url));
    }

    /**
     * SetNameservers will set the nameservers for the Domain.
     * @link https://www.name.com/api-docs/Domains#SetNameservers
     *
     * @param string $domainName
     * @param string[] $nameservers
     * @return Domain
     * @throws Throwable
     */
    public function setNameservers(string $domainName, array $nameservers): Domain
    {
        $url = str_replace('{domainName}', $domainName, self::PATH_SET_NAMESERVERS);

        return Domain::create($this->apiClient->post($url, [
            'nameservers' => $nameservers,
        ]));
    }

    /**
     * ListDomains returns all domains in the account. It omits some information that can be retrieved from GetDomain.
     * @link https://www.name.com/api-docs/DNS#ListRecords
     *
     * @param int $page
     * @param int $perPage
     * @return DomainRecords
     * @throws Throwable
     */
    public function listRecords(int $page = 1, int $perPage = 1000): DomainRecords
    {
        return DomainRecords::create($this->apiClient->get(self::PATH_LIST_RECORDS, [
            'perPage' => $perPage,
            'page' => $page,
        ]));
    }

    /**
     * GetRecord returns details about an individual record.
     * @link https://www.name.com/api-docs/DNS#GetRecord
     *
     * @param string $domainName
     * @param int $recordId
     * @return DomainRecord
     * @throws Throwable
     */
    public function getDomainRecord(string $domainName, int $recordId): DomainRecord
    {
        $url = str_replace(['{domainName}', '{id}'], [$domainName, $recordId], self::PATH_GET_RECORD);

        return DomainRecord::create($this->apiClient->get($url));
    }

    /**
     * CreateRecord creates a new record in the zone.
     * @link https://www.name.com/api-docs/DNS#CreateRecord
     *
     * @param DomainRecord $domainRecord
     * @return DomainRecord
     * @throws Throwable
     */
    public function createDomainRecord(DomainRecord $domainRecord): DomainRecord
    {
        $url = str_replace('{domainName}', $domainRecord->getDomainName(), self::PATH_CREATE_RECORD);

        return DomainRecord::create($this->apiClient->post($url, $domainRecord));
    }

    /**
     * UpdateRecord replaces the record with the new record that is passed.
     * @link https://www.name.com/api-docs/DNS#UpdateRecord
     *
     * @param DomainRecord $domainRecord
     * @return DomainRecord
     * @throws Throwable
     */
    public function updateDomainRecord(DomainRecord $domainRecord): DomainRecord
    {
        $url = str_replace(
            ['{domainName}', '{id}'],
            [$domainRecord->getDomainName(), $domainRecord->getId()],
            self::PATH_UPDATE_RECORD
        );

        return DomainRecord::create($this->apiClient->put($url));
    }

    /**
     * DeleteRecord deletes a record from the zone.
     * @link https://www.name.com/api-docs/DNS#DeleteRecord
     *
     * @param DomainRecord $domainRecord
     * @throws Throwable
     */
    public function deleteDomainRecord(DomainRecord $domainRecord): void
    {
        $url = str_replace(
            ['{domainName}', '{id}'],
            [$domainRecord->getDomainName(), $domainRecord->getId()],
            self::PATH_DELETE_RECORD
        );

        $this->apiClient->delete($url);
    }
}
