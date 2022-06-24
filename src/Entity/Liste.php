<?php

namespace App\Entity;

use App\Repository\ListeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ListeRepository::class)
 */
class Liste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Merci de donner un nom à votre liste")
     * @Assert\Length(min=2,
     *     max=255,
     *     minMessage = "Le nom de la liste doit contenir au minimum {{ limit }} caractères.",
     *     maxMessage = "Le nom de la liste doit contenir au maximum {{ limit }} caractères.")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $finished;

    /**
     * @Assert\GreaterThanOrEqual(propertyPath="dateCreation")
     * @ORM\Column(type="datetime")
     */
    private $dateLastModification;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="idListe")
     */
    private $ListTasks;

    public function __construct()
    {
        $this->ListTasks = new ArrayCollection();
    }


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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function isFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): self
    {
        $this->finished = $finished;

        return $this;
    }

    public function getDateLastModification(): ?\DateTimeInterface
    {
        return $this->dateLastModification;
    }

    public function setDateLastModification(\DateTimeInterface $dateLastModification): self
    {
        $this->dateLastModification = $dateLastModification;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getListTasks(): Collection
    {
        return $this->ListTasks;
    }

    public function addListTask(Task $listTask): self
    {
        if (!$this->ListTasks->contains($listTask)) {
            $this->ListTasks[] = $listTask;
            $listTask->setIdListe($this);
        }

        return $this;
    }

    public function removeListTask(Task $listTask): self
    {
        if ($this->ListTasks->removeElement($listTask)) {
            // set the owning side to null (unless already changed)
            if ($listTask->getIdListe() === $this) {
                $listTask->setIdListe(null);
            }
        }

        return $this;
    }

}
