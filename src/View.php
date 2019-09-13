<?php

namespace App;

/**
 * Class View
 * @package App
 */
class View
{
    protected $name;

    /**
     * View constructor.
     * @param string $name
     * @param array $data
     */
    public function __construct(string $name, array $data = [])
    {
        $this->setName($name);

        $view_path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;

        $GLOBALS['VIEW_DATA'] = $data;

        include($view_path . '__variables.php');
        include($view_path . $this->getName() . '.php');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return View
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $view
     * @param array $data
     * @return View
     */
    public static function render(string $view, array $data = []): View
    {
        return new self($view, $data);
    }
}