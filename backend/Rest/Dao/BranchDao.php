<?php
    require_once 'BaseDao.php';

    class BranchDao extends BaseDao {
        public function __construct() {
            parent::__construct("branch", "branch_id");
        }

        public function getByName($name) {
            $stmt = $this->connection->prepare("SELECT * FROM branch WHERE name = :name");
            $stmt->bindParam(":name", $name);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getByLocation($location) {
            $stmt = $this->connection->prepare("SELECT * FROM branch WHERE location = :location");
            $stmt->bindParam(":location", $location);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>
