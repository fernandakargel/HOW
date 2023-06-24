<?php
namespace Modules\Pgestao\Staff;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;
use \Gumlet\ImageResize;
use Modules\Pgestao\Role\RoleModel;
use Modules\Pgestao\Department\DepartmentModel;
use Modules\Pgestao\Process\ProcessModel;

/**
 * StaffController
 *
 * @namespace Modules\Pgestao\Staff
 *        
 */
class StaffController
{

    /**
     * 
     * @var Container
     */
    protected $container;
    
    /**
     * 
     * @var StaffModel
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
        $this->model = new StaffModel($container);
    }

    /**
     * Show list of staff
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function list(Request $request, Response $response, array $args)
    {
        // Get message
        $message = $this->container->flash->getFirstMessage("msg");
        // Get user info
        $user = $this->container->session->get('user');
        // Get list
        $return = $user->role == "admin" ? $this->model->selectAll() : $this->model->selectByCompany($user->company);
        
//         \var_dump($return);die;
        
        return $this->container->view->render($response, 'Pgestao/staff/staff_list.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array(
                "message" => json_decode($message, TRUE),
                "dataset" => $return
            )
        ]);
    }

    /**
     * Show staff form
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function form(Request $request, Response $response, array $args)
    {
        $message = $this->container->flash->getFirstMessage("msg");
        
        $user = $this->container->session->get('user');
        
        $return = isset($args['id']) ? $this->model->selectByID($args['id'])
                                     : array();
        
        // Load departments
        $department = new DepartmentModel($this->container);
        
        $process = new ProcessModel($this->container);
        
        $allProcess = isset($args['id']) ? $process->selectByCompany($user->company)
                                         : array();
        
        
        $departmentProcess = isset($args['id']) ? $process->selectByDepartment($return->department)
                                                : array();
        
        $staffKnowProcess = isset($args['id']) ? $this->model->selectStaffKnowProcess($args['id'])
                                        : array();
        
        $knowledge = array();
        
        foreach ($departmentProcess as $dp) {
            
            $key = array_search($dp["id"], array_column($staffKnowProcess, 'process'));
            
            if(\is_numeric($key)) {
                $staffKnowProcess[$key]["processName"] = $dp["name"];
                $knowledge[] = $staffKnowProcess[$key];
            } else {
                $knowledge[] = array("level"=>0,
                                     "process"=>$dp["id"],
                                     "processName"=>$dp["name"]);
            }
            
            
        }                                
             
        
        // Load roles
        $role = new RoleModel($this->container);
        
        return $this->container->view->render($response, 'Pgestao/staff/staff_form.phtml', [
            "user" => $user,
            "page" => array(
                "message" => json_decode($message, TRUE),
                "dataset" => $return,
                "department" => $department->selectByCompany($user->company),
                "knowledge"=>$knowledge,
                "process"=>$allProcess,
                "role" => $role->selectByCompany($user->company)
            )
        ]);
    }

    /**
     * Save a staff
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function save(Request $request, Response $response, array $args)
    {
        $get = \json_decode(@$args["param"], TRUE);
        $param = $message = "";
        
        if ($get["id"] > 0) {
            $param = "/" . $get['id'];
            
            $message = $this->model->updateStatus($get) > 0 ? array(
                "type" => "success",
                "message" => "Status alterado com sucesso!"
            ) : array(
                "type" => "danger",
                "message" => "Erro ao alterar o status"
            );
            
        } else {
            
            $input = $request->getParsedBody();
           
            //Resize image
            if ($input["photo"]) {
                $header = substr($input["photo"],0,strpos($input["photo"],",")+1);
                $photo = substr($input["photo"],strpos($input["photo"],",")+1);
                
                $image = ImageResize::createFromString(base64_decode($photo));
                $image->resizeToHeight(230);
                $encoded = \base64_encode($image->getImageAsString());
                $input["photo"] = "$header$encoded";
            }            
            
            // Update
            if (is_numeric($input['id'])) {
                $param = "/" . $input['id'];
                $message = $this->model->update($input) > 0 ? array(
                    "type" => "success",
                    "message" => "Salvo com sucesso!"
                ) : array(
                    "type" => "danger",
                    "message" => "Erro ao salvar o cadastro"
                );
            }
            
            // Insert
            if (! is_numeric($input['id'])) {
                $staff_id = $this->model->insert($input);
                if ($staff_id > 0) {
                    $param = "/$staff_id";
                    $message = array(
                        "type" => "success",
                        "message" => "Salvo com sucesso!"
                    );
                } else {
                    $message = array(
                        "type" => "danger",
                        "message" => "Erro ao salvar o cadastro"
                    );
                }
            }
            
        }
        $this->container->flash->addMessage("msg", json_encode($message));
        
        return $response->withStatus(200)->withHeader('Location', '/staff/form' . $param);
    }


    /**
     * Delete a staff
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function del(Request $request, Response $response, array $args)
    {
        if (isset($args['id'])) {
            
            //Delete staff_know_process
            $this->model->deleteSkills(json_decode($args['id'], true));
            
            $n = $this->model->delete(json_decode($args['id'], true));
            
            $message = $n > 0 ? array(
                "type" => "success",
                "message" => "Excluído $n registro(s) com sucesso!"
            ) : array(
                "type" => "danger",
                "message" => "Erro ao excluir o cadastro"
            );
            
            $this->container->flash->addMessage("msg", json_encode($message));
        }
        
        return $response->withStatus(200)->withHeader('Location', '/staff');
    }
    
    
    /**
     * Delete a staff
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function addSkill(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();

        $param = "/".$input['staff'];
       
        // Insert
        if (! $this->model->hasSkill($input["staff"], $input["process"])) {
            $count = $this->model->insertSkill($input);
            if ($count > 0) {
               
                $message = array(
                    "type" => "success",
                    "message" => "Salvo com sucesso!"
                );
            } else {
                $message = array(
                    "type" => "danger",
                    "message" => "Erro ao salvar o cadastro"
                );
            }
        } else {
            
 
            
            $count = $this->model->updateSkill($input);
            if ($count > 0) {
                
                $message = array(
                    "type" => "success",
                    "message" => "Atualizado com sucesso!"
                );
            } else {
                $message = array(
                    "type" => "danger",
                    "message" => "Erro ao atualizar o cadastro"
                );
            }
        }
        

        $this->container->flash->addMessage("msg", json_encode($message));
        
        return $response->withStatus(200)->withHeader('Location', '/staff/form' . $param);
    }
}