<?php

namespace Railken\LaraOre\Events;

interface WorkEventContract
{
    /**
     * @return array
     */
    public function getData();

    /**
     * @return array
     */
    public function getEntities();
}
