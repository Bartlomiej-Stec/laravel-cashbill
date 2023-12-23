<?php

namespace Barstec\Cashbill;

class PersonalData
{
    private ?string $firstName;
    private ?string $surname;
    private ?string $email;
    private ?string $country;
    private ?string $city;
    private ?string $postcode;
    private ?string $street;
    private ?string $house;
    private ?string $flat;
    private ?string $ip;

    public function __construct(
        ?string $firstName=null,
        ?string $surname=null,
        ?string $email=null,
        ?string $country=null,
        ?string $city=null,
        ?string $postcode=null,
        ?string $street=null,
        ?string $house=null,
        ?string $flat=null,
        ?string $ip=null
    ) {
        $this->firstName = $firstName;
        $this->surname = $surname;
        $this->email = $email;
        $this->country = $country;
        $this->city = $city;
        $this->postcode = $postcode;
        $this->street = $street;
        $this->house = $house;
        $this->flat = $flat;
        $this->ip = $ip;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function setPostcode(?string $postcode): void
    {
        $this->postcode = $postcode;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    public function setHouse(?string $house): void
    {
        $this->house = $house;
    }

    public function setFlat(?string $flat): void
    {
        $this->flat = $flat;
    }

    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getHouse(): ?string
    {
        return $this->house;
    }

    public function getFlat(): ?string
    {
        return $this->flat;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getAll(): array
    {
        return get_object_vars($this);
    }

    public function getStringified(): string
    {
        return join($this->getAll(), "");
    }
}
