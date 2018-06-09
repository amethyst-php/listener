<?php

namespace Railken\LaraOre\Http\Controllers;

use Railken\LaraOre\Api\Http\Controllers\RestController;
use Railken\LaraOre\Api\Http\Controllers\Traits as RestTraits;
use Railken\LaraOre\Listener\ListenerManager;

class ListenersController extends RestController
{
    use RestTraits\RestIndexTrait;
    use RestTraits\RestCreateTrait;
    use RestTraits\RestUpdateTrait;
    use RestTraits\RestShowTrait;
    use RestTraits\RestRemoveTrait;

    protected static $query = [
        'id',
        'name',
        'event_class',
        'work_id',
        'created_at',
        'updated_at',
    ];

    protected static $fillable = [
        'name',
        'event_class',
        'work_id',
    ];

    /**
     * Construct.
     */
    public function __construct(ListenerManager $manager)
    {
        $this->manager = $manager;
        $this->manager->setAgent($this->getUser());
        parent::__construct();
    }

    /**
     * Create a new instance for query.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQuery()
    {
        return $this->manager->repository->getQuery();
    }
}
