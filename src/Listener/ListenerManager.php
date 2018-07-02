<?php

namespace Railken\LaraOre\Listener;

use Railken\Laravel\Manager\Contracts\AgentContract;
use Railken\Laravel\Manager\ModelManager;
use Railken\Laravel\Manager\Tokens;
use Illuminate\Support\Facades\Config;

class ListenerManager extends ModelManager
{
    /**
     * Class name entity.
     *
     * @var string
     */
    public $entity = Listener::class;
    
    /**
     * List of all attributes.
     *
     * @var array
     */
    protected $attributes = [
        Attributes\Id\IdAttribute::class,
        Attributes\Name\NameAttribute::class,
        Attributes\CreatedAt\CreatedAtAttribute::class,
        Attributes\UpdatedAt\UpdatedAtAttribute::class,
        Attributes\Description\DescriptionAttribute::class,
        Attributes\EventClass\EventClassAttribute::class,
        Attributes\Enabled\EnabledAttribute::class,
        Attributes\WorkId\WorkIdAttribute::class,
        Attributes\Condition\ConditionAttribute::class,
        Attributes\Entities\EntitiesAttribute::class,
    ];

    /**
     * List of all exceptions.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_AUTHORIZED => Exceptions\ListenerNotAuthorizedException::class,
    ];

    /**
     * Construct.
     *
     * @param AgentContract $agent
     */
    public function __construct(AgentContract $agent = null)
    {
        $this->entity = Config::get('ore.listener.entity');
        $this->attributes = array_merge($this->attributes, array_values(Config::get('ore.listener.attributes')));
        
        $classRepository = Config::get('ore.listener.repository');
        $this->setRepository(new $classRepository($this));

        $classSerializer = Config::get('ore.listener.serializer');
        $this->setSerializer(new $classSerializer($this));

        $classAuthorizer = Config::get('ore.listener.authorizer');
        $this->setAuthorizer(new $classAuthorizer($this));

        $classValidator = Config::get('ore.listener.validator');
        $this->setValidator(new $classValidator($this));

        parent::__construct($agent);
    }
}
