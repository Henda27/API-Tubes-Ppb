<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */

class Pasien extends REST_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pasien_model', 'pasien');
    }

    public function index_get(){
        $id = $this->get('id');

        if($id === null){
            $data = $this->pasien->getData();
        }else{
            $data = $this->pasien->getData($id);
        }

        if($data){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Not Found Data'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post(){
        // nik, nama, jk, usia, alamat, diagnosa
        $data = [
            'nik' => $this->post('nik'),
            'nama' => $this->post('nama'),
            'jk' => $this->post('jk'),
            'usia' => $this->post('usia'),
            'alamat' => $this->post('alamat'),
            'diagnosa' => $this->post('diagnosa')
        ];

        if($this->pasien->sendData($data) > 0){
            $this->response(['status' => true, 'message' => 'data has been created'], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => true, 'message' => 'Failed create Data'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function index_put(){

        $id = $this->put('id');
        $data = [
            'id' => $this->put('id'),
            'nik' => $this->put('nik'),
            'nama' => $this->put('nama'),
            'jk' => $this->put('jk'),
            'usia' => $this->put('usia'),
            'alamat' => $this->put('alamat'),
            'diagnosa' => $this->put('diagnosa')
        ];

        if ($this->pasien->updateData($data, $id) > 0){
            $this->response([
                'status' => true,
                'message' => 'Data has been updated'
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => true,
                'message' => 'Failed update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_delete() {
        $id = $this->delete('id');

        $del = $this->pasien->deleteData($id);
        

        if($del){
            $this->response($del, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Not Found Data'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        // if($id === null){
        //     $this->response(['status' => false, 'message' => 'id not found'], REST_Controller::HTTP_BAD_REQUEST);
        // }else{
        //     if($this->pasien->deleteData($id) > 0){
        //         $this->response(['status' => true, 'id' => $id, 'message' => 'sucess delete'], REST_Controller::HTTP_OK);
        //     }else{
        //         $this->response(['status' => false, 'message' => 'id not found'], REST_Controller::HTTP_BAD_REQUEST);
        //     }
        // }
    }
}