<?php

namespace App\Entity;

use App\Repository\FormRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Attributes as OA;


#[ORM\Entity(repositoryClass: FormRepository::class)]
#[OA\Schema(
    schema: "Form",
    title: "Form",
    description: "A form entity",
    required: ["title", "level", "creadtedByUser"],
    properties: [
        new OA\Property(property: 'id', type: 'int', example: 1234),
        new OA\Property(property: 'title', type: 'string', example: 'Title of form'),
        new OA\Property(property: 'description', type: 'text', example: 'My descrpition form'),
        new OA\Property(property: 'level', ref: '#/components/schemas/Level'),
        new OA\Property(property: 'creadtedByUser', ref: '#/components/schemas/User'),
    ],
)]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToOne(targetEntity: Level::class, inversedBy: 'forms')]
    #[ORM\JoinColumn(name: 'level_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['user:read'])]
    private ?Level $level = null;

    #[ORM\ManyToOne(inversedBy: 'forms')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read'])]
    private ?User $createdByUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getCreatedByUser(): ?User
    {
        return $this->createdByUser;
    }

    public function setCreatedByUser(?User $createdByUser): static
    {
        $this->createdByUser = $createdByUser;

        return $this;
    }
}
