<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $cin;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $diplomaAt;


    /**
     * @ORM\Column(type="integer")
     */
    private int $initMonth = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $initDay = 0;


    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="teacher")
     */
    private Collection $missions;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $comment;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="teachers")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?City $city;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $archived = false;

    /**
     * @ORM\OneToOne(targetEntity=Archive::class, mappedBy="teacher")
     */
    private ?Archive $archive;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $ord;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $pId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $bankId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $fullName;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->missions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }


    public function getInitMonth(): ?int
    {
        return $this->initMonth;
    }

    public function setInitMonth(int $initMonth): self
    {
        $this->initMonth = $initMonth;

        return $this;
    }

    public function getInitDay(): ?int
    {
        return $this->initDay;
    }

    public function setInitDay(int $initDay): self
    {
        $this->initDay = $initDay;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->setTeacher($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getTeacher() === $this) {
                $mission->setTeacher(null);
            }
        }

        return $this;
    }


    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getArchive(): ?Archive
    {
        return $this->archive;
    }

    public function setArchive(Archive $archive): self
    {
        $this->archive = $archive;

        // set the owning side of the relation if necessary
        if ($archive->getTeacher() !== $this) {
            $archive->setTeacher($this);
        }

        return $this;
    }

    public function getDiplomaAt(): ?string
    {
        return $this->diplomaAt;
    }

    public function setDiplomaAt(string $diplomaAt): self
    {
        $this->diplomaAt = $diplomaAt;

        return $this;
    }

    public function getOrd(): ?int
    {
        return $this->ord;
    }

    public function setOrd(int $ord): self
    {
        $this->ord = $ord;

        return $this;
    }

    public function getPId(): ?string
    {
        return $this->pId;
    }

    public function setPId(?string $pId): self
    {
        $this->pId = $pId;

        return $this;
    }

    public function getBankId(): ?int
    {
        return $this->bankId;
    }

    public function setBankId(?int $bankId): self
    {
        $this->bankId = $bankId;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->fullName ?? '';
    }
}
