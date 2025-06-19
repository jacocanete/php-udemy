<?php

declare(strict_types=1);

namespace Framework;

use Closure;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionNamedType;

/**
 * Simple dependency injection container for managing class dependencies.
 */
class Container
{
    /**
     * Registry of class factories or instances.
     *
     * @var array<string, callable>
     */
    private array $registry = array();

    /**
     * Registers a factory or value for a class name.
     *
     * @param string $name The class name.
     * @param callable $value The factory function to create the instance.
     * @return void
     */
    public function set(string $name, Closure $value): void
    {
        $this->registry[$name] = $value;
    }

    /**
     * Resolves and returns an instance of the given class name, injecting dependencies as needed.
     *
     * @param string $class_name The class name to resolve.
     * @return object The resolved class instance.
     */
    public function get(string $class_name): object
    {
        if (array_key_exists($class_name, $this->registry)) {
            return $this->registry[$class_name]();
        }

        $reflector = new ReflectionClass($class_name);

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $class_name();
        }

        $dependencies = array();

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            if ($type === null) {
                // phpcs:ignore Generic.Files.LineLength.TooLong
                throw new InvalidArgumentException("Constructor parameter '{$parameter->getName()}' in the $class_name class is not typed");
            }

            if (!($type instanceof ReflectionNamedType)) {
                // phpcs:ignore Generic.Files.LineLength.TooLong
                throw new InvalidArgumentException("Constructor parameter '{$parameter->getName()}' in the $class_name class is not a named type");
            }

            if ($type->isBuiltIn()) {
                // phpcs:ignore Generic.Files.LineLength.TooLong
                throw new InvalidArgumentException("Unable to resolve constructor parameter '{$parameter->getName()}' of type '$type' in the $class_name class");
            }

            if (class_exists((string) $type)) {
                $dependencies[] = $this->get((string) $type);
            }
        }

        return new $class_name(...$dependencies);
    }
}
