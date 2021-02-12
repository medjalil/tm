<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThanOrEqual(12)
     */
    private ?int $newMonth;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThanOrEqual(30)
     */
    private ?int $newDay;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $startAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\GreaterThanOrEqual(propertyPath="startAt")
     */
    private ?\DateTimeInterface $endAt;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?School $school;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Teacher $teacher;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $type;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?City $city;

    /**
     * @ORM\OneToMany(targetEntity=Salary::class, mappedBy="mission")
     */
    private Collection $salaries;

    public function __construct()
    {
        $this->salaries = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNewMonth(): ?int
    {
        return $this->newMonth;
    }

    public function setNewMonth(int $newMonth): self
    {
        $this->newMonth = $newMonth;

        return $this;
    }

    public function getNewDay(): ?int
    {
        return $this->newDay;
    }

    public function setNewDay(int $newDay): self
    {
        $this->newDay = $newDay;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }


    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

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

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return Collection|Salary[]
     */
    public function getSalaries(): Collection
    {
        return $this->salaries;
    }

    public function addSalary(Salary $salary): self
    {
        if (!$this->salaries->contains($salary)) {
            $this->salaries[] = $salary;
            $salary->setMission($this);
        }

        return $this;
    }

    public function removeSalary(Salary $salary): self
    {
        if ($this->salaries->removeElement($salary)) {
            // set the owning side to null (unless already changed)
            if ($salary->getMission() === $this) {
                $salary->setMission(null);
            }
        }

        return $this;
    }

}
