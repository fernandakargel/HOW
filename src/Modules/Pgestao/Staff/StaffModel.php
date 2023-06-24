<?php
namespace Modules\Pgestao\Staff;

use Slim\Container;
use Psr\Container\ContainerInterface;

/**
 * StaffModel
 *
 * @namespace Modules\Pgestao\Staff
 *
 */
class StaffModel {
    
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
     * Select all staff
     *
     * @return array
     */
    public function selectAll(): array
    {
        $sql = "SELECT  s.id,
                        s.name,
                    	CASE
                    		WHEN s.gender  = 'F' THEN 'Feminino'
                    		WHEN s.gender  = 'M' THEN 'Masculino'
                    			ELSE 'Não cadastrado'
                    	END AS gender,
                    	s.photo AS photo,
                    	s.shift AS shift,
                        d.name AS department,
                        r.name AS role,
                    	s.registration AS registration,
                        s.notes,
                        CASE
    					   WHEN s.status  = '0' THEN 'Inativo'
    					   WHEN s.status  = '1' THEN 'Ativo'
    					   ELSE 'Não identificado'
    				    END AS status,
                        s.company
                        FROM staff AS s
                            INNER JOIN role AS r ON s.role=r.id
                            INNER JOIN department AS d ON r.department=d.id
                    		ORDER BY s.name";
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        return $sth->rowCount() > 0 ? $result : array();
    }
    
    public function selectByCompany($company): array
    {
        $sql = "SELECT
    				s.id AS id,
    				s.name AS name,
    				CASE
    					WHEN s.gender  = 'F' THEN 'Feminino'
    					WHEN s.gender  = 'M' THEN 'Masculino'
    						ELSE 'Não identificado'
    				END AS gender,
    				s.photo AS photo,
                    s.shift AS shift,
                    s.registration AS registration,
                    CASE
    					WHEN s.status  = '0' THEN 'Inativo'
    					WHEN s.status  = '1' THEN 'Ativo'
    						ELSE 'Não cadastrado'
    				END AS status
    			FROM staff as s
                WHERE s.company=:company
                ORDER BY s.name";
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result : array();
    }

    
    public function selectByDepartment($department): array
    {
        $sql = "SELECT
                		s.id AS id,
                		s.name AS name,
                		CASE
                			WHEN s.gender  = 'F' THEN 'Feminino'
                			WHEN s.gender  = 'M' THEN 'Masculino'
                				ELSE 'Não identificado'
                		END AS gender,
                		s.photo AS photo,
                		s.shift AS shift,
                		s.registration AS registration,
                		CASE
                			WHEN s.status  = '0' THEN 'Inativo'
                			WHEN s.status  = '1' THEN 'Ativo'
                				ELSE 'Não cadastrado'
                		END AS status
                	FROM staff as s
                	INNER JOIN role AS r ON s.role=r.id
                	WHERE r.department=:department
                       AND status=1   
                	ORDER BY s.name";
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("department", $department, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result : array();
    }
    
    
    public function selectStaffKnowProcess(int $staff) : array
    {
        $sql = "SELECT  id, 
                        date,
                        level, 
                        coach,
                        commentary, 
                        inserted_by_manager, 
                        process, 
                        staff
                FROM staff_know_process
                WHERE staff=:staff";
        
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("staff", $staff, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result : array();
    }
    
    /**
     * Select a staff by ID
     *
     * @param int $id
     * @return \PDO::FETCH_OBJ
     */
    public function selectByID($id)
    {
        $sql = "SELECT  s.id,
                        s.name,
                    	s.gender,
                    	s.photo AS photo,
                    	s.shift AS shift,
                    	s.registration AS registration,
                        s.notes,
                        s.status,
                        s.role,
                        d.id AS department
                        FROM staff AS s
                            INNER JOIN role AS r ON s.role=r.id
                            INNER JOIN department AS d ON r.department=d.id
                    	WHERE s.id=:id
                        LIMIT 1;";
        $sth = $this->container->db->prepare($sql);
        
        $sth->bindParam("id", $id, \PDO::PARAM_INT);
        
        $sth->execute();
        
        if ($sth->rowCount() > 0) {
            $result = $sth->fetch(\PDO::FETCH_OBJ);
        }
        
        return $result ?? array();
    }
    
    public function selectSkills($id)
    {
        $sql = " SELECT  ss.skill AS id,
                        ss.staff AS staff,
                        s.name AS name,
                        s.description,
                        ss.level AS level,
                        ss.coach AS coach,
                         DATE_FORMAT(ss.date,'%d/%m/%Y') AS date
                    FROM staff_has_skill AS ss
                    INNER JOIN skill AS s ON ss.skill = s.id
                    WHERE staff=:staff";
        
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("staff", $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll();
        
        return $sth->rowCount() > 0 ? $result : array();
    }
    
    /**
     * Insert a staff
     *
     * @param array $params
     * @return int
     */
    public function insert(array $params): int
    {
        $sql = "INSERT INTO staff (name, gender, photo,registration,shift,notes,status,company,role)
                    VALUES(:name,:gender,:photo,:registration,:shift,:notes,1,:company,:role)";
        
        $name = $params["name"];
        $gender = $params["gender"];
        $photo = $params["photo"];
        $registration = $params["registration"];
        $shift = $params["shift"];
        $notes = $params["notes"];
        $company = $params["company"];
        $role = $params["role"];
        
        // Save
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("gender", $gender, \PDO::PARAM_STR);
        $sth->bindParam("photo", $photo, \PDO::PARAM_STR);
        $sth->bindParam("registration", $registration, \PDO::PARAM_INT);
        $sth->bindParam("shift", $shift, \PDO::PARAM_STR);
        $sth->bindParam("notes", $notes, \PDO::PARAM_STR);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        $sth->bindParam("role", $role, \PDO::PARAM_INT);
        
        $sth->execute();
        return $this->container->db->lastInsertId();
    }
    
    public function insertSkill(array $params): int
    {
        try {
            $sql = "INSERT INTO staff_know_process (date, level, coach, commentary, inserted_by_manager, process, staff) 
                           VALUES (:date, :level, :coach, :commentary, :inserted_by_manager, :process, :staff);";
            
            $staff = $params["staff"];
            $process = $params["process"];
            $level = $params["level"];
            $coach = $params["coach"];
            $date = $params["date"];
            $commentary = $params["commentary"];
            $inserted_by_manager = $params["inserted_by_manager"];
            
            
            
            // Save
            $sth = $this->container->db->prepare($sql);
            $sth->bindParam("staff", $staff, \PDO::PARAM_INT);
            $sth->bindParam("process", $process, \PDO::PARAM_INT);
            $sth->bindParam("level", $level, \PDO::PARAM_INT);
            $sth->bindParam("coach", $coach, \PDO::PARAM_STR);
            $sth->bindParam("date", $date, \PDO::PARAM_STR);
            $sth->bindParam("commentary", $commentary, \PDO::PARAM_STR);
            $sth->bindParam("inserted_by_manager", $inserted_by_manager, \PDO::PARAM_INT);
            
            $sth->execute();

           
            return $sth->rowCount();
        } catch (\Exception $e) {
            if ($e->getCode() == 23000)
                $message = array(
                    "type" => "danger",
                    "message" => "Não é permitido cadastrar uma habilidade duas vezes."
                );
                
                $this->container->flash->addMessage("msg", json_encode($message));
                
                return 0;
        }
    }
    
    
    public function hasSkill(int $staff,int $process) : bool{
        
        $sql = "SELECT id FROM staff_know_process WHERE process=:process AND staff=:staff";
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("process", $process, \PDO::PARAM_INT);
        $sth->bindParam("staff", $staff, \PDO::PARAM_INT);  
        $sth->execute();
        
        if ($sth->rowCount() > 0) {
            $result = TRUE;
        }
        
        return $result ?? FALSE;
    }
    
    /**
     * Upddate a staff
     *
     * @param array $params
     * @return int
     */
    public function update(array $params): int
    {
        $sql = "UPDATE staff SET
                    name=:name,
                    gender=:gender,
                    photo=:photo,
                    shift=:shift,
                    notes=:notes,
                    registration=:registration,
                    company=:company
                WHERE id=:id
                LIMIT 1";
        
        $name = $params["name"];
        $gender = $params["gender"];
        $photo = $params["photo"];
        $notes = $params["notes"];
        $shift = $params["shift"];
        $registration = $params["registration"];
        $company = $params["company"];
        $id = $params["id"];
        
        // Update
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("name", $name, \PDO::PARAM_STR);
        $sth->bindParam("gender", $gender, \PDO::PARAM_STR);
        $sth->bindParam("photo", $photo, \PDO::PARAM_STR);
        $sth->bindParam("shift", $shift, \PDO::PARAM_INT);
        $sth->bindParam("registration", $registration, \PDO::PARAM_STR);
        $sth->bindParam("notes", $notes, \PDO::PARAM_STR);
        $sth->bindParam("company", $company, \PDO::PARAM_INT);
        $sth->bindParam("id", $id, \PDO::PARAM_INT);
        
        $sth->execute();
        return $sth->rowCount();
    }
    
    /**
     * Upddate status in a staff
     *
     * @param array $params
     * @return int
     */
    public function updateStatus(array $params)
    {
        
        $sql = "UPDATE staff SET
                    status=:status
                WHERE id=:id
                LIMIT 1";
        
        $id = $params["id"];
        $status = $params["status"];
        
        
        // Update
        $sth = $this->container->db->prepare($sql);
        $sth->bindParam("status", $status, \PDO::PARAM_INT);
        $sth->bindParam("id", $id, \PDO::PARAM_INT);
        $sth->execute();
        
        return $sth->rowCount();
    }
    
    
    public function updateSkill(array $params) {
        try {
            $sql = "UPDATE staff_know_process SET   
                        date=:date, 
                        level=:level, 
                        coach=:coach, 
                        commentary=:commentary 
                    WHERE 
                        process=:process AND 
                        staff=:staff
                    LIMIT 1";
            
            $staff = $params["staff"];
            $process = $params["process"];
            $level = $params["level"];
            $coach = $params["coach"];
            $date = $params["date"];
            $commentary = $params["commentary"];

            
            // Save
            $sth = $this->container->db->prepare($sql);
            $sth->bindParam("staff", $staff, \PDO::PARAM_INT);
            $sth->bindParam("process", $process, \PDO::PARAM_INT);
            $sth->bindParam("level", $level, \PDO::PARAM_INT);
            $sth->bindParam("coach", $coach, \PDO::PARAM_STR);
            $sth->bindParam("date", $date, \PDO::PARAM_STR);
            $sth->bindParam("commentary", $commentary, \PDO::PARAM_STR);
            
            $sth->execute();
            
            
            
            return $sth->rowCount();
        } catch (\Exception $e) {
            \var_dump($this->container->db->errorInfo()); die;
            
            if ($e->getCode() == 23000)
                $message = array(
                    "type" => "danger",
                    "message" => "Não é permitido cadastrar uma habilidade duas vezes."
                );
                
                $this->container->flash->addMessage("msg", json_encode($message));
                
                return 0;
        }
    }
    /**
     * Delete a staff
     *
     * @param array $ids
     * @return int
     */
    public function delete(array $ids): int
    {
        $values = implode(",", $ids);
        $sql = "DELETE FROM staff WHERE id IN($values)";
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        return $sth->rowCount();
    }
    
    public function deleteSkills($staff)
    {
        $values = implode(",", $staff);
        $sql = "DELETE FROM staff_know_process WHERE staff IN($values)";
        $sth = $this->container->db->prepare($sql);
        $sth->execute();
        return $sth->rowCount();
    }
    
}