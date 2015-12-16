<?php

defined('SERVER_ROOT') OR exit('No direct script access allowed');

/**
 * Description of modell
 *
 * @author karcsi
 */
class Modell {
    
    private $db;
    
    public function __construct() {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USERNAME, DB_PASSWORD,
                array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    
    public function query($select, $params) {
        if ($params) {
            $stmt = $this->db->prepare($select);
            $stmt->execute($params);
        } else {
            $stmt = $this->db ->query($select);
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function query_stmt($select, $params) {
        if ($params) {
            $stmt = $this->db->prepare($select);
            $stmt->execute($params);
        } else {
            $stmt = $this->db->query($select);
        }
        return $stmt;
    }

    public function insert_update_delete($insert, $params) {
        $stmt = $this->db->prepare($insert);
        $stmt->execute($params);
        $affected_rows = $stmt->rowCount();
        return $affected_rows;
    }
    
    public function get_last_insert_id() {
        return $this->db->lastInsertId();
    }

    public function begin() {
        if (!$this->db->inTransaction()) {
            $this->db->beginTransaction();
        }
    }
    
    public function commit() {
        if ($this->db->inTransaction()) {
            $this->db->commit();
        }
    }
    
    public function rollback() {
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }
    }
    
}
