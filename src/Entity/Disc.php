<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DiscRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Artist;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity(repositoryClass: DiscRepository::class)]
#[ApiResource()]
class Disc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:comment:full'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:comment', 'read:comment:full'])]
    #[Regex('/^[A-Za-z0-9éèàçâêûîôäëüïö\ ]+$/')]
    #[NotBlank()]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    #[Regex('/^[A-Za-z0-9éèàçâêûîôäëüïö\ ]+$/')]
    #[NotBlank()]
    private ?string $label = null;

    #[ORM\Column]
    #[Regex('/^[0-9]{4}$/')]
    #[NotBlank()]
    private ?int $year = null;

    #[ORM\ManyToOne(inversedBy: 'discs')]
    private ?artist $artist = null;

    #[ORM\Column(length: 255)]
    #[Regex('/^[A-Za-z0-9éèàçâêûîôäëüïö\ ]+$/')]
    #[NotBlank()]
    private ?string $genre = null;

    #[ORM\Column]
    #[NotBlank()]
    private ?int $price = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateAjout = null;

    #[ORM\OneToMany(mappedBy: 'disc', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPicture(): ?string
    {
        if ($this->picture == NULL) {
            return 'disc_default.jpg';
        }
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getArtist(): ?artist
    {
        return $this->artist;
    }

    public function setArtist(?artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->DateAjout;
    }

    public function setDateAjout(\DateTimeInterface $DateAjout): self
    {
        $this->DateAjout = $DateAjout;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setDisc($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getDisc() === $this) {
                $comment->setDisc(null);
            }
        }

        return $this;
    }

    public function PriceDecimal() {
        return $this->price / 100;
    }
}
