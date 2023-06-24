<?php
namespace Modules\Pgestao\Process;

use Slim\Container;
use Psr\Container\ContainerInterface;

/**
 * ProcessModel
 * 
 * @namespace Modules\Pgestao\Process;
 * 
 */

class ProcessModel {
    
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
    
    
    public function selectByCompany(int $company){
        $sql = "SELECT id,name,description,company
                    FROM process
                    WHERE company=:company
                    ORDER BY name";
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result
        : array();
    }
    
 
    public function selectByDepartment(int $department){
        $sql = "SELECT id,name,description,company,department
                    FROM process
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
     * Select all process
     *
     * @return array
     */
    public function selectAll() : array{
        $sql = "SELECT p.id, p.name, p.description, d.name as department, p.company
                    FROM process AS p
                    INNER JOIN department AS d ON p.department=d.id
                    ORDER BY name";
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result
        : array();
    }
    
    /**
     * Select a process by ID
     *
     * @param int $id
     * @return \PDO::FETCH_OBJ
     */
    public function selectByID(int $id) {
        
        $sql = "SELECT id, name, description, company, department
                    FROM process
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
    
    
    /**
     * Insert a process
     *
     * @param array $params
     * @return int
     */
    public function insert(array $params) : int{
        
        $sql = "INSERT INTO process (name,description,company,department)
                VALUES(:name,:description,:company,:department)";
        
        $name=$params["name"];
        $description=$params["description"];
        $company=$params["company"];
        $department=$params["department"];
        
        
        //Save
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("description", $description, \PDO::PARAM_STR);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        $sth->bindParam("department", $department, \PDO::PARAM_INT);
        
        
        $sth->execute();
        
        return $this->container->db->lastInsertId();
    }
    
    
    /**
     * Upddate a process
     *
     * @param array $params
     * @return int
     */
    public function update(array $params) : int{
        
        $sql = "UPDATE process SET
                    name=:name,
                    description=:description,
                    company=:company
                WHERE id=:id
                LIMIT 1";
        
        $name=$params["name"];
        $description=$params["description"];
        $company=$params["company"];
        
        //Update
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("description", $description, \PDO::PARAM_STR);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        $sth->bindParam("id", $params["id"], \PDO::PARAM_INT);
        
        $sth->execute();
        return $sth->rowCount();
    }
    
    /**
     * Delete a process
     *
     * @param array $ids
     * @return int
     */
    public function delete(array $ids) : int{
        try {
            $values = implode(",", $ids);
            $sql = "DELETE FROM process WHERE id IN($values)";
            $sth = $this->container->db->prepare($sql);
            $sth->execute();
            return $sth->rowCount();
        } catch (\Exception $e) {
            if($e->getCode() == 23000)
                $message = array(  "type"=>"danger",
                    "message"=>"Não é permitido excluir um procedimento se ela estiver cadastrada em um colaborador.");
                
                $this->container->flash->addMessage("msg",json_encode($message));
                
                return 0;
        }
    }
    
}