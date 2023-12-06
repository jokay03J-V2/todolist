<?php
namespace TodoList\Project\Config;

class ViewConfig
{
    /**
     * View loaded when route is not found
     * Without .php extension
     */
    static private ?string $notFoundView = "notfound";

    /**
     * Get view name when route is not found
     */
    static function getNotFoundView(): string|false
    {
        return self::$notFoundView ?? false;
    }
}
?>