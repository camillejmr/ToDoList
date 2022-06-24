<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
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
    private $task;

    /**
     * @ORM\ManyToOne(targetEntity=Liste::class, inversedBy="ListTasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idListe;

    /**
     * @ORM\Column(type="boolean")
     */
    private $done;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getIdListe(): ?Liste
    {
        return $this->idListe;
    }

    public function setIdListe(?Liste $idListe): self
    {
        $this->idListe = $idListe;

        return $this;
    }

    public function isDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;

        return $this;
    }
}
