<?php

/**
 * Author: Amirul Momenin
 * Desc:Journal_entry Controller
 *
 */
////require_once (APPPATH . 'libraries/PHPExcel.php');
//require_once (APPPATH . 'libraries/PHPExcel/IOFactory.php');

class Journal_entry extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('Customlib');
        $this->load->helper(array(
            'cookie',
            'url'
        ));

        $this->load->library('PHPExcel');
        $this->load->library('excel');

        $this->load->database();
        $this->load->model('Journal_entry_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of journal_entry table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['journal_entry'] = $this->Journal_entry_model->get_limit_journal_entry($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/journal_entry/index');
        $config['total_rows'] = $this->Journal_entry_model->get_count_journal_entry();
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['_view'] = 'admin/journal_entry/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save journal_entry
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $created_at = "";
        $updated_at = "";

        if ($id <= 0) {
            $created_at = date("Y-m-d H:i:s");
        } else if ($id > 0) {
            $updated_at = date("Y-m-d H:i:s");
        }

        $params = array(
            'journal_head' => html_escape($this->input->post('journal_head')),
            'debit' => html_escape($this->input->post('debit')),
            'credit' => html_escape($this->input->post('credit')),
            'created_at' => $created_at,
            'updated_at' => $updated_at
        );

        if ($id > 0) {
            unset($params['created_at']);
        }
        if ($id <= 0) {
            unset($params['updated_at']);
        }
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['journal_entry'] = $this->Journal_entry_model->get_journal_entry($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Journal_entry_model->update_journal_entry($id, $params);
                $this->session->set_flashdata('msg', 'Journal_entry has been updated successfully');
                redirect('admin/journal_entry/index');
            } else {
                $data['_view'] = 'admin/journal_entry/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $journal_entry_id = $this->Journal_entry_model->add_journal_entry($params);
                $this->session->set_flashdata('msg', 'Journal_entry has been saved successfully');
                redirect('admin/journal_entry/index');
            } else {
                $data['journal_entry'] = $this->Journal_entry_model->get_journal_entry(0);
                $data['_view'] = 'admin/journal_entry/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    /**
     * Details journal_entry
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['journal_entry'] = $this->Journal_entry_model->get_journal_entry($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/journal_entry/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting journal_entry
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $journal_entry = $this->Journal_entry_model->get_journal_entry($id);

        // check if the journal_entry exists before trying to delete it
        if (isset($journal_entry['id'])) {
            $this->Journal_entry_model->delete_journal_entry($id);
            $this->session->set_flashdata('msg', 'Journal_entry has been deleted successfully');
            redirect('admin/journal_entry/index');
        } else
            show_error('The journal_entry you are trying to delete does not exist.');
    }

    /**
     * Search journal_entry
     *
     * @param $start -
     *            Starting of journal_entry table's index to get query
     */
    function search($start = 0)
    {
        if (! empty($this->input->post('key'))) {
            $key = $this->input->post('key');
            $_SESSION['key'] = $key;
        } else {
            $key = $_SESSION['key'];
        }

        $limit = 10;
        $this->db->like('id', $key, 'both');
        $this->db->or_like('journal_head', $key, 'both');
        $this->db->or_like('debit', $key, 'both');
        $this->db->or_like('credit', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['journal_entry'] = $this->db->get('journal_entry')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/journal_entry/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('journal_head', $key, 'both');
        $this->db->or_like('debit', $key, 'both');
        $this->db->or_like('credit', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $config['total_rows'] = $this->db->from("journal_entry")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['key'] = $key;
        $data['_view'] = 'admin/journal_entry/index';
        $this->load->view('layouts/admin/body', $data);
    }

    function import()
    {
        $file_picture = "";
        $created_at = date("Y-m-d H:i:s");
        $updated_at = "";
        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for ($row = 2; $row <= $highestRow; $row ++) {
                    $journal_head = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $debit = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $credit = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                    $params = array(
                        'journal_head' => $journal_head,
                        'debit' => $debit,
                        'credit' => $credit,
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    );
                    $this->Journal_entry_model->add_journal_entry($params);
                }
            }
        }
        redirect('admin/journal_entry/index');
    }

    function export()
    {
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array(
            "journal_head",
            "debit",
            "credit"
        );

        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column ++;
        }

        $journal_entry_data = $this->Journal_entry_model->get_all_journal_entry();

        $excel_row = 2;

        foreach ($journal_entry_data as $row) {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['journal_head']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['debit']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['credit']);
            $excel_row ++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="journal_entry.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
    }
}
//End of Journal_entry controller