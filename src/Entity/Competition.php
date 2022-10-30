<?php

namespace App\Entity;

use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetitionRepository::class)
 */
class Competition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $competition_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $competition_description;

    /**
     * @ORM\OneToMany(targetEntity=Result::class, mappedBy="competition_id")
     */
    private $results;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $competition_year;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetitionName(): ?string
    {
        return $this->competition_name;
    }

    public function setCompetitionName(string $competition_name): self
    {
        $this->competition_name = $competition_name;

        return $this;
    }

    public function getCompetitionDescription(): ?string
    {
        return $this->competition_description;
    }

    public function setCompetitionDescription(?string $competition_description): self
    {
        $this->competition_description = $competition_description;

        return $this;
    }

    /**
     * @return Collection<int, Result>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Result $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setCompetition($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getCompetition() === $this) {
                $result->setCompetition(null);
            }
        }

        return $this;
    }

    public function getCompetitionYear(): ?string
    {
        return $this->competition_year;
    }

    public function setCompetitionYear(?string $competition_year): self
    {
        $this->competition_year = $competition_year;

        return $this;
    }
}
