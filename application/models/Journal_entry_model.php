<?php

/**
 * Author: Amirul Momenin
 * Desc:Journal_entry Model
 */
class Journal_entry_model extends CI_Model
{

    protected $journal_entry = 'journal_entry';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get journal_entry by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_journal_entry($id)
    {
        $result = $this->db->get_where('journal_entry', array(
            'id' => $id
        ))->row_array();
        if (! (array) $result) {
            $fields = $this->db->list_fields('journal_entry');
            foreach ($fields as $field) {
                $result[$field] = '';
            }
        }
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get all journal_entry
     */
    function get_all_journal_entry()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('journal_entry')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit journal_entry
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_journal_entry($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('journal_entry')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count journal_entry rows
     */
    function get_count_journal_entry()
    {
        $result = $this->db->from("journal_entry")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get all users-journal_entry
     */
    function get_all_users_journal_entry()
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('journal_entry')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit users-journal_entry
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_users_journal_entry($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('journal_entry')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count users-journal_entry rows
     */
    function get_count_users_journal_entry()
    {
        $this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->from("journal_entry")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new journal_entry
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_journal_entry($params)
    {
        $this->db->insert('journal_entry', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update journal_entry
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_journal_entry($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('journal_entry', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete journal_entry
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_journal_entry($id)
    {
        $status = $this->db->delete('journal_entry', array(
            'id' => $id
        ));
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }
}
