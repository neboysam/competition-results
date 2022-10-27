<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultRepository::class)
 */
class Result
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Competitor::class, inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competitor;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competition;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $result1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $result2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $final_result;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetitor(): ?Competitor
    {
        return $this->competitor;
    }

    public function setCompetitor(?Competitor $competitor): self
    {
        $this->competitor = $competitor;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }

    public function getResult1(): ?string
    {
        return $this->result1;
    }

    public function setResult1(string $result1): self
    {
        $this->result1 = $result1;

        return $this;
    }

    public function getResult2(): ?string
    {
        return $this->result2;
    }

    public function setResult2(string $result2): self
    {
        $this->result2 = $result2;

        return $this;
    }

    public function getFinalResult(): ?string
    {
        return $this->final_result;
    }

    public function setFinalResult(string $final_result): self
    {
        $this->final_result = $final_result;

        return $this;
    }
}
