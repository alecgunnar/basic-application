<?php

namespace Framework\Router\Route\Loader;

use Framework\Router\Route\Factory\ContainerAwareFactoryInterface;
use Framework\Router\Route\Collection\CollectionInterface;
use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlLoader implements LoaderInterface
{
    /**
     * @var ContainerAwareFactoryInterface $factory
     */
    protected $factory;

    /**
     * @var string
     */
    const FILE_DOES_NOT_EXIST_EXCEPTION = 'The route configuration file "%s" does not exist.';

    /**
     * @var string
     */
    const NOT_VALID_YAML_EXCEPTION = 'The route configuration file "%s" does not contain valid YAML. The error was: %s';

    public function __construct(ContainerAwareFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function loadRoutes(string $file, CollectionInterface $collection)
    {
        if (!file_exists($file)) {
            throw new InvalidArgumentException(
                sprintf(self::FILE_DOES_NOT_EXIST_EXCEPTION, $file)
            );
        }

        $routes = $this->parseFile($file);
        $this->parseRoutes($routes, $collection);
    }

    protected function parseFile(string $file)
    {
        try {
            return Yaml::parse(file_get_contents($file));
        } catch (ParseException $e) {
            throw new InvalidArgumentException(
                sprintf(self::NOT_VALID_YAML_EXCEPTION, $file, $e->getMessage())
            );
        }
    }

    protected function parseRoutes(array $routes, CollectionInterface $collection, array $stack = [])
    {
        foreach ($routes as $route) {
            $this->parseRoute($route, $collection, $stack);
        }
    }

    protected function parseRoute(array $route, CollectionInterface $collection, array $stack = [])
    {
        if (isset($route['group'])) {
            return $this->parseRoutes($route['group'], $collection, $route['stack']);
        }

        $collection->withRoute(
            $route['name'],
            $this->factory->buildRoute(
                $route['via'],
                $route['path'],
                $route['call'],
                $this->mergeMiddlewareStacks($stack, $route['stack'])
            )
        );
    }

    protected function mergeMiddlewareStacks(array $first, array $second)
    {
        return array_unique(
            array_merge($first, $second)
        );
    }
}
