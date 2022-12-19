<?php

namespace App\Controller;

use App\Entity\Deadline;
use App\Repository\DeadlineRepository;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class NextDeadlines extends AbstractController
{
    public function __construct(
        private DeadlineRepository $deadlineRepository)
    {
    }

    public function __invoke()
    {
        return $this->deadlineRepository->findNextDeadlines();
    }
}
