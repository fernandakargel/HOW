<?php

namespace Modules\Pgestao\Company;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;

/**
 * CompanyController
 * 
 * @namespace \Modules\Pgestao\Company
 * 
 */
class CompanyController
{
    
    /**
     * 
     * @var Container
     */
    protected $container;
    
    /**
     * 
     * @var CompanyModel
     */
    protected $model;
    
    /**
     * Set Container
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->model = new CompanyModel($container);
    }
    
    /**
     * Show list of company
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function list(Request $request, Response $response, array $args)
    {  
        
        $message = $this->container->flash->getFirstMessage("msg");

        return $this->container->view->render($response, '/Pgestao/company/company_list.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE),
                            "dataset" => $this->model->selectAll())
        ]);
    }
    
       
    /**
     * Show company form
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function form(Request $request, Response $response, array $args)
    {  
        $message = $this->container->flash->getFirstMessage("msg");
        
        $return = isset($args['id']) ? $this->model->selectByID($args['id']) 
                                     : array();
                     
        return $this->container->view->render($response, '/Pgestao/company/company_form.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE),
                            "dataset" => $return)
        ]);
    }
    
    
    /**
     * Save a company
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function save(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        $input["number"] = str_replace(array(".","/","-"), "", $input["number"]);
        $param="";
        //Update
        if (is_numeric($input['id'])) {
            $param="/".$input['id'];
            $message = $this->model->update($input) > 0 ?   array(  "type"=>"success",
                                                             "message"=>"Salvo com sucesso!")
                                                  :   array(  "type"=>"danger",
                                                             "message"=>"Erro ao salvar o cadastro");                                                          
        }
        
        //Insert
        if (!is_numeric($input['id'])) {
            $message = $this->model->insert($input) > 0 ?   array(  "type"=>"success",
                                                             "message"=>"Salvo com sucesso!")
                                                  :   array(  "type"=>"danger",
                                                             "message"=>"Erro ao salvar o cadastro");
        }
        
        $this->container->flash->addMessage("msg",json_encode($message));
                
        return $response->withStatus(200)->withHeader('Location', '/company/form'.$param);
    }
    
    


    /**
     * Delete a company
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function del(Request $request, Response $response, array $args)
    {  
        if (isset($args['id'])) {

            $n = $this->model->delete(json_decode($args['id'], true));
            
            $message =  $n > 0  ?   array(  "type"=>"success",
                                           "message"=>"Excluído $n registro(s) com sucesso!")
                               :   array(  "type"=>"danger",
                                           "message"=>"Erro ao excluir o cadastro");
                                           
            $this->container->flash->addMessage("msg",json_encode($message));
        }
     
        
        
        return $response->withStatus(200)->withHeader('Location', '/company');
    }
    
}