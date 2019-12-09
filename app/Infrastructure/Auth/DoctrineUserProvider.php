<?php

namespace App\Infrastructure\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use LaravelDoctrine\ORM\Auth\DoctrineUserProvider as OriginalUserProvider;

class DoctrineUserProvider extends OriginalUserProvider
{
    /**
     * @TODO Because of a bug in LaravelDoctrine, we need to override original `DoctrineUserProvider`.
     *  Need to open a pull request in LaravelDoctrine
     *
     * @param mixed $identifier
     */
    public function retrieveById($identifier): Authenticatable
    {
        return $this->getRepository()->findOneBy([
            $this->getEntity()->getAuthIdentifierName() => $identifier,
        ]);
    }
}
