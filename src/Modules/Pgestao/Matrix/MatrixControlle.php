<?php
namespace Modules\Pgestao\Matrix;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;
use Modules\Pgestao\Staff\StaffModel;
use Modules\Pgestao\Department\DepartmentModel;
use Modules\Pgestao\Process\ProcessModel;

/**
 * MatrixControlle
 * 
 * @namespace Modules\Pgestao\Matrix
 * 
 */
class MatrixControlle
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
     * Show list of matrix
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function list(Request $request, Response $response, array $args)
    {  
        $input = $request->getParsedBody();
        $user =  $this->container->session->get('user');    
        
        $department = new DepartmentModel($this->container);
        $departments = $department->selectByCompany($user->company);
        
        $return = $input["department"] ? $this->process($input["department"]) : array();
                
        $message = isset($input["submited"]) &&  (count($return)==0) ? array(  "type"=>"danger",
                                                "message"=>"Não há colaboradores ou procedimentos cadastradas para este departamento.")
                                     : ""; 

        return $this->container->view->render($response, 'Pgestao/matrix/matrix.phtml', [
            "user" => $user,
            "page" => array("message" => $message,
                            "return" => $return,
                            "department" => $departments,
                            "filter" => $input,
                            "print"=>TRUE)
        ]);
    }
    
    public function print(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        $user =  $this->container->session->get('user');
        
        $department = new DepartmentModel($this->container);
        $departments = $department->selectByCompany($user->company);
        
        $departmentInfo = array();
        if(isset($input["department"])) {
            $key = array_search($input["department"], array_column($departments, 'id'));
            $departmentInfo = $departments[$key];
        }
        
        $return = $input["department"] ? $this->process($input["department"]) : array();
        
        
        $message = count($return)==0 ? array(  "type"=>"danger",
            "message"=>"Não há colaboradores ou habilidades cadastradas para este departamento.")
            : "";
            
            return $this->container->view->render($response, 'Pgestao/matrix/print.phtml', [
                "user" => $user,
                "page" => array("message" => $message,
                    "return" => $return,
                    "department" => $departments,
                    "departmentInfo" => $departmentInfo,
                    "filter" => $input,
                    "print"=>TRUE)
            ]);
    }
    
    
    private function process($department) {
        
        $user =  $this->container->session->get('user');
        
        $staff = new StaffModel($this->container);
//         $staffs = $staff->selectByCompany($user->company);
        $staffs = $staff->selectByDepartment($department);
        
        $return = array();
        if(\count($staffs) > 0) {
            
            $process = new ProcessModel($this->container);
            $skills = $process->selectByDepartment($department);
    
                    
            $return[0][0]["name"] = "Nível";
            $return[0][0]["photo"] = 1;
            
            $i=1;
            $matrix=array();
            foreach ($staffs as $s) {
                
                $skp = $staff->selectStaffKnowProcess($s["id"]);
    
                foreach ($skp as $value) {
                    $matrix[$value["process"]][$value["staff"]]["level"]=$value["level"];
                    $matrix[$value["process"]][$value["staff"]]["coach"]=$value["coach"];
                    $matrix[$value["process"]][$value["staff"]]["date"]=$value["date"];
                }
                
                
                $return[0][$i]["name"] = $s["name"];
                $return[0][$i]["photo"] = $s["photo"];
                //$return[0][$i]["role"] = $staff["role"];
                //$return[0][$i]["department"] = $staff["department"];
                $i++;
            }
            
            $i=1;
            
            foreach ($skills as $skill) {
                $x=0;
                $return[$i][$x]["name"] = $skill["name"];
                $return[$i][$x]["description"] = $skill["description"];
                foreach ($staffs as $staff) {
                    $x++;
                    $return[$i][$x]["level"] = $matrix[$skill["id"]][$staff["id"]]["level"] ?? 0;
                    $return[$i][$x]["name"] = $skill["name"];
                    $return[$i][$x]["description"] = $skill["description"];
                    $return[$i][$x]["coach"] = $matrix[$skill["id"]][$staff["id"]]["coach"] ?? "";
                    $return[$i][$x]["date"] = $matrix[$skill["id"]][$staff["id"]]["date"] ?? "";
                }
                $i++;
            }
        }
        
        return $return;
    }
     
}