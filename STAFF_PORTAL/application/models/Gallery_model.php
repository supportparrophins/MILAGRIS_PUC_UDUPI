<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class gallery_model extends CI_Model
{

    function galleryListing($filter, $page, $segment)
    {
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(news.subject  LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(news.date  LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['event_name'])) {
            $this->db->where('news.event_name', $filter['event_name']);
        }
        $this->db->from('tbl_gallery_info as news'); 
        $this->db->where('news.is_deleted', 0);
        $this->db->order_by('news.date','DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }
    function galleryCountListing($filter)
    {
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(news.subject  LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(news.date  LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['event_name'])) {
            $this->db->where('news.event_name', $filter['event_name']);
        }
        $this->db->from('tbl_gallery_info as news'); 
        $this->db->where('news.is_deleted', 0);
        $this->db->order_by('news.date','DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function addNewPhotoGalleryInfo($newsInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_gallery_info', $newsInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function addPhoto($photoData)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_photo_gallery', $photoData);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    
    public function getPhotoGalleryInfoById($row_id)
    {
        $this->db->from('tbl_gallery_info as gallery');
        $this->db->where('gallery.row_id', $row_id);
        $this->db->where('gallery.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getPhotoGalleryListById($row_id)
    {
        $this->db->from('tbl_photo_gallery as gallery');
        $this->db->where('gallery.photo_id', $row_id);
        $this->db->where('gallery.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function updatePhotoGallery( $row_id,$newsInfo)
    {
        $this->db->where_in('row_id', $row_id);
        $this->db->update('tbl_gallery_info', $newsInfo);
        return TRUE;
    }

    function updatePhotoGalleryList( $row_id,$newsInfo)
    {
        $this->db->where_in('row_id', $row_id);
        $this->db->update('tbl_photo_gallery', $newsInfo);
        return TRUE;
    }

}?>