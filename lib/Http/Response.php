<?php
namespace Http;

use Template\View;

class Response
{
    protected $statusCode;
    protected $contentType;
    protected $content;
    protected $headers = [];

    /** @var  View */
    protected $view;

    /**
     * @param string $content
     * @param int $statusCode
     */
    public function __construct($content = '', $statusCode = 200, $contentType = "text/html; charset=UTF-8;")
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->contentType = $contentType;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param string $name
     * @param array $value
     */
    public function setHeaders($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->view->setName($template);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->view->getName();
    }

    /**
     * @param mixed $variables
     */
    public function setVariables($variables)
    {
        $this->view->setVariables($variables);
    }

    /**
     * @return mixed
     */
    public function getVariables()
    {
        return $this->view->getVariables();
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param \Template\View $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * @return \Template\View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return $this|bool
     */
    public function render()
    {
        $template = $this->view->getName();
        if (empty($template)) {
            return false;
        }

        $this->content = $this->view->render();

        return $this;
    }


    /**
     * Sends HTTP headers and content.
     *
     * @return $this
     */
    public function send()
    {
        $content = $this->content;

        $this->setHeaders('Content-Type', $this->contentType);
        // headers
        foreach ($this->headers as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    header($name . ': ' . $v, false, $this->statusCode);
                }
                continue;
            }
            header($name . ': ' . $value, false, $this->statusCode);
        }

        echo $content;
    }

    public function setLayout($layout)
    {
        $this->view->setLayout($layout);

        return $this;
    }

    public function disableLayout()
    {
        $this->view->disableLayout();

        return $this;
    }

    public function redirect($uri)
    {
        header('Location: '.$uri);
        die;
    }
}
