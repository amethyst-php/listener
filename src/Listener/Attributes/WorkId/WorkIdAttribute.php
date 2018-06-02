<?php

namespace Railken\LaraOre\Listener\Attributes\WorkId;

use Railken\Laravel\Manager\Attributes\BelongsToAttribute;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\Tokens;
use Respect\Validation\Validator as v;

class WorkIdAttribute extends BelongsToAttribute
{
    /**
     * Name attribute.
     *
     * @var string
     */
    protected $name = 'work_id';

    /**
     * Is the attribute required
     * This will throw not_defined exception for non defined value and non existent model.
     *
     * @var bool
     */
    
    protected $required = true;

    /**
     * Is the attribute unique.
     *
     * @var bool
     */
    protected $unique = false;

    /**
     * List of all exceptions used in validation.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_DEFINED    => Exceptions\ListenerWorkIdNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\ListenerWorkIdNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\ListenerWorkIdNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\ListenerWorkIdNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'listener.attributes.work_id.fill',
        Tokens::PERMISSION_SHOW => 'listener.attributes.work_id.show',
    ];
    
    /**
     * Retrieve the name of the relation.
     *
     * @return string
     */
    public function getRelationName()
    {
        return 'work';
    }

    /**
     * Retrieve eloquent relation.
     *
     * @param EntityContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getRelationBuilder(EntityContract $entity)
    {
        return $entity->work();
    }

    /**
     * Retrieve relation manager.
     *
     * @param EntityContract $entity
     *
     * @return \Railken\Laravel\Manager\Contracts\ManagerContract
     */
    public function getRelationManager(EntityContract $entity)
    {
        return new \Railken\LaraOre\Work\WorkManager($this->getManager()->getAgent());
    }
}
