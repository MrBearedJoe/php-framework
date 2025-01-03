<?php

class App
{
  private $controller = "home";
  private $method = "index";
  private $params = [];

  public function __construct()
  {
    $url = $this->splitURL();

    if (file_exists("./controllers/" . strtolower($url[0]) . ".php")) {
      $this->controller = strtolower($url[0]);
      unset($url[0]);
    }

    require "./controllers/" . strtolower($this->controller) . ".php";
    $this->controller = new $this->controller;

    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {
        $this->method = $url[1];
        unset($url[1]);
      }
    }

    $this->params = array_values($url);

    call_user_func_array([$this->controller, $this->method], $this->params);
  }

  private function splitURL(): array
  {
    $url = !empty($_GET['url']) ? $_GET['url'] : "index";
    $url = str_replace('-', '_', $url);
    return explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));
  }
}