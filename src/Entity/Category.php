<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $category_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $category_description;

    /**
     * @ORM\OneToMany(targetEntity=Result::class, mappedBy="category_id")
     */
    private $results;

    /**
     * @ORM\ManyToMany(targetEntity=Competitor::class, mappedBy="categories")
     */
    private $competitors;

    public function __construct()
    {
        $this->results = new ArrayCollection();
        $this->competitors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    public function getCategoryDescription(): ?string
    {
        return $this->category_description;
    }

    public function setCategoryDescription(?string $category_description): self
    {
        $this->category_description = $category_description;

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
            $result->setCategory($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getCategory() === $this) {
                $result->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Competitor>
     */
    public function getCompetitors(): Collection
    {
        return $this->competitors;
    }

    public function addCompetitor(Competitor $competitor): self
    {
        if (!$this->competitors->contains($competitor)) {
            $this->competitors[] = $competitor;
            $competitor->addCategory($this);
        }

        return $this;
    }

    public function removeCompetitor(Competitor $competitor): self
    {
        if ($this->competitors->removeElement($competitor)) {
            $competitor->removeCategory($this);
        }

        return $this;
    }
}
