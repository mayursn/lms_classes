<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('user/Role_model');
    }

    /**
     * Index action
     */
    function index() {
        $this->data['title'] = 'Role Management';
        $this->data['page'] = 'role';
        $this->data['roles'] = $this->Role_model->order_by_column('role_name');
        $this->__template('user/role/index', $this->data);
    }

    /**
     * Create new role
     */
    function create() {
        if ($_POST) {
             if($this->input->post('module')=='')
             {
                $modules='';
             }
             else
             {
                  $modules= implode(',',$this->input->post('module'));
             }
            $this->Role_model->insert(array(
                'role_name' => $_POST['role_name'],
                'assigned_module'=>$modules,
                'is_active' => $_POST['status']
            ));
            $this->flash_notification('Role is successfully added.');
        }

        redirect(base_url('user/role'));
    }

    /**
     * Delete role
     * @param string $id
     */
    function delete($id = '') {
        if ($id) {
            if($id!='1' || $id!='2' || $id!='3'){
            $this->Role_model->delete($id);
            $this->flash_notification('Role is successfully deleted.');
            }
            else{
            $this->flash_notification('Can not delete this role.');    
            }
        }

        redirect(base_url('user/role'));
    }

    /**
     * Update role
     * @param string $id
     */
    function update($id) {
        if ($_POST) {
            if($this->input->post('module')=='')
             {
                $modules='';
             }
             else
             {
                  $modules= implode(',',$this->input->post('module'));
             }
            $this->Role_model->update($id, array(
                'role_name' => $_POST['role_name'],
                'assigned_module'=>$modules,
                'is_active' => $_POST['status']
            ));
            $this->flash_notification('Role is successfully updated.');
        }

        redirect(base_url('user/role'));
    }

    /**
     * Role permission
     * @param string $id
     */
    function permission($id) {
        $this->load->model('user/Modules_model');
        $this->load->model('user/Module_role_permission_model');
        $this->data['title'] = 'Role Permission';
        $this->data['page'] = 'role';
        $this->data['role_details'] = $this->Role_model->get($id);
        $this->data['user_permission'] = $this->Module_role_permission_model->get_many_by(array(
            'role_id'   => $id
        ));
        if($this->data['role_details']->assigned_module!='')
        {
             $modules=explode(',',$this->data['role_details']->assigned_module);
     
                $query="select * from modules where ";
                foreach($modules as $m)
                {
                    $query .= "is_active='1' AND module_id= ".$m." or ";
                }
                 $query = rtrim($query, ' or');
                 
                 $query .= " ORDER BY module_name ASC";

                 $this->data['modules'] =$this->db->query($query)->result();
        }
        else
        {
            $this->data['modules'] ="";
        }
       // $this->data['modules'] = $this->Modules_model->order_by_column('module_name');
        $this->__template('user/role/permission', $this->data);
    }

    /**
     * Assign the module role permission
     */
    function module_role_permission() {
        $this->load->model('user/Module_role_permission_model');
        $this->load->model('user/Modules_model');
        if ($_POST) {
            $modules = $this->Modules_model->order_by_column('module_name');

            foreach ($modules as $module) {                
                $permission = $this->check_permission($module->module_id);     
                $this->check_and_update_role_permission($_POST['role_id'], $module->module_id, $permission);
            }
            
            $this->flash_notification('Module permission is successully updated.');
        }

        redirect(base_url('user/role/permission/' . $_POST['role_id']));
    }

    /**
     * Check and generate permission
     * @param string $module_id
     * @return string
     */
    function check_permission($module_id) {
        $permission = '';

        //create permission check
        if (isset($_POST['create_' . $module_id])) {
            $permission .= '1';
        } else {
            $permission .= '0';
        }

        //read permission check
        if (isset($_POST['read_' . $module_id])) {
            $permission .= '1';
        } else {
            $permission .= '0';
        }

        //update permission check
        if (isset($_POST['update_' . $module_id])) {
            $permission .= '1';
        } else {
            $permission .= '0';
        }

        //Delete permission check
        if (isset($_POST['delete_' . $module_id])) {
            $permission .= '1';
        } else {
            $permission .= '0';
        }

        return $permission;
    }

    /**
     * Check and update user role permission
     * @param string $role_id
     * @param string $module_id
     * @param string $permission
     */
    function check_and_update_role_permission($role_id, $module_id, $permission) {
        $this->load->model('user/Module_role_permission_model');

        $user_permission = $this->Module_role_permission_model->get_many_by(array(
            'role_id' => $role_id,
            'module_id' => $module_id
        ));

        //update
        if ($user_permission) {
            //update permission
            $where = array(
                'role_id' => $role_id,
                'module_id' => $module_id
            );
            
            $data = array(
                'user_permission' => $permission
            );
            $this->Module_role_permission_model->update_role_permission($data, $where);
        } else {
            //insert
            $this->Module_role_permission_model->insert(array(
                'role_id' => $role_id,
                'module_id' => $module_id,
                'user_permission' => $permission
            ));
        }
    }

}
