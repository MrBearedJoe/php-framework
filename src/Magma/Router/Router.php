<?php

declare(strict_types=1);

namespace Magma\Router;

use Magma\Router\RouterInterface;

class Router implements RouterInterface
{

  protected array $routes = [];
  protected array $params = [];
  protected string $controllerSuffix = "controller";

  public function add(string $route, array $params = []): void
  {
    $this->routes[$route] = $params;
  }

  public function dispatch(string $url): void
  {
    if ($this->match($url)) {
      $controllerString = $this->params['controller'];
      $controllerString = $this->transformUpperCamelCase($controllerString);
      $controllerString = $this->getNamespace($controllerString);

      if (class_exists($controllerString)) {
        $controllerObject = new $controllerString();
        $action = $this->params['action'];
        $action = $this->transformCamelCase($action);

        if (is_callable([$controllerObject, $action])) {
          $controllerObject->action();
        } else {
          throw new \Exception();
        }
      } else {
        throw new \Exception();
      }
    } else {
      throw new \Exception();
    }
  }

  public function transformCamelCase(string $string): string
  {
    return \lcfirst($this->transformUpperCamelCase($string));
  }
  public function transformUpperCamelCase(string $string): string
  {
    return str_replace(" ", "", ucwords(str_replace("-", " ", $string)));
  }

  private function match(string $url): bool
  {
    foreach ($this->routes as $router => $params) {
      if (preg_match($router, $url, $matches)) {
        foreach ($matches as $key => $param) {
          if (is_string($key)) {
            $params[$key] = $param;
          }
        }
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  public function getNamespace(string $string): string
  {
    $namespace = "App\Controller\\";
    if (array_key_exists('namespace', $this->params)) {
      $namespace .= $this->params['namespace'] . "\\";
    }
    return $namespace;
  }
}