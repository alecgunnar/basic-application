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

        foreach ($routes as $route) {
            call_user_func_array(
                [$collection, 'withRoute'], $this->parseRoute($route)
            );
        }
    }

    protected function parseFile($file)
    {
        try {
            return Yaml::parse(file_get_contents($file));
        } catch (ParseException $e) {
            throw new InvalidArgumentException(
                sprintf(self::NOT_VALID_YAML_EXCEPTION, $file, $e->getMessage())
            );
        }
    }

    protected function parseRoute($route)
    {
        return [
            $route['name'],
            $this->factory->buildRoute(
                $route['methods'],
                $route['path'],
                $route['callable'],
                $route['middleware']
            )
        ];
    }
}
