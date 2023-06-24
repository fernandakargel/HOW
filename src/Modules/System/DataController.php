<?php
namespace Modules\System;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;

/**
 * DataController
 *
 * @namespace Modules\Pgestao
 * 
 */
class DataController
{
    
    /**
     * 
     * @var Container
     */
    protected $container;
    
    /**
     * Set Container
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * Show list of data
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function list(Request $request, Response $response, array $args)
    {  
        
        $message = $this->container->flash->getFirstMessage("msg");
        
        return $this->container->view->render($response, 'Pgestao/data/data.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE),
                                        "dataset" => array())
        ]);
    }
}