<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class websiteNews_model extends CI_Model
{

    function newsListing($filter, $page, $segment)
    {
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(news.subject  LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])){
            $this->db->where('news.date', $filter['by_date']);
           }
        $this->db->from('tbl_website_news as news'); 
        $this->db->where('news.is_deleted', 0);
        $this->db->order_by('news.date','DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }
    function newsCountListing($filter)
    {
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(news.subject  LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])){
            $this->db->where('news.date', $filter['by_date']);
           }
        $this->db->from('tbl_website_news as news'); 
        $this->db->where('news.is_deleted', 0);
        $this->db->order_by('news.date','DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    // function to insert news into db
    function addNews($newsInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_website_news', $newsInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getNewsInfo($row_id)
    {
        $this->db->from('tbl_website_news as news');
        $this->db->where('news.row_id', $row_id);
        $this->db->where('news.is_deleted', 0);
        $this->db->where('news.status', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateNews($newsInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_website_news', $newsInfo);
        return TRUE;
    }

    function disableNews($newsAndEventInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_website_news', $newsAndEventInfo);
        return TRUE;
    }
}