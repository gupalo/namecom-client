<?php

namespace Gupalo\NamecomClient\Entity;

use Gupalo\NamecomClient\Helper\JsonHelper;

/**
 * Domain Contact
 *
 * @link https://www.name.com/api-docs/types/domain
 */
class Contact
{
    /** @var string First name of the contact. */
    private string $firstName;

    /** @var string Last name of the contact. */
    private string $lastName;

    /** @var string Company name of the contact. Leave blank if the contact is an individual as some registries will assume it is a corporate entity otherwise. */
    private string $companyName;

    /** @var string Address1 is the first line of the contact's address. */
    private string $address1;

    /** @var string Address2 is the second line of the contact's address. */
    private string $address2;

    /** @var string City of the contact's address. */
    private string $city;

    /** @var string State or Province for the contact's address. */
    private string $state;

    /** @var string Zip or Postal Code for the contact's address. */
    private string $zip;

    /** @var string Country code for the contact's address. Required to be a ISO 3166-1 alpha-2 code. */
    private string $country;

    /** @var string Phone number of the contact. Should be specified in the following format: "+cc.llllllll" where cc is the country code and llllllll is the local number. */
    private string $phone;

    /** @var string Fax number of the contact. Should be specified in the following format: "+cc.llllllll" where cc is the country code and llllllll is the local number. */
    private string $fax;

    /** @var string Email of the contact. Should be a complete and valid email address. */
    private string $email;

    public function __construct(
        string $firstName,
        string $lastName,
        string $companyName,
        string $address1,
        string $address2,
        string $city,
        string $state,
        string $zip,
        string $country,
        string $phone,
        string $fax,
        string $email
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->companyName = $companyName;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->country = $country;
        $this->phone = $phone;
        $this->fax = $fax;
        $this->email = $email;
    }

    public static function create($data): self
    {
        $data = JsonHelper::toArray($data);

        return new self(
            $data['firstName'],
            $data['lastName'],
            $data['companyName'],
            $data['address1'],
            $data['address2'],
            $data['city'],
            $data['state'],
            $data['zip'],
            $data['country'],
            $data['phone'],
            $data['fax'],
            $data['email'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'companyName' => $this->companyName,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'country' => $this->country,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'email' => $this->email,
        ];
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getAddress1(): string
    {
        return $this->address1;
    }

    public function getAddress2(): string
    {
        return $this->address2;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getFax(): string
    {
        return $this->fax;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
