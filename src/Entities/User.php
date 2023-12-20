<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "users")]
#[ORM\Entity]
class User
{
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue] #[ORM\Id]
    private int $id = 0;

    #[ORM\Column(type: "string")]
    private string $name = '';

    #[ORM\Column(type: "string")]
    private string $email = '';

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
