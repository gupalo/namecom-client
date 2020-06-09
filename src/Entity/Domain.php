<?php

namespace Gupalo\NamecomClient\Entity;

use DateTimeInterface;
use Gupalo\DateUtils\DateUtils;
use Gupalo\NamecomClient\Helper\JsonHelper;

/**
 * @link https://www.name.com/api-docs/types/domain
 */
class Domain
{
    /** DomainName is the punycode encoded value of the domain name. */
    private string $domainName;

    /**
     * Nameservers is the list of nameservers for this domain. If unspecified it defaults to your account default nameservers.
     * @var string[]|null
     */
    private ?array $nameservers;

    /** Contacts for the domain. */
    private ?Contacts $contacts;

    /** PrivacyEnabled reflects if Whois Privacy is enabled for this domain. */
    private ?bool $privacyEnabled;

    /** Locked indicates that the domain cannot be transfered to another registrar. */
    private bool $locked;

    /** AutorenewEnabled indicates if the domain will attempt to renew automatically before expiration. */
    private bool $autorenewEnabled;

    /** (readonly) ExpireDate is the date the domain will expire. */
    private DateTimeInterface $expireDate;

    /** (readonly) CreateDate is the date the domain was created at the registry. */
    private DateTimeInterface $createDate;

    /** (readonly) RenewalPrice is the price to renew the domain. It may be required for the RenewDomain command. */
    private ?float $renewalPrice;

    public function __construct(
        string $domainName,
        ?array $nameservers,
        ?Contacts $contacts,
        ?bool $privacyEnabled,
        bool $locked,
        bool $autorenewEnabled,
        DateTimeInterface $expireDate,
        DateTimeInterface $createDate,
        ?float $renewalPrice
    ) {
        $this->domainName = $domainName;
        $this->nameservers = $nameservers;
        $this->contacts = $contacts;
        $this->privacyEnabled = $privacyEnabled;
        $this->locked = $locked;
        $this->autorenewEnabled = $autorenewEnabled;
        $this->expireDate = $expireDate;
        $this->createDate = $createDate;
        $this->renewalPrice = $renewalPrice;
    }

    public static function create($data): self
    {
        $data = JsonHelper::toArray($data);

        return new self(
            $data['domainName'],
            $data['nameservers'] ?? null,
            isset($data['contacts']) ? Contacts::create($data['contacts']) : null,
            isset($data['privacyEnabled']) ? (bool)$data['privacyEnabled'] : null,
            (bool)$data['locked'],
            (bool)$data['autorenewEnabled'],
            DateUtils::create($data['expireDate']),
            DateUtils::create($data['createDate']),
            isset($data['renewalPrice']) ? (float)$data['renewalPrice'] : null,
        );
    }

    public function jsonSerialize(): array
    {
        $result = [
            'domainName' => $this->domainName,
            'nameservers' => $this->nameservers,
            'contacts' => $this->contacts ? $this->contacts->jsonSerialize() : null,
            'privacyEnabled' => $this->privacyEnabled,
            'locked' => $this->locked,
            'autorenewEnabled' => $this->autorenewEnabled,
            'expireDate' => $this->expireDate,
            'createDate' => $this->createDate,
            'renewalPrice' => $this->renewalPrice,
        ];

        $optionalFields = ['nameservers', 'contacts', 'privacyEnabled', 'renewalPrice'];
        foreach ($optionalFields as $field) {
            if ($result[$field] === null) {
                unset($result[$field]);
            }
        }

        return $result;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getNameservers(): ?array
    {
        return $this->nameservers;
    }

    public function getContacts(): ?Contacts
    {
        return $this->contacts;
    }

    public function getPrivacyEnabled(): ?bool
    {
        return $this->privacyEnabled;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function isAutorenewEnabled(): bool
    {
        return $this->autorenewEnabled;
    }

    public function getExpireDate(): DateTimeInterface
    {
        return $this->expireDate;
    }

    public function getCreateDate(): DateTimeInterface
    {
        return $this->createDate;
    }

    public function getRenewalPrice(): ?float
    {
        return $this->renewalPrice;
    }
}
