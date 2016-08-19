<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Module_role_permission_model extends MY_Model {

    protected $primary_key = 'module_role_permission_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    public $belongs_to = array('role');

    /**
     * Set the timestamp fields
     * @param array $module_role_permission
     * @return array
     */
    protected function timestamps($module_role_permission) {
        $module_role_permission['created_at'] = $module_role_permission['updated_at'] = date('Y-m-d H:i:s');

        return $module_role_permission;
    }

    /**
     * Set update timestamp field
     * @param array $module_role_permission
     * @return array
     */
    protected function update_timestamps($module_role_permission) {
        $module_role_permission['updated_at'] = date('Y-m-d H:i:s');

        return $module_role_permission;
    }

    /**
     * Update role permission
     * @param array $data
     * @param array $where
     */
    function update_role_permission($data, $where) {
        $this->db->where($where);
        $this->db->update('module_role_permission', $data);
    }
    
    function role_permission_with_module($role_id) {
        return $this->db->select()
                ->from($this->_table)
                ->join("modules", "modules.module_id = $this->_table.module_id")
                ->where([
                    "$this->_table.role_id" => $role_id
                ])->get()->result();
    }
    
    function get_role_modules($id)
    {
        $this->db->where('m.role_id',$id);
        $this->db->order_by('role_name','asc');        
        $this->db->join('role r','r.role_id=m.role_id');
       return $this->db->get('module_role_permission m')->result();
    }

}
