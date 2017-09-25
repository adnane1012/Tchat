<?php

namespace Template;


class View
{
    protected $layout;
    protected $viewsDir;
    protected $name;
    protected $variables;
    protected $disableLayout = false;

    public function __construct($viewsDir = null, $options = [])
    {
        $this->viewsDir = $viewsDir;
    }

    /**
     * @param mixed $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param mixed $variables
     */
    public function setVariables($variables)
    {
        $this->variables = $variables;
    }

    /**
     * @return mixed
     */
    public function getVariables()
    {
        return $this->variables;
    }


    /**
     * @param mixed $viewsDir
     */
    public function setViewsDir($viewsDir)
    {
        $this->viewsDir = $viewsDir;
    }

    public function disableLayout()
    {
        $this->disableLayout = true;
    }

    public function run()
    {
        ob_start();
        if (!empty($this->variables)) {
            extract($this->variables);
        }
        include $this->viewsDir . DIRECTORY_SEPARATOR . $this->name;

        return ob_get_clean();
    }

    public function render()
    {
        $content = $this->run();

        if (!$this->disableLayout) {
            ob_start();
            $content = $this->run();
            include $this->layout;

            return ob_get_clean();
        }

        return $content;

    }
} 