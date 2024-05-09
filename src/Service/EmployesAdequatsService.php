<?php

namespace App\Service;

use App\Entity\Prestations;
use App\Entity\Competences;
use App\Entity\Employes;
use Doctrine\ORM\EntityManagerInterface;

class EmployesAdequatsService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEmployesAdequats(int $idPrestation)
    {
        $prestation = $this->entityManager->getRepository(Prestations::class)->find($idPrestation);

        if (!$prestation) {
            throw new \Exception('La prestation avec l\'ID ' . $idPrestation . ' n\'existe pas.');
        }

        $competence = $prestation->getCompetence();

        if (!$competence) {
            throw new \Exception('La prestation avec l\'ID ' . $idPrestation . ' n\'a pas de compétence associée.');
        }

        $employesAdequats = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from(Employes::class, 'e')
            ->join('e.competences', 'c')
            ->where('c.id = :competenceId')
            ->andWhere('e NOT IN (
SELECT emp.id
FROM App\Entity\Employes emp
JOIN emp.prestations presta
WHERE (presta.date_debut >= :dateDebut AND presta.date_debut < :dateFin)
OR (presta.date_fin > :dateDebut AND presta.date_fin <= :dateFin)
OR presta.id = :currentPrestationId
)')
            ->setParameter('competenceId', $competence->getId())
            ->setParameter('dateDebut', $prestation->getDateDebut())
            ->setParameter('dateFin', $prestation->getDateFin())
            ->setParameter('currentPrestationId', $idPrestation)
            ->getQuery()
            ->getResult();

        return $employesAdequats;
    }
}
