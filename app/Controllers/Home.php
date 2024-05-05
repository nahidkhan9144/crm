<?php

namespace App\Controllers;

use App\Models\My_model;
class Home extends BaseController
{
    protected $my_model;
    protected $pagination;
    protected $pager;

    public function __construct() {
        $this->my_model = new My_model();
        $this->pagination = \Config\Services::pager(); 
    }
    public function index():string //first page list viewing
    {
        $limit = 10;
        $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $offset = ($page - 1) * $limit;
        if($this->request->getGet('search_data')!=null){
            $search = $this->request->getGet('search_data');
            $data['items'] = $this->my_model->get_items($limit, $offset,$search);
            $data['total_items'] = $this->my_model->count_items($search);

        }else{
            $data['items'] = $this->my_model->get_items($limit, $offset,$search = '');
            $data['total_items'] = $this->my_model->count_items($search = '');
        }
        $config = [
            'baseURL' => base_url('/'),
            'totalRows' => $data['total_items'],
            'perPage' => $limit,
            'uriSegment' => 3,
        ];
        $pager_links =$this->pagination->makeLinks($page, $limit, $data['total_items']);
    
        $data['pagination_links'] = $pager_links;
        $data1 = view('inc/header');
        $data1 .= view('view_form', ['data' => $data]);
        $data1 .= view('inc/footer');
        return $data1;
    }

    public function addData(): string //add Form
    {
        $name = $this->request->getPost('name');
        $company_name = $this->request->getPost('company_name');
        $desg = $this->request->getPost('desg');
        $email = $this->request->getPost('email');
        $db = \Config\Database::connect();
        $builder = $db->table('details');
        $data = [
            'name' => $name,
            'company_name' => $company_name,
            'designation' => $desg,
            'email' => $email
        ];
        $builder->insert($data);
        $response = array();
        if($builder){
            $response['error']= "0";
            $response['msg']= "Successfully Inserted";
        }else{
            $response['error']= "1";
            $response['msg']= "Failed";
        }
        return json_encode($response);
    }

    public function form(): string //show Form
    {
        $data = view('inc/header');
        $data .= view('add');
        $data .= view('inc/footer');
       return $data;
    }


    public function delete(): string // delete
    {
        $id = $this->request->getPost('id');
        $db = \Config\Database::connect();
        $query = $db->query("DELETE  FROM `details` WHERE id = $id");
      
        if($query){
            $response['error']= "0";
            $response['msg']= "Successfully Deleted";
        }else{
            $response['error']= "1";
            $response['msg']= "Failed";
        }
        return json_encode($response);
    }

    public function bulk(): string // all delete
    {
        $values = $this->request->getPost('values');
        $db = \Config\Database::connect();
        $builder = $db->table('details'); 
        if (!empty($values) && is_array($values)) {
            foreach ($values as $value) {
                if ($value != 0) {
                    $query = $db->query("DELETE  FROM `details` WHERE id = $value");
                }
            }
        }
        if($query){
            $response['error']= "0";
            $response['msg']= "Successfully Deleted";
        }else{
            $response['error']= "1";
            $response['msg']= "Failed";
        }
        return json_encode($response);
    }

    
    public function editG(): string //get data for edit
    {
        $id = $this->request->getGet('id');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM `details` WHERE id = $id");
        $res = $query->getResult();
    
        $data = view('inc/header');
        $data .= view('edit', ['data' => $res[0]]);
        $data .= view('inc/footer');
        return $data;
    }

    public function updateData(): string //updatr data
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $company_name = $this->request->getPost('company_name');
        $desg = $this->request->getPost('desg');
        $email = $this->request->getPost('email');
        $db = \Config\Database::connect();
        $builder = $db->table('details');
        $data = [
            'name' => $name,
            'company_name' => $company_name,
            'designation' => $desg,
            'email' => $email
        ];
        $builder->where('id', $id); 
        $builder->update($data);
        $response = array();
        if($builder){
            $response['error']= "0";
            $response['msg']= "Successfully Inserted";
        }else{
            $response['error']= "1";
            $response['msg']= "Failed";
        }
        return json_encode($response);
    }

}
