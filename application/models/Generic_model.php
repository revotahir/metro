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
    public function Delete($table, $where)
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

    function GetProductList($where = false)
    {
        $this->db->select('*');
        $this->db->from('products as p');
        $this->db->join('users  as u', 'p.userID=u.userID', 'inner');
        $this->db->join('productcategory  as pc', 'p.catID=pc.catID', 'inner');
        $this->db->order_by('p.productID', 'DESC');
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
    public function GetUnassignedProducts($customerID) {
        // Write the SQL query
        $sql = "
            SELECT p.*,v.*,pc.* FROM products p 
            LEFT JOIN assignProduct ap ON p.productID = ap.productID AND ap.customerID = 8 
            INNER JOIN productcategory as pc on p.catID=pc.catID 
            INNER JOIN users as v on p.userID=v.userID 
            WHERE ap.productID IS NULL AND p.productStatus=1; 
        ";

        // Execute the query with the customerID parameter
        $query = $this->db->query($sql, array($customerID));

        // Return the result as an array of objects
        return $query->result_array();
    }


  
}