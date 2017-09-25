<?php
namespace Http;

class Request
{
    protected $uri;
    protected $queryParameters = array();
    protected $requestParameters = array();
    protected $methode;


    public function __construct($url, $request, $method = 'GET')
    {

        $parsedUri = parse_url($url);
        $this->uri = $parsedUri['path'];
        if (!empty($parsedUri["query"])) {
            parse_str($parsedUri["query"], $this->queryParameters);
        }
        $this->requestParameters = $request;
        $this->methode = $method;
    }

    public static function createFromGlobale()
    {
        $uri = $_SERVER['REQUEST_URI'];
        return new self($uri, $_POST, $_SERVER['REQUEST_METHOD']);

    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    /**
     * @return array
     */
    public function getQueryParameter($param, $default = null)
    {
        return isset($this->queryParameters[$param]) ? $this->queryParameters[$param] : $default;
    }

    /**
     * @return array
     */
    public function getRequestParameters()
    {
        return $this->requestParameters;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    public function isPost()
    {
        return $this->methode == 'POST';
    }

    public function isXmlHttpRequest() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }

}