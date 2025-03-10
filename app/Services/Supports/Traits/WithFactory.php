<?php

declare(strict_types=1);

namespace App\Services\Supports\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;

trait WithFactory
{
    public static function factory(...$parameters): Factory
    {
        $classFullName = explode('\\', get_called_class());
        $className = array_pop($classFullName);
        $fabricName = 'Database\\Factories\\'.$className.'Factory';
        $factory = new $fabricName();

        return $factory
            ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }
}
