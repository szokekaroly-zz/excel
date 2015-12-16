<?php

include_once 'libs/model.php';

/**
 * Description of Excel
 *
 * @author karcsi
 */
class Excel extends Modell {

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
}
