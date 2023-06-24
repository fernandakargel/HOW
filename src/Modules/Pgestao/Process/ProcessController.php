<?php
namespace Modules\Pgestao\Process;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;
use Modules\Pgestao\Department\DepartmentModel;

/**
 * ProcessController
 *
 * @namespace Modules\Pgestao\Process
 * 
 */
class ProcessController
{
    
    /**
     * 
     * @var Container
     */
    protected $container;
    
    /**
     * 
     * @var ProcessModel
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
        $this->model = new ProcessModel($container);
    }

    /**
     * Show list of process
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function list(Request $request, Response $response, array $args)
    {
        //Get message
        $message = $this->container->flash->getFirstMessage("msg");
        //Get user info
        $user = $this->container->session->get('user');
        //Get list
        $return = $user->role == "admin" ? $this->model->selectAll() : $this->model->selectByCompany($user->company);
        
        return $this->container->view->render($response, 'Pgestao/process/process_list.phtml', [
            "user" => $user,
            "page" => array("message" => json_decode($message, TRUE),
                                        "dataset" => $return)
        ]);
    }
    
       
    /**
     * Show process form
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
       
        //Get user info
        $user = $this->container->session->get('user');
        
        //Get department
        $department = new DepartmentModel($this->container);
                                    
        return $this->container->view->render($response, 'Pgestao/process/process_form.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE),
                            "department" => $department->selectByCompany($user->company),
                            "dataset" => $return)
        ]);
    }
    
    
    /**
     * Save a process
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function save(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
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
                
        return $response->withStatus(200)->withHeader('Location', '/process/form'.$param);
    }
    
    public function saveByDepartment(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        
        
        
        $i=0;
        $param = $input["department"];
        
        //Remove empty fields
        $input["process"] = array_filter($input["process"], function($value) { return $value !== ''; });
        
        
        foreach ($input["process"] as $process) {
            $this->model->insert(array( "name" => $process, 
                                        "company"=>$input["company"], 
                                        "department"=>$param)) < 1 ?? $i++;
        }
        
        $message = $i === 0 ?   array(  "type"=>"success",
                                        "message"=>"Salvo com sucesso!")
                            :   array(  "type"=>"danger",
                                        "message"=>"Erro ao salvar o cadastro");
                     
        $this->container->flash->addMessage("msg",json_encode($message));
        
        return $response->withStatus(200)->withHeader('Location', '/department/form/'.$param);
    }
    
    
    /**
     * Delete a process
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function delByDepartment(Request $request, Response $response, array $args)
    {     
        $params = \json_decode($args['param'], TRUE);

        $n = $this->model->delete(array($params["id"]));
        
        $message =  $n > 0  ?   array(  "type"=>"success",
            "message"=>"Excluído $n registro(s) com sucesso!")
            :   array(  "type"=>"danger",
                "message"=>"Erro ao excluir o cadastro");
            
            $this->container->flash->addMessage("msg",json_encode($message));

        
        
        
        return $response->withStatus(200)->withHeader('Location', '/department/form/'.$params["department"]);
    }

    /**
     * Delete a process
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
     
        
        
        return $response->withStatus(200)->withHeader('Location', '/process');
    }
        
 }