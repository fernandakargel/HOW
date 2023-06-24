<?php
namespace Modules\Pgestao\Department;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;
use Modules\Pgestao\Process\ProcessModel;

/**
 * DepartmentController
 * 
 * @namespace Modules\Pgestao\Department
 * 
 */
class DepartmentController
{
    
    /**
     * Container
     * 
     * @var Container
     */
    protected $container;
    
    /**
     * Model
     * 
     * @var DepartmentModel
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
        $this->model = new DepartmentModel($container);
    }
    
    /**
     * Show list of department
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

        
        return $this->container->view->render($response, 'Pgestao/department/department_list.phtml', [
            "user" => $this->container->session->get('user'),            
            "page" => array("message" => json_decode($message, TRUE),
                            "dataset" => $return)
        ]);
    }
    
       
    /**
     * Show department form
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function form(Request $request, Response $response, array $args)
    {  
        $message = $this->container->flash->getFirstMessage("msg");
        
        //Department
        $return = isset($args['id']) ? $this->model->selectByID($args['id']) 
                                     : array();
        //Department process
        $process = new ProcessModel($this->container);   
        $departmentProcess = isset($args['id']) ? $process->selectByDepartment($args['id'])
                                                : array();
        
        return $this->container->view->render($response, 'Pgestao/department/department_form.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE), 
                            "process" => $departmentProcess,
                            "dataset" => $return)
        ]);
    }
    
    
    /**
     * Save a department
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
                
        return $response->withStatus(200)->withHeader('Location', '/department/form'.$param);
    }
    
    


    /**
     * Delete a department
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
      
        return $response->withStatus(200)->withHeader('Location', '/department');
    }
    
    }