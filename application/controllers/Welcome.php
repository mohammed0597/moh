<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');        /**LOADING HELPER TO AVOID PHP ERROR ****/
        $this->load->model('Welcome_model','welcome'); /* Welcome_model as welcome */
    }

	public function index()
	{
		$this->data['get_data']= $this->welcome->get_data();
        $this->load->view('contents', $this->data, FALSE);
	}


	public function contents()
	{
		$this->data['get_data']= $this->welcome->get_data();
        $this->load->view('contents', $this->data, FALSE);
	}


	public function savelikes()
	{
	$ipaddress=$_SERVER['REMOTE_ADDR'];
	$storyid=$this->input->post('Storyid');


	$fetchlikes=$this->db->query('select likes from story where id="'.$storyid.'"');
	$result=$fetchlikes->result();

	$checklikes = $this->db->query('select * from storylikes 
		                            where storyid="'.$storyid.'" 
		                            and ipaddress = "'.$ipaddress.'"');
	$resultchecklikes = $checklikes->num_rows();

	if($resultchecklikes == '0' ){
	if($result[0]->likes=="" || $result[0]->likes=="NULL")
	{
		$this->db->query('update story set likes=1 where id="'.$storyid.'"');
	}
	else
	{
		$this->db->query('update story set likes=likes+1 where id="'.$storyid.'"');
	}

	$data=array('storyid'=>$storyid,'ipaddress'=>$ipaddress);
	$this->db->insert('storylikes',$data);
	}else{
	$this->db->delete('storylikes', array('storyid'=>$storyid,
										  'ipaddress'=>$ipaddress));
	$this->db->query('update story set likes=likes-1 where id="'.$storyid.'"');
	}

	$this->db->select('likes');
	$this->db->from('story');
	$this->db->where('id',$storyid);
	$query=$this->db->get();
	$result=$query->result();

	echo $result[0]->likes;
	}


}
