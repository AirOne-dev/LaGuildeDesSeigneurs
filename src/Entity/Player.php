<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 16)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 16,
    )]
    private $firstname;

    #[ORM\Column(type: 'string', length: 16)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 16,
    )]
    private $lastname;

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 64,
    )]
    private $email;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private $mirian;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $characterId;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    private $creationDate;

    #[ORM\Column(type: 'string', length: 40)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 40,
        max: 40,
    )]
    private $identifier;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    private $modification;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: Character::class)]
    private $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getMirian(): ?int
    {
        return $this->mirian;
    }

    public function setMirian(int $mirian): self
    {
        $this->mirian = $mirian;

        return $this;
    }

    public function getCharacterId(): ?int
    {
        return $this->characterId;
    }

    public function setCharacterId(int $characterId): self
    {
        $this->characterId = $characterId;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getModification(): ?\DateTimeInterface
    {
        return $this->modification;
    }

    public function setModification(\DateTimeInterface $modification): self
    {
        $this->modification = $modification;

        return $this;
    }

    /**
     * @return Collection|Character[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->setPlayer($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getPlayer() === $this) {
                $character->setPlayer(null);
            }
        }

        return $this;
    }
}
