<?php

namespace App\Infrastructure\Providers;

use App\Infrastructure\Auth\DoctrineUserProvider;
use InvalidArgumentException;
use LaravelDoctrine\ORM\DoctrineServiceProvider as OriginalDoctrineServiceProvider;

class DoctrineServiceProvider extends OriginalDoctrineServiceProvider
{
    protected function extendAuthManager()
    {
        if ($this->app->bound('auth')) {
            $this->app->make('auth')->provider('doctrine', function ($app, $config) {
                $entity = $config['model'];

                $em = $app['registry']->getManagerForClass($entity);

                if (!$em) {
                    throw new InvalidArgumentException("No EntityManager is set-up for {$entity}");
                }

                /**
                 * @author Peter Furesz
                 * @TODO because of a bug, we need to use our own ServiceProvider
                 *  After fix pull request merged to `laravel-doctrine/orm`, this file can be deleted
                 */
                return new DoctrineUserProvider(
                    $app['hash'],
                    $em,
                    $entity
                );
            });
        }
    }
}
