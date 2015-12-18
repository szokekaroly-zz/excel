<?php

include_once 'libs/model.php';

/**
 * Description of Excel
 *
 * @author karcsi
 */
class Excel extends Modell {
    private $maxcol;
    private $maxrow;

    public function __construct() {
        parent::__construct();
        $result = $this->query('select * from settings');
        foreach ($result as $row => $value) {
            $this->maxcol = $value['maxcol'];
            $this->maxrow = $value['maxrow'];
        }
    }

    public function save_cell_value($param) {
        $sql = 'select count(*) as cnt from excel where col=? and row=?';
        $params = array(
            $param['col'],
            $param['row']
        );
        $count = $this->query($sql, $params);
        $params[] = $param['value'];
        foreach ($count as $cnt) {
            if ($cnt['cnt'] == 0) {
                $sql = 'insert into excel (col,row,value) values (?,?,?)';
            } else {
                $params = array(
                    $param['value'],
                    $param['col'],
                    $param['row']
                );
                $sql = 'update excel set value = ? where col = ? and row = ?';
            }
        }
        $this->begin();
        $this->insert_update_delete($sql, $params);
        $this->commit();
    }

    function get_all_cells() {
        $sql = 'select * from excel';
        $result = $this->query($sql);
        return $result;
    }
    
    public function get_maxcol() {
        return $this->maxcol;
    }
    
    public function set_maxcol($param) {
        if ($param < 2 || $param > 25) {
            throw new Exception('Index of col is out of bounds:' . $param);
        }
        if ($this->insert_update_delete('update settings set maxcol=?', array($param)) != 1) {
            throw new Exception('Error updating max col!');
        }
        $this->maxcol = $param;
        $this->insert_update_delete('delete from excel where col>?', array($param));
    }

    public function get_maxrow() {
        return $this->maxrow;
    }
    
    public function set_maxrow($param) {
        if ($param < 2) {
            throw new Exception('Index of row is out of bounds:' . $param);
        }
        if ($this->insert_update_delete('update settings set maxrow=?', array($param)) != 1) {
            throw new Exception('Error updating max row!');
        }
        $this->maxrow = $param;
        $this->insert_update_delete('delete from excel where row>?', array($param));
    }
    
}
