<?php

namespace App\Models;

use App\Interfaces\ReportInterface;

class NotAssignedReport implements ReportInterface
{
    const UNIQUE_PARAMS = [];

    public int $number;

    public string $description;

    public string $type;

    public ?string $visitDate = null;

    public ?string $status = null;

    public ?string $recommendations = null;

    public ?string $contactNumber = null;

    public \DateTime $creationDate;

    public function __construct()
    {
        $this->setCreationDate(new \DateTime());
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setVisitDate(?string $visitDate): void
    {
        $this->visitDate = date('Y-m-d', strtotime($visitDate));
    }

    public function getVisitDate(): string|null
    {
        return $this->visitDate;
    }

    public function setContactNumber(?string $contactNumber): void
    {
        $this->contactNumber = $contactNumber;
    }

    public function getContactNumber(): ?string
    {
        return $this->contactNumber;
    }

    public function setCreationDate(\DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    public function getRecommendations(): ?string
    {
        return $this->recommendations;
    }

    public function setRecommendations(?string $recommendations): void
    {
        $this->recommendations = $recommendations;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
