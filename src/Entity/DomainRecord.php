<?php

namespace Gupalo\NamecomClient\Entity;

use Gupalo\NamecomClient\Helper\JsonHelper;
use JsonSerializable;

/**
 * @link https://www.name.com/api-docs/types/record
 */
class DomainRecord implements JsonSerializable
{
    public const TYPE_A = 'A';
    public const TYPE_AAAA = 'AAAA';
    public const TYPE_ANAME = 'ANAME';
    public const TYPE_CNAME = 'CNAME';
    public const TYPE_MX = 'MX';
    public const TYPE_NS = 'NS';
    public const TYPE_SRV = 'SRV';
    public const TYPE_TXT = 'TXT';

    /** (readonly) Unique record id. Value is ignored on Create, and must match the URI on Update. */
    private ?int $id;

    /** (readonly) DomainName is the zone that the record belongs to. */
    private string $domainName;

    /**
     * Host is the hostname relative to the zone:
     * e.g. for a record for blog.example.org, domain would be "example.org" and host would be "blog".
     * An apex record would be specified by either an empty host "" or "@".
     * A SRV record would be specified by "_{service}._{protocal}.{host}":
     * e.g. "_sip._tcp.phone" for _sip._tcp.phone.example.org.
     */
    private string $host;

    /**
     * (readonly) FQDN is the Fully Qualified Domain Name. It is the combination of the host and the domain name.
     * It always ends in a ".". FQDN is ignored in CreateRecord, specify via the Host field instead.
     */
    private ?string $fdqn;

    /**
     * Type is one of the following: A, AAAA, ANAME, CNAME, MX, NS, SRV, or TXT.
     * Use DomainRecord::TYPE_*
     */
    private string $type;

    /**
     * Answer is either the IP address for A or AAAA records;
     * the target for ANAME, CNAME, MX, or NS records; the text for TXT records.
     * For SRV records, answer has the following format: "{weight} {port} {target}" e.g. "1 5061 sip.example.org".
     */
    private string $answer;

    /** TTL is the time this record can be cached for in seconds. Name.com allows a minimum TTL of 300, or 5 minutes. */
    private ?int $ttl;

    /** Priority is only required for MX and SRV records, it is ignored for all others. */
    private ?int $priority;

    public function __construct(
        ?int $id,
        string $domainName,
        string $host,
        ?string $fdqn,
        string $type,
        string $answer,
        ?int $ttl,
        ?int $priority
    ) {
        $this->id = $id;
        $this->domainName = $domainName;
        $this->host = $host;
        $this->fdqn = $fdqn;
        $this->type = $type;
        $this->answer = $answer;
        $this->ttl = $ttl;
        $this->priority = $priority;
    }

    public static function create($data): self
    {
        $data = JsonHelper::toArray($data);

        return new self(
            (isset($data['id'])) ? (int)$data['id'] : null,
            $data['domainName'],
            $data['host'],
            $data['fdqn'] ?? null,
            $data['type'],
            $data['answer'],
            (isset($data['ttl'])) ? (int)$data['ttl'] : null,
            (isset($data['priority'])) ? (int)$data['priority'] : null,
        );
    }

    public function jsonSerialize(): array
    {
        $result = [
            'id' => $this->id,
            'domainName' => $this->domainName,
            'host' => $this->host,
            'fdqn' => $this->fdqn,
            'type' => $this->type,
            'answer' => $this->answer,
            'ttl' => $this->ttl,
            'priority' => $this->priority,
        ];

        $optionalFields = ['id', 'fdqn', 'ttl', 'priority'];
        foreach ($optionalFields as $field) {
            if ($result[$field] === null) {
                unset($result[$field]);
            }
        }

        return $result;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getFdqn(): ?string
    {
        return $this->fdqn;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getTtl(): ?int
    {
        return $this->ttl;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }
}
