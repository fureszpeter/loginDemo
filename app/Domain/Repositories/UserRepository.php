<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function save(User $user): User
    {
        $em = $this->getEntityManager();

        $em->persist($user);
        $em->flush();

        return $user;
    }
}
