<?php
include_once 'model/excel.php';
defined('SERVER_ROOT') OR exit('No direct script access allowed');

/**
 * Description of home
 *
 * @author karcsi
 */
class Home extends Controller {
    
    public function __contruct() {
        parent::__construct();
    }
    
    public function index() {
        $view = new View_loader();
        $excel = new Excel();
        $data = array(
            'max_cols' => 15,
            'max_rows' => 15
        );
        $view->load_view('home', $data);
    }
    
    public function get_all_cells() {
        $excel = new Excel();
        $cells = $excel->get_all_cells();
        echo json_encode($cells);
    }
    
    public function savecell() {
        try {
            $excel = new Excel();
            $col = filter_input(INPUT_POST, 'col', FILTER_SANITIZE_NUMBER_INT);
            $row = filter_input(INPUT_POST, 'row', FILTER_SANITIZE_NUMBER_INT);
            $value = filter_input(INPUT_POST, 'value', FILTER_SANITIZE_STRING);
            $param = array(
                'col' => $col,
                'row' => $row,
                'value' =>$value
            );
            $excel->save_cell_value($param);
            $result = array(
                'status' => 'OK',
                'msg' => $value,
            );
            echo json_encode($result);
        } catch (Exception $ex) {
            $result = array(
                'status' => 'ERROR',
                'msg' => $ex->getMessage()
            );
            echo json_encode($result);
        }
    }
}
