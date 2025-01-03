<?php

declare(strict_types=1);

namespace Magma\Router;

interface RouterInterface
{
  /**
   * Simple add a router to the routing table
   * @param string $route
   * @param array $params
   * @return void
   */
  public function add(string $route, array $params): void;

  /** 
   * @param string $url
   * @return void
   */

  public function dispatch(string $url): void;
}