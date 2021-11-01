<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Userinfo;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Info extends ResourceController
{  use ResponseTrait;
    
    public function index()
    {
        $userinfo = new Userinfo();
        $data =$userinfo->findAll();
        return $this->respond($data);
    }

    public function Byid($id=null)
    {
        $userinfo= new UserInfo();
        $data = $userinfo->where('Id',$id)->first();
        if($data)
        {
            return $this->respond($data);
        }
        else
        {
            $respond=[
                'status'=>400,
                'error'=>true,
                'Message'=> "No Record Found !",
            ];
            return $this->respond($respond);
        }
       
        //var_dump($data,$id);
    }

    public function Insert()
    {
        $userinfo = new UserInfo();
        $data=[
            "Name"=>$this->request->getVar('Name'),
            'Email'=>$this->request->getVar('Email'),
            'Phone'=>$this->request->getVar('Phone'),
            
        ];
        $userinfo->save($data);
        $respond=[
            'status'=>200,
            'error'=>null,
            'Message'=> "Record Save Sucesfully !",
        ];
        return $this->respond($respond);
    }

    public function Edit($id=null)
    {   
        
       
        $userinfo= new Userinfo();
       // $Id=$this->request->getVar('Id');
       // $result = $userinfo->Find($id);
       $data =[];
       $id = $this->request->getVar('Id');
        $attribute=[
            "Id",
            "Name",
            "Email",
            "Phone"
        ];
        foreach($attribute as $key=>$val)
        {
            if(!empty($this->request->getVar($val)))
            {
                $data[$val]=$this->request->getVar($val);
            }
        }
        $userinfo->update($id,$data);
        $respond=[
            'status'=>200,
            'error'=>null,
            'Message'=> "Record Updated Sucesfully !",
        ];
       return $this->respond($respond);
    }

    public function Delete($id=null)
    {
        $userinfo = new Userinfo();
        $result = $userinfo->Find($id);
        if($result)
        {
            $userinfo->delete($result);
            $respond=[
                'status'=>200,
                'error'=>null,
                'Message'=> "Record Updated Sucesfully !",
            ];
        }
        else
        {
            $respond=[
                'status'=>400,
                'error'=>true,
                'Message'=> "No Record Found !",
            ];
        }
        return $this->respond($respond);
    }

}