<?php

namespace Railken\LaraOre\Listener;

use Illuminate\Support\Collection;
use Railken\Bag;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\ModelSerializer;
use Railken\Laravel\Manager\Tokens;

class ListenerSerializer extends ModelSerializer
{
    /**
     * Serialize entity.
     *
     * @param EntityContract $entity
     * @param Collection     $select
     *
     * @return \Railken\Bag
     */
    public function serialize(EntityContract $entity, Collection $select = null)
    {
        $bag = parent::serialize($entity, $select);

        return $bag;
    }
}
