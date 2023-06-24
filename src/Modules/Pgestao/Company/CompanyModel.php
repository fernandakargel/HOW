<?php
namespace Modules\Pgestao\Company;

use Slim\Container;
use Psr\Container\ContainerInterface;

/**
 * CompanyModel
 *
 * @namespace \Modules\Pgestao\Company
 *
 */
class CompanyModel {
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
     * Select all company
     *
     * @return array
     */
    public function selectAll() : array{
        $sql = "SELECT
                	id,
                    name,
                    trade,
                    MASK(number,'##.###.###/####-##') AS number,
                    DATE_FORMAT(expire,'%d/%m/%Y') AS expire
                FROM company
                ORDER BY expire DESC";
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $this->format($result)
        : array();
    }
    
    /**
     * Select a company by ID
     *
     * @param int $id
     * @return \PDO::FETCH_OBJ
     */
    public function selectByID(int $id) {
        
        $sql = "SELECT id,name,trade,number,expire
                    FROM company
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

    public function selectCompanyInfo($company): array
    {
        $sql = "SELECT
                    count(s.id) as total,
                    c.name as name,
                    c.expire as expire,
                    c.plan as plan
                FROM staff as s
                INNER JOIN company as c ON  s.company=c.id
                WHERE s.company=:company";

        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result : array();
    }
    
    public function format($result) : array {
        return $result;
    }
    
    
    
    /**
     * Insert a company
     *
     * @param array $params
     * @return int
     */
    public function insert(array $params) : int{
        
        $sql = "INSERT INTO company (name,trade,number,expire)
                VALUES(:name,:trade,:number,:expire)";
        
        $name=$params["name"];
        $trade=$params["trade"];
        $number=$params["number"];
        $expire=$params["expire"];
        
        //Save
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("trade", $trade, \PDO::PARAM_STR);
        $sth->bindParam("number", $number, \PDO::PARAM_STR);
        $sth->bindParam("expire", $expire, \PDO::PARAM_STR);
        
        $sth->execute();
        return $sth->rowCount();
    }
    
    
    /**
     * Upddate a company
     *
     * @param array $params
     * @return int
     */
    public function update(array $params) : int{
        
        $sql = "UPDATE company SET
                    name=:name,
                    trade=:trade,
                    number=:number,
                    expire=:expire
                WHERE id=:id
                LIMIT 1";
        
        $id=$params["id"];
        $name=$params["name"];
        $trade=$params["trade"];
        $number=$params["number"];
        $expire=$params["expire"];
        
        //Update
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("trade", $trade, \PDO::PARAM_STR);
        $sth->bindParam("number", $number, \PDO::PARAM_STR);
        $sth->bindParam("expire", $expire, \PDO::PARAM_STR);
        $sth->bindParam("id", $id, \PDO::PARAM_INT);
        
        $sth->execute();
        return $sth->rowCount();
    }
    
    /**
     * Delete a company
     *
     * @param array $ids
     * @return int
     */
    public function delete(array $ids) : int{
        
        $values = implode(",", $ids);
        $sql = "DELETE FROM company WHERE id IN ($values)";
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        return $sth->rowCount();
    }
    
}