<?php

class App {
    protected $controller = 'HomeController'; // Contrôleur par défaut
    protected $method = 'index';              // Méthode par défaut
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Vérifie si l'URL commence par 'admin'
        if (isset($url[0]) && $url[0] == 'admin') {
            $controllerName = 'AdminController'; // Si admin, le contrôleur sera AdminController
            unset($url[0]); // Supprime 'admin' de l'URL
        } else {
            // Sinon, utiliser un autre contrôleur
            $controllerName = ucfirst($url[0] ?? 'home') . 'Controller'; // Contrôleur par défaut
        }

        $controllerFile = '../app/Controllers/' . $controllerName . '.php';

        // Vérifie si le fichier du contrôleur existe
        if (file_exists($controllerFile)) {
            $this->controller = $controllerName;
            unset($url[0]);
        } else {
            http_response_code(404);
            die("Erreur 404 : Le contrôleur <strong>$controllerName</strong> est introuvable.");
        }

        // Inclut le fichier du contrôleur
        require_once $controllerFile;

        // Instancie le contrôleur
        if (class_exists($this->controller)) {
            $this->controller = new $this->controller;
        } else {
            http_response_code(500);
            die("Erreur 500 : La classe <strong>{$this->controller}</strong> n'existe pas.");
        }

        // Vérifie si la méthode existe
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                http_response_code(404);
                die("Erreur 404 : La méthode <strong>{$url[1]}</strong> n'existe pas dans le contrôleur <strong>" . get_class($this->controller) . "</strong>.");
            }
        }

        // Récupère les paramètres restants
        $this->params = $url ? array_values($url) : [];

        // Appel dynamique de la méthode du contrôleur avec les paramètres
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return ['home']; // Retourne la route par défaut
    }
}
