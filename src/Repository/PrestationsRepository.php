<?php

namespace App\Repository;

use App\Entity\Prestations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prestations>
 */
class PrestationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestations::class);
    }

    public function findBYEmployesAdequats(int $id_prestation): array
    {

        $prestation = $this->find($id_prestation);
        $competenceId = $prestation->getCompetence()->getId();

        $qb = $this->createQueryBuilder('p');

        $qb->select('e')
            ->from('App\Entity\Employes', 'e')
            ->join('e.competences', 'c')
            ->leftJoin('p.employe', 'ep')
            ->where('c.id = :competenceId')
            ->andWhere($qb->expr()->notIn(
                'e.id',
                $qb->select('ep2.id')
                    ->from('App\Entity\Employes', 'e2')
                    ->join('e2.prestations', 'p2')
                    ->where($qb->expr()->andX(
                        $qb->expr()->orX(
                            $qb->expr()->andX(
                                $qb->expr()->gte('p2.date_debut', ':date_debut'),
                                $qb->expr()->lt('p2.date_debut', ':date_fin')
                            ),
                            $qb->expr()->andX(
                                $qb->expr()->gt('p2.date_fin', ':date_debut'),
                                $qb->expr()->lte('p2.date_fin', ':date_fin')
                            )
                        ),
                        $qb->expr()->eq('p2.id', ':id_prestation')
                    ))
            ))
            ->setParameter('competenceId', $competenceId)
            ->setParameter('date_debut', $prestation->getDateDebut())
            ->setParameter('date_fin', $prestation->getDateFin())
            ->setParameter('id_prestation', $id_prestation);

        return $qb->getQuery()->getResult();
    }
}
