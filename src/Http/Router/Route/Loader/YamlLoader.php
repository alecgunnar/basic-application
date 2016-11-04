<?php

namespace Framework\Http\Router\Route\Loader;

use Framework\Http\Router\Route\Factory\ContainerAwareFactoryInterface;
use Framework\Http\Router\Route\Collection\CollectionInterface;
use InvalidArgumentException;
use Exception;
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

    /**
     * @var string
     */
    const MISSING_ATTRIBUTE_EXCEPTION = 'All routes must have a "%s" attribute. Please check your configuration.';

    /**
     * @var string
     */
    const DEFAULT_VIA = 'GET';

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

    protected function parseRoutes(
        array $routes,
        CollectionInterface $collection,
        string $prefix = '',
        array $stack = []
    ) {
        foreach ($routes as $name => $route) {
            if (isset($route['group'])) {
                $this->parseRoutes(
                    $route['group'],
                    $collection,
                    $this->cleanRoutePath($route['path']),
                    $route['stack']
                );

                continue;
            }

            if (is_string($name)) {
                $route['name'] = $route['name'] ?? $name;
            }

            $this->parseRoute($route, $collection, $prefix, $stack);
        }
    }

    protected function parseRoute(
        array $route,
        CollectionInterface $collection,
        string $prefix = '',
        array $stack = []
    ) {
        $route = $this->validateRoute($route);

        $collection->withRoute(
            $route['name'],
            $this->factory->buildRoute(
                $route['via'],
                $this->cleanRoutePath($route['path'], $prefix),
                $route['call'],
                $this->mergeMiddlewareStacks($stack, $route['stack'])
            )
        );
    }

    protected function validateRoute(array $route): array
    {
        $this->checkForAttribute($route, 'path');
        $this->checkForAttribute($route, 'call');

        $route['via'] = $route['via'] ?? self::DEFAULT_VIA;
        $route['name'] = $route['name'] ?? md5(
            $route['path'] . (is_array($route['via']) ? implode('', $route['via']) : $route['via'])
        );
        $route['stack'] = $route['stack'] ?? [];

        return $route;
    }

    protected function checkForAttribute(array $values, string $attr)
    {
        if (!isset($values[$attr])) {
            throw new Exception(
                sprintf(self::MISSING_ATTRIBUTE_EXCEPTION, $attr)
            );
        }
    }

    protected function cleanRoutePath(string $path, string $prefix = ''): string
    {
        return $prefix . '/' . trim($path, '/');
    }

    protected function mergeMiddlewareStacks(array $first, array $second): array
    {
        return array_unique(
            array_merge($first, $second)
        );
    }
}
