<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Contact_Permisson;
use App\Models\Staff_Permission;
use Illuminate\Http\Request;

class PremissionController extends Controller
{
    public function StaffPermission()
    {

        $staff = Staff_Permission::where('staff_id',request()->user()['staffid'])->get();
        return response(
            array(
                'success'=>true,
                'data'=>$staff,
                ),200);

    }


public function get_contact_permissions($permission_id)
{
        
    switch($permission_id)
    {

        case 1:
        $data =  [
                'id'         => 1,
                'name' => 'invoices',
            ];
        return $data;
        break;
        
        case 2:
            $data =  [
                'id'         => 2,
                'name' => 'estimates',
            ];
        return $data;
        break;

        case 3:
            $data =  [
                'id'         => 3,
                'name' => 'contracts',
            ];
        return $data;
        break;

        case 4:
            $data =  [
                'id'         => 4,
                'name' => 'proposals',
            ];
        return $data;
        break;

        case 5:
            $data =  [
                'id'         => 5,
                'name' => 'support',
            ];
        return $data;
        break;

        case 6:
            $data =  [
                'id'         => 6,
                'name'       => 'projects',
            ];
        return $data;
        break;
    }
}


 public function Contact_Permisson()
    {
    $contact = Contact_Permisson::where('userid',request()->user()['id'])->get();
    $data = array();

    foreach($contact as $contacts)
    {
        $item['id'] = $contacts->id;
        $item['capability'] = $this->get_contact_permissions($contacts->permission_id);
        $item['userid'] = $contacts->userid;
        $data[] = $item;
    }
    
    return response(
        array(
            'success'=>true,
            'data'=>$data,
            ),200);
    }


    


}
