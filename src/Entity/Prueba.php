<?php

namespace App\Entity;

use App\Repository\PruebaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PruebaRepository::class)]
class Prueba
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $hola = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHola(): ?string
    {
        return $this->hola;
    }

    public function setHola(string $hola): static
    {
        $this->hola = $hola;

        return $this;
    }
}
