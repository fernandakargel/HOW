<?php
namespace Modules\System;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;
use Modules\Pgestao\Company\CompanyModel;
use Bruner\Security\Security;


/**
 * SystemController
 * 
 * @namespace Modules\System
 */
class SystemController
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
     * Index page
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function home(Request $request, Response $response, array $args)
    {
        $message = $this->container->flash->getFirstMessage("msg");

        if($this->container->session->exists('user')) {

            $user = $this->container->session->get('user');
            $company = new CompanyModel($this->container);

        
            return $this->container->view->render($response, 'system/index.phtml', [
                "user" => $user,
                "page" => $company->selectCompanyInfo($user->company)[0]
            ]); 
        }

        return $this->container->view->render($response, 'system/login.phtml', [
            "page" => array("message" => json_decode($message, TRUE))
        ]);     
    }

    /**
     * Login page
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function login(Request $request, Response $response, array $args)
    {

        //Recebe e aplica a segurança no POST
        $input = $request->getParsedBody();
        $email = Security::encrypt($input["email"]) ?? FALSE;
        $passw = Security::hash($input["password"]) ?? FALSE;
        
        //Informado usuário e senha
        if ($email && $passw) {
            $sql = "SELECT uid, name, email, role, status, photo, company 
                        FROM user 
                        WHERE email=:email AND password=:passw 
                        LIMIT 1";
            
            $sth = $this->container->db->prepare($sql);
           
            $sth->bindParam("email", $email);
            $sth->bindParam("passw", $passw);
            
            $sth->execute();
            
            $user = $sth->fetch(\PDO::FETCH_OBJ);
            
            $user->status = $user->status ?? 99;
            
            switch ($user->status) {
                
                case 0:
                case 3:
                    $message = array(  "type"=>"danger",
                                        "message"=>"Usuário desabilitado ou bloqueado, contacte o administrador do sistema.");

                    break;
                case 2:
                    $message = array(  "type"=>"danger",
                                        "message"=>"Este usuário não está validado, verifique seu e-mail.");
   
                    break;
                    
                case 1:
                    $user->menu = $this->getMenu($user->role);
                    $user->allowed = $this->getPermissions($user->role);
                    $this->container->session->set('user', $user);  
                    break;
                    
                default:
                    $message = array(  "type"=>"danger",
                                       "message"=>"Usuário ou senha inválido");
                    break; 
            }
        }
        
        if ($message) $this->container->flash->addMessage("msg",json_encode($message));
        
        //Redireciona uma página
        return $response->withStatus(200)->withHeader('Location', '/');
    }
        
    /**
     * Get full menu
     * 
     * @todo Tornar o menu recursivo, limitado a 4 níveis seguindo esta estrutura
     * 
     * @param String $roles
     * @return void
     */
    private function getMenu(String $roles) : array {
        $sql = "SELECT id, name, label, url, title, icon, parent 
                    FROM menu 
                    WHERE display=1 AND allow LIKE :role 
                    ORDER BY `order`";
        $sth = $this->container->db->prepare($sql);
        
        $role = "%;".$roles.";%";
        $sth->bindParam("role", $role, \PDO::PARAM_STR);
        
        $sth->execute();
        $menus = $sth->fetchAll();
        
        $finalMenu = array();

        foreach ($menus as $menu) {
            
            if ($menu["parent"] == 0) {
                $finalMenu[$menu["id"]]["info"] = $menu;
            }
                
            if ($menu["parent"] != 0) {
                $finalMenu[$menu["parent"]]["options"][$menu["id"]]["info"] = $menu;
                $finalMenu[$menu["parent"]]["options"][$menu["id"]]["options"] = NULL;
            }
        }
        
        return $finalMenu;
       
    }
    
    /**
     * Get only the permissions
     * 
     * @param String $roles
     * @return array
     */
    private function getPermissions(String $roles) : array {
        $sql = "SELECT name 
                    FROM menu 
                    WHERE allow LIKE :role";
        $sth = $this->container->db->prepare($sql);
        
        $role = "%;".$roles.";%";
        $sth->bindParam("role", $role, \PDO::PARAM_STR);
        
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_COLUMN, 0);
    }
    
    
    /**
     * Logout page
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function logout(Request $request, Response $response, array $args)
    {
        
        $this->container->session->delete('user');
        $this->container->session->delete('menu');
        $session = $this->container->session;
        $session::destroy();
        
        $message = array();
        if(isset($args["msg"])) {
            $message = array(   "type"=>"danger",
                                "message"=>str_replace("\"", "", $args["msg"]));
        }
        
        return $this->container->view->render($response, 'system/login.phtml', [
            "page" => array("message" => $message)
        ]);    
    }

    /**
     * Login webservice
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function ws_login(Request $request, Response $response, array $args)
    {
        
        $input = $request->getParsedBody();
        $user = $input["email"] ?? FALSE;
        $pass = $input["password"] ?? FALSE;
        
        $rows["data"] = FALSE;
        
//         if ($user && $pass) {
//             $mapper = new UserMapper($this->container->db);
//             $rows["data"] = $user = $mapper->login($user, $pass);
//         }
        
        $rows["data"] = array(
            "status" => "ok",
            "uid" => 1,
            "user" => $user,
            "pass" => $pass
        );
        
        if ($rows["data"]) {
            return $response->withJson($rows);
        }
        
        return $response->withStatus(401);
    }
}