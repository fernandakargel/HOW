<?php
namespace Modules\Pgestao\Role;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;
use Modules\Pgestao\Department\DepartmentModel;

/**
 * RoleController
 * 
 * @namespace Modules\Pgestao\Role
 * 
 */
class RoleController
{
    
    /**
     * 
     * @var Container
     */
    protected $container;
    
    /**
     * 
     * @var RoleModel
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
        $this->model = new RoleModel($container);
    }
    
    /**
     * Show list of role
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
        
        return $this->container->view->render($response, 'Pgestao/role/role_list.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE),
                            "dataset" => $return)
        ]);
    }
    
       
    /**
     * Show role form
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function form(Request $request, Response $response, array $args)
    {  
        //Get message
        $message = $this->container->flash->getFirstMessage("msg");
        
        //Get user info
        $user = $this->container->session->get('user');
        
        $return = isset($args['id']) ? $this->model->selectByID($args['id']) : array();
        
        //Get department
        $department = new DepartmentModel($this->container);

        return $this->container->view->render($response, 'Pgestao/role/role_form.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE),
                            "department" => $department->selectByCompany($user->company),
                            "dataset" => $return)
        ]);
    }
    
    
    /**
     * Save a role
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
            $message = $this->model->update($input) > 0 ? array(  "type"=>"success",
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
                
        return $response->withStatus(200)->withHeader('Location', '/role/form'.$param);
    }
    
    


    /**
     * Delete a role
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
     
        
        
        return $response->withStatus(200)->withHeader('Location', '/role');
    }
    
 
    /**
     * Get roles in a department 
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function getByDepartment(Request $request, Response $response, array $args)
    {  

        $rows["dataset"] = $this->model->selectByDepartment($args["department"]);
        
        if ($rows["dataset"]) {
            return $response->withJson($rows);
        }
    }
  }