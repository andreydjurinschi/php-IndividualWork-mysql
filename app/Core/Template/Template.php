<?php

namespace Template;

class Template
{
    private $layout;
    private $viewDirectory;

    /**
     * Конструктор класса
     *
     * @param string $layout
     * @param string $viewDirectory
     */
    public function __construct($layout, $viewDirectory){
        $this->viewDirectory = $viewDirectory;
        $this->layout = $viewDirectory . '/' . $layout . '.php';
    }

    /**
     * Загружает шаблон с данными
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public function render($view, $data = []){
        extract($data);
        ob_start();
        include $this->viewDirectory . '/' . $view . '.php';
        $content = ob_get_clean();
        include $this->layout;
    }

}