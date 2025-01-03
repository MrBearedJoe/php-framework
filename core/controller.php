<?php

class Controller
{
  protected function view($view)
  {
    $view = str_replace('-', '_', $view);

    if (file_exists("./views/$view.php")) {
      include "./views/layout/header.php";
      include "./views/$view.php";
      include "./views/layout/footer.php";
    } else {
      header("Location: /dashboard/NewApp/");
    }
  }

  protected function loadModel($model)
  {
    if (file_exists("./models/$model.php")) {
      include "./models/$model.php";
      return $model = new $model();
    }
    return false;
  }
}