<?php

namespace Gupalo\NamecomClient\Entity;

use Gupalo\NamecomClient\Helper\JsonHelper;
use JsonSerializable;

class Contacts implements JsonSerializable
{
    /**
     * Registrant is the rightful owner of the account and has the right to use and/or sell the domain name.
     * They are able to make changes to all account, domain, and product settings.
     * This information should be reviewed and updated regularly to ensure accuracy.
     */
    private Contact $registrant;

    /**
     * Registrants often designate an administrative contact to manage their domain name(s).
     * They primarily deal with business information such as the name on record, postal address,
     * and contact information for the official registrant.
     */
    private Contact $admin;

    /**
     * The technical contact manages and maintains a domain’s nameservers. If you’re working with a web designer or
     * someone in a similar role, you many want to assign them as a technical contact.
     */
    private Contact $tech;

    /**
     * The billing contact is the party responsible for paying bills for the account and taking care of renewals.
     */
    private Contact $billing;

    public function __construct(
        Contact $registrant,
        Contact $admin,
        Contact $tech,
        Contact $billing
    ) {
        $this->registrant = $registrant;
        $this->admin = $admin;
        $this->tech = $tech;
        $this->billing = $billing;
    }

    public static function create($data): self
    {
        $data = JsonHelper::toArray($data);

        return new self(
            Contact::create($data['registrant']),
            Contact::create($data['admin']),
            Contact::create($data['tech']),
            Contact::create($data['billing'])
        );
    }

    public function jsonSerialize(): array
    {
        return array_map(fn(Contact $a) => $a->jsonSerialize(), $this->all());
    }

    /**
     * @return Contact[]
     */
    public function all(): array
    {
        return [
            'registrant' => $this->registrant,
            'admin' => $this->admin,
            'tech' => $this->tech,
            'billing' => $this->billing,
        ];
    }

    public function getRegistrant(): Contact
    {
        return $this->registrant;
    }

    public function getAdmin(): Contact
    {
        return $this->admin;
    }

    public function getTech(): Contact
    {
        return $this->tech;
    }

    public function getBilling(): Contact
    {
        return $this->billing;
    }
}
