<?php
namespace Modules\Pgestao\Department;

use Psr\Container\ContainerInterface;
use Slim\Container;

/**
 * DepartmentModel
 * 
 * @namespace Modules\Pgestao\Department
 *
 */
class DepartmentModel{
    
    /**
     *
     * @var Container
     */
    protected $container;
    
    
    /**
     * Set Container
     *
     * @param Container $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
       
    
    /**
     * Select all department
     *
     * @return array
     */
    public function selectAll() : array{
        $sql = "SELECT id,name,description
                    FROM department
                    ORDER BY `name`";
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result
        : array();
    }
    
    /**
     * Select a department by ID
     *
     * @param int $id
     * @return \PDO::FETCH_OBJ
     */
    public function selectByID($id) {
        
        $sql = "SELECT id,name,description
                    FROM department
                    WHERE id=:id
                    LIMIT 1";
        $sth = $this->container->db->prepare($sql);
        
        $sth->bindParam("id", $id, \PDO::PARAM_INT);
        
        $sth->execute();
        
        if ($sth->rowCount() > 0) {
            $result = $sth->fetch(\PDO::FETCH_OBJ);
        }
        
        return $result ?? array();
    }
    
    
    public function selectByCompany($company) {
           
        $sql = "SELECT id,name,description
                    FROM department
                    WHERE company=:company
                    ORDER BY name";
        $sth = $this->container->db->prepare($sql);
        
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        
        $sth->execute();
        
        if ($sth->rowCount() > 0) {
            $result = $sth->fetchAll();
        }
        
        return $result ?? array();
    }
    
    /**
     * Insert a department
     *
     * @param array $params
     * @return int
     */
    public function insert(array $params) : int{
        
        $sql = "INSERT INTO department (name,description,company)
                VALUES(:name,:description,:company)";
        
        $name = $params["name"];
        $description = $params["description"];
        $company = $params["company"];
        
        //Save
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("description", $description, \PDO::PARAM_STR);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        
        
        $sth->execute();
        return $sth->rowCount();
    }
    
    
    /**
     * Upddate a department
     *
     * @param array $params
     * @return int
     */
    public function update(array $params) : int{
        
        $sql = "UPDATE department SET
                    name=:name,
                    description=:description,
                    company=:company
                WHERE id=:id
                LIMIT 1";
        
        $id = $params["id"];
        $name = $params["name"];
        $description = $params["description"];
        $company = $params["company"];
        
        //Update
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("description", $description, \PDO::PARAM_STR);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        $sth->bindParam("id", $id, \PDO::PARAM_INT);
        
        $sth->execute();
        return $sth->rowCount();
    }
    
    /**
     * Delete a department
     *
     * @param array $ids
     * @return int
     */
    public function delete(array $ids) : int{
        
        try {
            $values = implode(",", $ids);
            $sql = "DELETE FROM department WHERE id IN($values)";
            $sth = $this->container->db->prepare($sql);
            $sth->execute();
            return $sth->rowCount();
        } catch (\Exception $e) {
            if($e->getCode() == 23000)
                $message = array(  "type"=>"danger",
                    "message"=>"Não é permitido excluir um departamento se ele estiver cadastrada em uma função.");
                
                $this->container->flash->addMessage("msg",json_encode($message));
                
                return 0;
        }
    }
    
}