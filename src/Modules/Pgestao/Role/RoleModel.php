<?php
namespace Modules\Pgestao\Role;

use Slim\Container;
use Psr\Container\ContainerInterface;

/**
 * RoleController
 *
 * @namespace Modules\Pgestao\Role
 *
 */
class RoleModel{
    
    /**
     * 
     * @var Container
     */
    protected $container;
    
    /**
     * Set Container
     *
     *  @param ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    
    /**
     * Select all role
     *
     * @return array
     */
    public function selectAll() : array{
        $sql = "SELECT  r.id AS id,
        				r.name AS name,
        				r.description AS description,
        				d.name AS department
                FROM role AS r
                INNER JOIN department AS d ON r.department=d.id
                ORDER BY name";
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result
        : array();
    }
    
    /**
     * Select a role by ID
     *
     * @param int $id
     * @return \PDO::FETCH_OBJ
     */
    public function selectByID(int $id) {
        
        $sql = " SELECT  r.id AS id,
    				name,
    				description,
    				department
                FROM role AS r
                WHERE r.id=:id
                LIMIT 1";
        $sth = $this->container->db->prepare($sql);
        
        $sth->bindParam("id", $id, \PDO::PARAM_INT);
        
        $sth->execute();
        
        if ($sth->rowCount() > 0) {
            $result = $sth->fetch(\PDO::FETCH_OBJ);
        }
        
        return $result ?? array();
    }
    
    public function selectByCompany(int $company) : array{
        $sql = "SELECT  r.id AS id,
        				r.name AS name,
        				r.description AS description,
        				d.name as department
                FROM role AS r
                INNER JOIN department AS d ON r.department=d.id
                WHERE d.company=:company
                ORDER BY name";
        $sth = $this->container->db->prepare($sql);
        
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result
        : array();
    }
    
    public function selectByDepartment(int $department) : array{
        $sql = "SELECT  id,
        				name,
        				description,
        				department
                FROM role
                WHERE department=:department
                ORDER BY name";
        $sth = $this->container->db->prepare($sql);
        
        $sth->bindParam("department", $department, \PDO::PARAM_INT);
        
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result
        : array();
    }
    
    /**
     * Insert a role
     *
     * @param array $params
     * @return int
     */
    public function insert(array $params) : int{
        
        $sql = "INSERT INTO role (name,description,department)
                VALUES(:name,:description,:department)";
        
        //Save
        $sth = $this->container->db->prepare($sql);
        
        $name = $params["name"];
        $description = $params["description"];
        $department = $params["department"];
        
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("description", $description, \PDO::PARAM_STR);
        $sth->bindParam("department", $department, \PDO::PARAM_INT);
        
        
        $sth->execute();
        return $sth->rowCount();
    }
    
    
    /**
     * Upddate a role
     *
     * @param array $params
     * @return int
     */
    public function update(array $params) : int{
        
        $sql = "UPDATE role SET
                    name=:name,
                    description=:description,
                    department=:department
                WHERE id=:id
                LIMIT 1";
        
        //Update
        $sth = $this->container->db->prepare($sql);
        $id = $params["id"];
        $name = $params["name"];
        $description = $params["description"];
        $department = $params["department"];
        
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("description", $description, \PDO::PARAM_STR);
        $sth->bindParam("department", $department, \PDO::PARAM_INT);
        $sth->bindParam("id", $params["id"], \PDO::PARAM_INT);
        
        $sth->execute();
        return $sth->rowCount();
    }
    
    /**
     * Delete a role
     *
     * @param array $ids
     * @return int
     */
    public function delete(array $ids) : int{
        try {
            $values = implode(",", $ids);
            $sql = "DELETE FROM role WHERE id IN($values)";
            $sth = $this->container->db->prepare($sql);
            $sth->execute();
            return $sth->rowCount();
        } catch (\Exception $e) {
            if($e->getCode() == 23000)
                $message = array(  "type"=>"danger",
                    "message"=>"Não é permitido excluir uma função se ela estiver cadastrada em um colaborador.");
                
                $this->container->flash->addMessage("msg",json_encode($message));
                
                return 0;
        }
    }
    
}