<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    /**
     * @var Request
     */
    public $req;
    /**
     * @var Application
     */
    public $app;
    // Response variables
    protected $json;
    protected $status_code = Response::HTTP_OK;
    /**
     * @var JsonResponse
     */
    protected $jsonResponse;

    public function __construct()
    {
        $this->req          = Request::createFromGlobals();
        $this->jsonResponse = new JsonResponse();
    }

    /**
     * Send JSON Response to Client
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function sendJson()
    {
        $this->jsonResponse->setStatusCode($this->status_code);

        return $this->jsonResponse->setData($this->json);
    }
}