<?php

namespace Railken\Amethyst\Schemas;

use Railken\Amethyst\Managers\WorkManager;
use Railken\Lem\Attributes;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Schema;

class ListenerSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\TextAttribute::make('name')
                ->setRequired(true)
                ->setUnique(true),
            Attributes\LongTextAttribute::make('description'),
            Attributes\TextAttribute::make('event_class'),
            Attributes\BooleanAttribute::make('enabled'),
            Attributes\YamlAttribute::make('data')->setDefault(function (EntityContract $entity) {
                return file_get_contents(__DIR__.'/../../resources/schema/default/data.yaml');
            }),
            Attributes\TextAttribute::make('condition'),
            Attributes\BelongsToAttribute::make('work_id')
                ->setRelationName('work')
                ->setRelationManager(WorkManager::class),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
