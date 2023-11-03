<?php

namespace App\Interfaces;

interface ReportInterface
{
    /**
     *
     * @var array
     */
    public const UNIQUE_PARAMS = [];

    public function setDescription(string $description): void;

    public function getDescription(): string;

    public function setType(string $type): void;

    public function getType(): string;

    public function setStatus(string $status): void;

    public function getStatus(): string;

    public function setVisitDate(?string $visitDate): void;

    public function getVisitDate(): string|null;

    public function setContactNumber(?string $contactNumber): void;

    public function getContactNumber(): ?string;

    public function setCreationDate(\DateTime $createdAt): void;

    public function getCreationDate(): \DateTime;

}
