<?php if (!defined('BASEPATH')) exit('No direct script allowed');

class Action_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_single($tabel, $array = [],$order = NULL)
    {

        if (count($array) > 0) {

            $this->db->select()->from($tabel)->where($array);
            if ($order != NULL) {
                $this->db->order_by($order['order_by'], $order['ascdesc']);
            }

            $query = $this->db->get();

            return $query->row();
        } else {

            $this->db->select()->from($tabel)->order_by($this->_order_by);

            $query = $this->db->get();

            return $query->result();
        }
    }

    public function sum($tabel, $sum = NULL, $array = [])
    {

        $select = '';
        if ($sum == NULL) {
            return FALSE;
        }
        if (isset($sum['kolom'])) {
            $select .= 'SUM(' . $sum['kolom'] . ')';
            if (!isset($sum['as'])) {
                $select .= ' AS ' . $sum['as'];
            }
        } else {
            return FALSE;
        }

        $this->db->select($select);
        $this->db->from($tabel);
        if (count($array) > 0) {
            foreach ($array as $field => $value) {
                if (is_array($value)) {
                    $this->db->where_in($field, $value);
                } else {
                    $this->db->where($field, $value);
                }
            }
        }
        $result = $this->db->get();
        if ($result == false) {
            return 0;
        } else {
            return $result;
        }
    }

    public function cnt_where_params($tabel, $where = null, $select = "*", $params = array(), $or_where = null)
    {


        if ($where != NULL) {
            foreach ($where as $field => $value) {
                if (is_array($value)) {
                    $this->db->where_in($field, $value);
                } else {
                    $this->db->where($field, $value);
                }
            }
        }



        if (isset($params['between'])) {

            if ($params['between']['start'] != $params['between']['end']) {

                $awal = $params['between']['start'];

                $akhir = $params['between']['end'];

                if ($awal < $akhir) {

                    $this->db->where($params['between']['columnname'] . " BETWEEN '" . $awal . "' AND '" . $akhir . "'");
                } else if ($awal > $akhir) {

                    $a = $akhir;

                    $akhir = $awal;

                    $awal = $a;

                    $this->db->where($params['between']['columnname'] . " BETWEEN '" . $awal . "' AND '" . $akhir . "'");
                }
            } else if ($params['between']['start'] == $params['between']['end']) {

                $this->db->where($params['between']['columnname'], $params['between']['start']);
            }
        }



        if (isset($params['search']) && !empty($params['search'])) {

            if (count($params['columnsearch']) > 0) {

                $this->db->group_start();

                $i = 1;

                foreach ($params['columnsearch'] as $columnname) {

                    if ($i == 1) {

                        $this->db->like($columnname, $params['search']);
                    } else {

                        $this->db->or_like($columnname, $params['search']);
                    }

                    $i++;
                }

                $this->db->group_end();
            }
        }

        if (isset($params['where_in'])) {
            $this->db->where_in($params['where_in']['kolom'], $params['where_in']['value']);
        }
        if (isset($params['not_where_in'])) {
            $this->db->where_not_in($params['not_where_in']['kolom'], $params['not_where_in']['value']);
        }

        if (isset($params['arrjoin'])) {



            foreach ($params['arrjoin'] as $table => $statement) {

                $type = (isset($statement['type']) && $statement['type'] != '') ? $statement['type'] : 'INNER';



                $this->db->join($table, $statement['statement'], $type);
            }
        }





        if (isset($params['groupby'])) {

            $this->db->group_by($params['groupby']);
        }



        if (isset($params['arrorderby'])) {

            $this->db->order_by($params['arrorderby']['kolom'], $params['arrorderby']['order']);
        }

        if (isset($params['sort']) && isset($params['order'])) {

            if ($params['sort'] != '') {

                if ($params['order'] == '') {

                    $order = 'asc';
                } else {

                    $order = $params['order'];
                }

                $this->db->order_by($params['sort'], $order);
            }
        }
        if ($or_where != NULL) {
            foreach ($or_where as $field => $value) {
                $this->db->or_where($field, $value);
            }
        }



        if (isset($params['limit'])) {

            if (isset($params['offset'])) {

                $this->db->limit($params['limit'], $params['offset']);
            } else {

                $this->db->limit($params['limit']);
            }
        }




        // $this->db->order_by($this->_primary_key,$this->_ascdesc);

        $this->db->select($select);



        $this->db->from($tabel);

        $q = $this->db->get();

        if ($q->num_rows() > 0) {

            return $q->num_rows();
        } else {

            return false;
        }
    }
    public function get($tabel, $array = [], $order = [], $limit = 0, $start = 0)
    {

        if (count($array) > 0) {

            if ($limit > 0) {

                if ($start > 0) {

                    $this->db->limit($limit, $start);
                } else {

                    $this->db->limit($limit);
                }
            }

            $this->db->from($tabel);
            foreach ($array as $field => $value) {
                if (is_array($value)) {
                    $this->db->where_in($field, $value);
                } else {
                    $this->db->where($field, $value);
                }
            }
            if (count($order) > 0) {
                $this->db->order_by($order['order_by'], $order['ascdesc']);
            }
            

            $query = $this->db->get();

            return $query->result();
        } else {

            if ($limit > 0) {

                if ($start > 0) {

                    $this->db->limit($limit, $start);
                } else {

                    $this->db->limit($limit);
                }
            }

            $this->db->from($tabel)->order_by($order['order_by'], $order['ascdesc']);

            $query = $this->db->get();

            return $query->result();
        }
    }

    public function get_all($tabel, $array = [], $order = [])
    {
        $this->db->from($tabel);
        if (count($array) > 0) {
            foreach ($array as $field => $value) {
                if (is_array($value)) {
                    $this->db->where_in($field, $value);
                } else {
                    $this->db->where($field, $value);
                }
            }
        }
        if (count($order) > 0) {
            $this->db->order_by($order['order_by'], $order['ascdesc']);
        }
        $query = $this->db->get();

        return $query->result();
    }
    public function cnt_get_all($tabel, $array = [], $order = [])
    {
        $this->db->from($tabel);
        if (count($array) > 0) {
            foreach ($array as $field => $value) {
                if (is_array($value)) {
                    $this->db->where_in($field, $value);
                } else {
                    $this->db->where($field, $value);
                }
            }
        }
        if (count($order) > 0) {
            $this->db->order_by($order['order_by'], $order['ascdesc']);
        }
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function insert($tabel, $array = [])
    {


        if (count($array) > 0) {
             $this->db->insert($tabel, $array);
        }
       

        $id = $this->db->insert_id();

        return $id;
    }

    public function insert_batch($tabel, $array =[])
    {


        $res = $this->db->insert_batch($tabel, $array);
        return $res;
    }
    public function update($tabel, $data = [], $where = array())
    {


        $this->db->set($data);

        $this->db->where($where);

        return $this->db->update($tabel);
    }

    public function update_batch($tabel, $data = [], $primary = '')
    {

        return $this->db->update_batch($tabel, $data, $primary);
    }

    public function delete($tabel, $where = [], $not_where = [])
    {
        if (count($where) > 0) {
            foreach ($where as $field => $value) {
                if (is_array($value)) {
                    $this->db->where_in($field, $value);
                } else {
                    $this->db->where($field, $value);
                }
            }
        }
        // var_dump($where);die;

        if (count($not_where) > 0) {
            foreach ($not_where as $field => $value) {
                if (is_array($value)) {
                    $this->db->where_not_in($field, $value);
                } else {
                    $this->db->where($field, $value);
                }
            }
        }

        return $this->db->delete($tabel);
    }
    public function delete_batch($tabel, $where = null)
    {


        if ($where != null) {
            foreach ($where as $field => $value) {
                if (is_array($value)) {
                    $this->db->where_in($field, $value);
                } else {
                    $this->db->where($field, $value);
                }
            }
            return $this->db->delete($tabel);
        } else {
            return NULL;
        }
    }

    public function get_where_params($tabel, $where = null, $select = "*", $params = array(), $or_where = null)
    {


        if ($where != NULL) {
            foreach ($where as $field => $value) {
                if (is_array($value)) {
                    $this->db->where_in($field, $value);
                } else {
                    $this->db->where($field, $value);
                }
            }
        }



        if (isset($params['between'])) {

            if ($params['between']['start'] != $params['between']['end']) {

                $awal = $params['between']['start'];

                $akhir = $params['between']['end'];

                if ($awal < $akhir) {

                    $this->db->where($params['between']['columnname'] . " BETWEEN '" . $awal . "' AND '" . $akhir . "'");
                } else if ($awal > $akhir) {

                    $a = $akhir;

                    $akhir = $awal;

                    $awal = $a;

                    $this->db->where($params['between']['columnname'] . " BETWEEN '" . $awal . "' AND '" . $akhir . "'");
                }
            } else if ($params['between']['start'] == $params['between']['end']) {

                $this->db->where($params['between']['columnname'], $params['between']['start']);
            }
        }



        if (isset($params['search']) && !empty($params['search'])) {

            if (count($params['columnsearch']) > 0) {

                $this->db->group_start();

                $i = 1;

                foreach ($params['columnsearch'] as $columnname) {

                    if ($i == 1) {

                        $this->db->like($columnname, $params['search']);
                    } else {

                        $this->db->or_like($columnname, $params['search']);
                    }

                    $i++;
                }

                $this->db->group_end();
            }
        }

        if (isset($params['where_in'])) {
            $this->db->where_in($params['where_in']['kolom'], $params['where_in']['value']);
        }
        if (isset($params['not_where_in'])) {
            $this->db->where_not_in($params['not_where_in']['kolom'], $params['not_where_in']['value']);
        }

        if (isset($params['arrjoin'])) {



            foreach ($params['arrjoin'] as $table => $statement) {

                $type = (isset($statement['type']) && $statement['type'] != '') ? $statement['type'] : 'INNER';



                $this->db->join($table, $statement['statement'], $type);
            }
        }





        if (isset($params['groupby'])) {

            $this->db->group_by($params['groupby']);
        }



        if (isset($params['arrorderby'])) {
            $order = 'DESC';
            if (isset($params['arrorderby']['order'])) {
                $order = $params['arrorderby']['order'];
            }
            $this->db->order_by($params['arrorderby']['kolom'], $order);
        }

        if (isset($params['sort']) && isset($params['order'])) {

            if ($params['sort'] != '') {

                if ($params['order'] == '') {

                    $order = 'asc';
                } else {

                    $order = $params['order'];
                }

                $this->db->order_by($params['sort'], $order);
            }
        }
        if ($or_where != NULL) {
            foreach ($or_where as $field => $value) {
                $this->db->or_where($field, $value);
            }
        }



        if (isset($params['limit'])) {

            if (isset($params['offset'])) {

                $this->db->limit($params['limit'], $params['offset']);
            } else {

                $this->db->limit($params['limit']);
            }
        }




        // $this->db->order_by($this->_primary_key,$this->_ascdesc);

        $this->db->select($select);



        $this->db->from($tabel);

        $q = $this->db->get();

        if ($q->num_rows() > 0) {

            return $q->result();
        } else {

            return false;
        }
    }



    public function get_query($tabel, $query = '')
    {


        $result = $this->db->query($query)->result();

        return ($result) ? $result : NULL;
    }
}
