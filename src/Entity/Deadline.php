<?php

namespace App\Entity;

use ApiPlatform\Metadata\Put;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\NextDeadlines;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\DeadlineRepository;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;

#[ORM\Entity(repositoryClass: DeadlineRepository::class)]
#[ApiResource(operations: [

    /* 
        📋 1️⃣ Retourne une liste des deadlines issues de la base de données, qui ne sont pas marquées comme clôturées et qui ont leur date d’échéance avant le vendredi de la semaine prochaine inclus
    */
    new GetCollection(
        name: 'nextdeadlines',
        uriTemplate: '/nextdeadlines', 
        controller: NextDeadlines::class
    ),

    /* 
        📋 2️⃣ Montre toutes les deadlines, non réalisées, sans limite de date 
    */
    new GetCollection(
        uriTemplate: '/alldeadlines', 
        // filters: ['isDone' => false],
        // defaults: ['isDone' => false],
        // options: ['isDone' => false], 
    ),

    /* 
        📋 3️⃣ Cette API doit permettre de marquer une deadline comme réalisée. Il faut que l’on puisse appeler l’API, on sait pas encore trop comment, mais ça doit changer le flag “is_done” dans la base. Le développeur front a dit “faites au mieux”, donc : à vous de jouer ! ✅
    */
    new Put(
        uriTemplate: '/deadline/{id}/isDone',
        requirements: ['id' => '\d+'],
    )
])]
// #[ApiFilter(DateFilter::class, properties: ['dueDate'])]
// #[ApiFilter(BooleanFilter::class, properties: ['isDone'])]
class Deadline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\Column]
    private ?bool $isDone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function isIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    // 📋 1️⃣ Le nombre de jours avant échéance ✅
    public function getDaysBeforeEnd(): int
    {
        // Calcul
        $interval = date_diff(new \DateTime, $this->dueDate);

        $retourInterval = $interval->format('%r%a');

        return $retourInterval;
    }

    // 📋 1️⃣ Un flag “EN RETARD” à true si la date est dépassée ✅
    public function getLateFlag()
    {
        if ($this->getDaysBeforeEnd() < 0) {
            return "EN RETARD";
        }
    }
}
