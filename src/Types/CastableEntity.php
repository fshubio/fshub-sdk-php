<?php

namespace FsHub\Sdk\Types;

trait CastableEntity
{
    /**
     * Cast entity properties from a key-value based array.
     * @param array $properties
     * @return self
     */
    public static function cast(array $properties)
    {

        $className = get_class();
        $entity = new $className();

        if (property_exists($entity, 'castMap')) {
            $map = self::$castMap;
            foreach ($properties as $property => $value) {
                if (!isset($map[$property])) {
                    continue; // It doesn't exist in our map, so we just continue/skip it...
                }
                if (property_exists($entity, $map[$property])) {
                    $entity->{$map[$property]} = $value;
                }
            }
            return $entity;
        }


        foreach ($properties as $property => $value) {
            if (property_exists($entity, $property)) {
                $entity->{$property} = $value;
            }
        }

        return $entity;
    }
}
