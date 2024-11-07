<?php

namespace Alkali\Post;

trait ClassNameAsPostType
{
    protected static $classNamePostType;

    public static function postTypeId(): string
    {
        if (static::POST_TYPE) {
            return static::POST_TYPE;
        }
        return static::getPostTypeFromName();
    }

    protected static function getPostTypeFromName()
    {
        if (static::$classNamePostType) {
            return static::$classNamePostType;
        }
        $name = (new \ReflectionClass(static::class))->getShortName();
        if (! ctype_lower($name)) {
            $name = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1_', $name));
        }
        return static::$classNamePostType = $name;
    }
}