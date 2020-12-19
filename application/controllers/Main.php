<?php class main extends CI_Controller {
function __construct() {
	parent::__construct();
	if ($this->session->userdata('logged_company')) {
		$this->load->model('user_login');
		if($this->session->userdata('logged_company')['type'] == 'c'){
			$sesid = $this->session->userdata('logged_company')['id'];
			$this->data['all_location_list'] = $this->user_login->get_all_location($sesid);
			$this->data['user_permission_list'] = $this->user_login->getAllPermission();
		}else{
			$sesid = $this->session->userdata('logged_company')['u_id'];
			$this->data['all_location_list'] = $this->user_login->get_location($sesid);
			$this->data['user_permission_list'] = $this->user_login->getUserPermission($sesid);
		}
	}
	$this->load->library('Web_log');
	$p = new Web_log;
	$this->allper = $p->Add_data();
}
    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->view('web/index', $data);
    }

    function register() {
        $this->load->view('register');
    }

    function form() {
        $this->load->view('form');
    }

    function test() {
        $this->load->view('test');
    }

    function add() {
        $this->load->view('form_insert');
    }

    // user insert
    public function insert() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[7]|is_unique[signup.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[signup.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[8]');
        if ($this->form_validation->run()) {
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );
            $this->db->insert('signup', $data);

            redirect('main/register', $data);
        } else {
            $this->register();
        }
    }

    function login_validation() {
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
			
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $this->load->model('user_login');
            $login1 = $this->user_login->login($email, $password);
            if ($login1 != "") {
            $login = $this->user_login->login_check_bolck($email, $password);
//             echo $this->db->last_Query();die();
            // print_r($login[0]->email);
            // die();
               if ($login != "") {
            $id = $login[0]->id;
            $username = $login[0]->name;
            $email = $login[0]->email;
            $mobile = $login[0]->mobile;
            $password = $login[0]->password;
            $type = $login[0]->type;
            $u_id = $login[0]->company_id;
            if($type == "c"){
             
                $session_data = array(
                    'id' => $id,
                    'name' => $username,
                    'email' => $email,
                    'mobile' => $mobile,
                    'type' =>$type,
                    'u_id' =>$u_id 
                ); 
            }else{
				
                 $session_data = array(
                    'id' => $u_id,
                    'name' => $username,
                    'email' => $email,
                    'mobile' => $mobile,
                    'type' =>$type,
                    'u_id' =>$id 
                ); 
            }
            
                $this->session->set_userdata('logged_company', $session_data);
				redirect(base_url() . 'main/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Your account is blocked');
                redirect(base_url() . 'company_login/index');
            }
            }else{
                $this->session->set_flashdata('error', 'Invalid Username Or password');
                redirect(base_url() . 'company_login/index');
            }
        } else {
            $this->index();
        }
    }

    function dashboard() {
		
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
		$this->load->model('user_login');
		
                
		$data['lid'] =  $this->input->get('l_id');
                if($data['lid'] != ""){
                   $l_id =  $data['lid'];
                }else{
                     $l_id = 38;
                }
                $select = $this->user_login->get_chart_data($l_id);
				//echo $this->db->last_query();
                $month_Array = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
		$pdata=array(); 
		$p_year = date("Y",strtotime("-1 year"));
		$c_year = date("Y");
		$temp = array();
		foreach ($select as $detail){
			$month = $month_Array[$detail->month];
			$temp[$detail->month]['month'] = $month;
			if($year != $detail->year){
				$temp[$detail->month]['pre_p_selling'] = $detail->p_selling;
				$temp[$detail->month]['pre_d_selling'] = $detail->d_selling;
			}else{
				$temp[$detail->month]['p_selling'] = $detail->p_selling;
				$temp[$detail->month]['d_selling'] = $detail->d_selling;
			}
			
		}
                $data['location'] = $this->data['all_location_list'];
                $y = 1;
                $c_y = 0;
               // if($_GET['dub'] == '1'){
                $f_array = array(); 
                    for($i=0;$i<=11;$i++){
                          $ar = array();
                   $month =  date("m",strtotime("-$i month"));
                   $m =  date("F",strtotime("-$i month"));
                  
                   /*if($month == 12){
                       $c_y = 1;
                       $y = 2;
                   }*/

                   $p_year = date("Y",strtotime("-$y year"));
                   $c_year = date("Y",strtotime("-$c_y year"));
                   if($_GET['debug'] == '1'){
                    echo "month =  ".$month." p_year = ".$p_year." c_year = ".$c_year."<br>";
                   }
                   
                   $c_data = $this->user_login->get_chart_data_new($l_id,$month,$c_year);
                   $p_data = $this->user_login->get_chart_data_new($l_id,$month,$p_year);
                   $c_p_selling = $c_data[0]->p_selling;
                   $c_d_selling = $c_data[0]->d_selling;
                   $p_p_selling = $p_data[0]->p_selling;
                   $p_d_selling = $p_data[0]->d_selling;                  
                   if(empty($c_data)){
                   $c_p_selling = 0;
                   $c_d_selling = 0;
                   }
                   if(empty($p_data)){
                   $p_p_selling = 0;
                   $p_d_selling = 0;
                   }
                   $ar = array ("month"=>$m ,
                                "p_selling"=>$c_p_selling,
                                "d_selling"=>$c_d_selling,
                                "pre_p_selling"=>$p_p_selling,
                                "pre_d_selling"=>$p_d_selling);
                    
                   array_push($f_array, $ar);
                }
              /*  echo "<pre>";
                print_r($f_array);
                print_r($temp);
                
                die();*/
               // }
		$data['final_chart'] = $f_array;
        $this->load->view('web/index', $data);
        // redirect(base_url() . 'main/index');
    }

    // logout code
    function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'company_login/index');
    }

}

?>