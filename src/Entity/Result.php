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
    private $competitor_id;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category_id;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competition_id;

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

    public function getCompetitorId(): ?Competitor
    {
        return $this->competitor_id;
    }

    public function setCompetitorId(?Competitor $competitor_id): self
    {
        $this->competitor_id = $competitor_id;

        return $this;
    }

    public function getCategoryId(): ?Category
    {
        return $this->category_id;
    }

    public function setCategoryId(?Category $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getCompetitionId(): ?Competition
    {
        return $this->competition_id;
    }

    public function setCompetitionId(?Competition $competition_id): self
    {
        $this->competition_id = $competition_id;

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
