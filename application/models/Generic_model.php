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
    public function GetCount($table, $colum, $where = false)
    {
        $this->db->select('count(' . $colum . ') as result');
        $this->db->from($table);
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
    public function GetUnassignedProducts($customerID)
    {
        $this->db->select('p.*, v.*, pc.*');
        $this->db->from('products p');
        $this->db->join('productcategory pc', 'p.catID = pc.catID', 'inner');
        $this->db->join('users v', 'p.userID = v.userID', 'inner');
        $this->db->join('assignProduct ap', 'p.productID = ap.productID AND ap.customerID = ' . $customerID, 'left');
        $this->db->where('p.productStatus', 1); // Only active products
        $this->db->where('ap.productID IS NULL'); // Exclude products assigned to the specified customer
        $query = $this->db->get();

        return $query->result_array(); // Return results as an array
    }
    public function GetAssignedProducts($customerID)
    {
        $this->db->select('p.*, v.*, pc.*,ap.newPrice');
        $this->db->from('products p');
        $this->db->join('productcategory pc', 'p.catID = pc.catID', 'inner');
        $this->db->join('users v', 'p.userID = v.userID', 'inner');
        $this->db->join('assignProduct ap', 'p.productID = ap.productID', 'inner');
        $this->db->where('ap.customerID', $customerID); // Filter by customerID
        $this->db->where('p.productStatus', 1); // Only active products
        $query = $this->db->get();

        return $query->result_array(); // Return results as an array
    }
    public function GetProductsByCart($where = false)
    {
        $this->db->select('*');
        $this->db->from('cart c');
        $this->db->join('products p', 'p.productID = c.productID', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();

        return $query->result_array(); // Return results as an array
    }
    public function GetOrderListByCusotmer($where = false)
    {
        $this->db->select('*');
        $this->db->from('checkout c');
        $this->db->join('users u', 'c.customerID = u.userID', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();

        return $query->result_array(); // Return results as an array
    }
    public function GetDistVendorInCart($checkoutID)
    {
        $this->db->distinct();
        $this->db->select('vendorID');
        $this->db->from('cart');
        $this->db->where('checkoutID', $checkoutID);
        $query = $this->db->get();
        // die($this->db->last_query());
        return $query->result_array(); // Get results as an array
    }
}
