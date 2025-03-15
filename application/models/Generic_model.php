<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Generic_model extends CI_Model
{


    public function GetData($table, $where = false, $sort_colume = false, $sort_type = false, $limit = false, $start = false, $like = false)
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($where) {
            $this->db->where($where);
        }
        if ($sort_colume && $sort_type) {
            $this->db->order_by($sort_colume, $sort_type);
        }
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        // if($like){
        //     $this->db->like($like);
        // }
        if ($like) {
            $this->db->group_start();
            foreach ($like as $column => $keyword) {
                if (!empty($keyword)) {
                    $this->db->or_like($column, $keyword);
                }
            }
            $this->db->group_end();
        }

        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }


    function InsertData($table, $data)
    {
        $this->db->insert($table, $data);
    }
    function Update($table, $where, $set)
    {
        $this->db->where($where);
        $this->db->update($table, $set);
    }
    public function Delet($table, $where)
    {
        $this->db->delete($table, $where);
    }

    public function GetMaxID($table, $colum)
    {
        $this->db->select('max(' . $colum . ') as result');
        $this->db->from($table);
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    function LoginData($email, $pass)
    {
        $this->db->select('*');
        $this->db->from('wp_users');
        $this->db->where('user_email', $email);
        $this->db->where('user_pass', $pass);
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }

    function getPructsList($where = false)
    {
        $this->db->select('*');
        $this->db->from('ipr_product_detail as pd');
        $this->db->join('ipr_order_detail  as od ', 'pd.orderID=od.orderID', 'inner');
        $this->db->order_by('pd.productID', 'DESC');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }


  
}