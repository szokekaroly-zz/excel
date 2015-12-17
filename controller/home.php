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
            'max_cols' => $excel->get_maxcol(),
            'max_rows' => $excel->get_maxrow()
        );
        $view->load_view('home', $data);
    }
    
    public function get_all_cells() {
        try {
            $excel = new Excel();
            $cells = $excel->get_all_cells();
            $result = array(
                'status' => 'OK',
                'cells' => $cells
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
    
    public function add_col() {
        try {
            $excel = new Excel();
            $excel->set_maxcol($excel->get_maxcol() + 1);
            $result = array(
                'status' => 'OK'
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

    public function del_col() {
        try {
            $excel = new Excel();
            $excel->set_maxcol($excel->get_maxcol() - 1);
            $result = array(
                'status' => 'OK'
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
    
    public function add_row() {
        try {
            $excel = new Excel();
            $excel->set_maxrow($excel->get_maxrow() + 1);
            $result = array(
                'status' => 'OK'
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

    public function del_row() {
        try {
            $excel = new Excel();
            $excel->set_maxrow($excel->get_maxrow() - 1);
            $result = array(
                'status' => 'OK'
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
