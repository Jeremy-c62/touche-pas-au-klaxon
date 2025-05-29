<?php

class Controller {
    public function model($model) {
        $file = '../app/Models/' . $model . '.php';
        if (file_exists($file)) {
            require_once $file;
            return new $model();
        } else {
            die("Modèle <strong>$model</strong> introuvable.");
        }
    }

    public function view($view, $data = []) {
        $file = '../app/Views/' . $view . '.php';
        if (file_exists($file)) {
            extract($data); // Rend les variables accessibles dans la vue
            require_once $file;
        } else {
            die("Vue <strong>$view</strong> introuvable.");
        }
    }
}
