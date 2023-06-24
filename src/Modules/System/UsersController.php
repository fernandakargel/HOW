<?php
namespace Modules\System;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;
use Bruner\Security\Security;
use Modules\Pgestao\Company\CompanyModel;

/**
 * UsersController
 * 
 * @namespace Modules\System
 */
class UsersController
{
    
    /**
     *
     * @var \Psr\Container\ContainerInterface
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
     * Show list of users
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
        $return = $user->role == "admin" ? $this->selectAll() : $this->selectByCompany($user->company);
        
        return $this->container->view->render($response, '/system/user/users.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE),
                            "dataset" => $return)
        ]);
    }
    
       
    /**
     * Show user form
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function form(Request $request, Response $response, array $args)
    {  
        
        $message = $this->container->flash->getFirstMessage("msg");
        
        $userSession = $this->container->session->get('user');
        
        $user = isset($args['uid']) ? $this->selectByID($args['uid']) 
                                    : array();
                            
        $userRoles = \json_decode(SYS_USER_ROLES,TRUE);
        if ($userSession->role != "admin") 
            unset($userRoles["admin"]);
                                    
        $company = new CompanyModel($this->container);

        
        $returnCompany = $userSession->role == "admin" ? $company->selectAll() 
                                                       : array( 0 => $company->selectByID($userSession->company));
        
        return $this->container->view->render($response, '/system/user/usersForm.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE),
                            "dataset" => $user,
                            "companies" => $returnCompany,
                            "userRoles" => $userRoles)
        ]);
    }
    
    
    /**
     * Profile form
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function profile(Request $request, Response $response, array $args)
    {
        $message = $this->container->flash->getFirstMessage("msg");
        
        $user = isset($args['uid']) ? $this->selectByID($args['uid'])
                                    : array();
        
        
        
        return $this->container->view->render($response, 'system/user/profile.phtml', [
            "user" => $this->container->session->get('user'),
            "page" => array("message" => json_decode($message, TRUE),
                            "dataset" => $user)
        ]);
    }
    
    
    /**
     * Save a user
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
        if (is_numeric($input['uid'])) {
            $param="/".$input['uid'];
            
            
            $message = $this->update($input) > 0 ?   array(  "type"=>"success",
                                                            "message"=>"Salvo com sucesso!")
                                                :    array(  "type"=>"danger", 
                                                             "message"=>"Erro ao salvar o cadastro."); 
        }
        
        //Insert
        if (!is_numeric($input['uid'])) {
            $message = $this->insert($input) > 0 ?   array(  "type"=>"success",
                                                            "message"=>"Salvo com sucesso!")
                                                :    array(  "type"=>"danger",
                                                             "message"=>"Erro ao salvar o cadastro");
        }
        

        $this->container->flash->addMessage("msg",json_encode($message));
        return $response->withStatus(200)->withHeader('Location', '/user/form'.$param);
    }
    
    /**
     * Save profile
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function saveProfile(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        $param="";
        //Update
        if (is_numeric($input['uid'])) {
            $param="/".$input['uid'];
            $message = $this->update($input) > 0    ?   array(  "type"=>"success",
                                                                "message"=>"Salvo com sucesso!")
                                                    :   array(  "type"=>"danger",
                                                                "message"=>"Erro ao salvar o cadastro.");
        }
        
        $this->container->flash->addMessage("msg",json_encode($message));
        
        return $response->withStatus(200)->withHeader('Location', '/profile'.$param);
    }
    
    


    /**
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    public function del(Request $request, Response $response, array $args)
    {  
        if (isset($args['uid'])) {

            $n = $this->delete(json_decode($args['uid'], true));
            
            $message =  $n > 0  ?   array(  "type"=>"success",
                                            "message"=>"Excluído $n registro(s) com sucesso!")
                                :   array(  "type"=>"danger",
                                            "message"=>"Erro ao excluir o cadastro");
                                           
           $this->container->flash->addMessage("msg",json_encode($message));
        }
     
        
        
        return $response->withStatus(200)->withHeader('Location', '/user');
    }
    
    
    
    /**
     * Select all users
     * 
     * @return array
     */
    protected function selectAll() : array{
        $sql = "SELECT uid, name, email, status, role
                    FROM user
                    ORDER BY `name`";
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        $users = $sth->fetchAll();

        return $sth->rowCount() > 0 ? $this->format($users) 
                                    : array();
    }
    
    protected function selectByCompany($company) : array{
        $sql = "SELECT uid, name, email, status, role
                    FROM user
                    WHERE company=:company 
                    ORDER BY `name`";
        
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        $sth->execute();
        $users = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $this->format($users)
                                    : array();
    }
    
    /**
     * Select a user by ID
     * 
     * @param int $id
     * @return \PDO::FETCH_OBJ
     */
    protected function selectByID(int $id) {
        
        $sql = "SELECT uid, name, email, password, status, role
                    FROM user
                    WHERE uid=:uid
                    LIMIT 1";
        $sth = $this->container->db->prepare($sql);
        
        $sth->bindParam("uid", $id, \PDO::PARAM_INT);
        
        $sth->execute();
        
        if ($sth->rowCount() > 0) {
            $user = $sth->fetch(\PDO::FETCH_OBJ);
            $user->name = Security::decrypt($user->name);
            $user->email = Security::decrypt($user->email);
            $user->password = "";
        }
        
        return $user ?? array();
    }
    
    
    
    /**
     * Insert a user
     *
     * @param array $params
     * @return int
     */
    protected function insert(array $params) : int{
        
        $sql = "INSERT INTO user (
                    name,
                    email,
                    password,
                    status,
                    company,
                    role)
                VALUES(
                    :name,
                    :email,
                    :password,
                    :status,
                    :company,
                    :role)";
        
        //Encrypt data
        $name = Security::encrypt($params['name']);
        $email =  Security::encrypt($params['email']);
        $password = isset($params['password'])  ? Security::hash($params['password'])
                                                : FALSE;
        
        //Save
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("email", $email, \PDO::PARAM_STR);
        $sth->bindParam("password", $password, \PDO::PARAM_STR);
        $sth->bindParam("status", $params['status'], \PDO::PARAM_INT);
        $sth->bindParam("role", $params['roles'], \PDO::PARAM_STR);
        $sth->bindParam("company", $params['company'], \PDO::PARAM_INT);
        $sth->execute();
        return $sth->rowCount();
    }
    
    
    /**
     * Upddate a user
     *
     * @param array $params
     * @return int
     */
    protected function update(array $params) : int{
        
        //Check if is set password
        if ($params['password']) {
            $password = Security::hash($params['password']);
            $pass = "password = :password,";
        }
        
        //Check if is set status
        $status = $params['status'] ? "status = :status," : "";
        
        //Check if is set roles
        $roles = $params['roles'] ? "role = :role," : "";
        
        $sql = "UPDATE user SET
                    name = :name,
                    $pass
                    $status
                    $roles
                    email = :email                   
                WHERE uid=:uid
                LIMIT 1";
        
        //Encrypt data
        $name = Security::encrypt($params['name']);
        $email =  Security::encrypt($params['email']);
        
        
        //Update
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("email", $email, \PDO::PARAM_STR);                
        $sth->bindParam("uid", $params['uid'], \PDO::PARAM_INT);       
       
        if ($params['status']) $sth->bindParam("status", $params['status'], \PDO::PARAM_INT);
        if ($params['roles']) $sth->bindParam("role", $params['roles'], \PDO::PARAM_STR);
        if ($params['password']) $sth->bindParam("password", $password, \PDO::PARAM_STR);
        
            
        $sth->execute();
        return $sth->rowCount();
    }
    
    /**
     * Delete a user
     * 
     * @param array $ids
     * @return int
     */
    protected function delete(array $ids) : int{
        
        $values = implode(",", $ids);    
        $sql = "DELETE FROM user WHERE uid IN($values)";                  
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        return $sth->rowCount();
    }
    
    /**
     * Format information to present
     * @param array $users
     */
    protected function format($users) : array{
        //Status
        $status = array("0" => "Disabled",
            "1" => "Active",
            "2" => "Need validation",
            "3" => "Blocked");
        
        foreach ($users as $user) {
            $user["name"] = Security::decrypt($user["name"]);
            $user["email"] = Security::decrypt($user["email"]);
            //Show description not ID
            $user["status"] = $status[$user["status"]];
            $nusers[] = $user;
        }
       
        return  $nusers;
    }
}