<?php 
require dirname(__FILE__)."/../libraries/CI_Util.php";
require dirname(__FILE__)."/../libraries/CI_Log.php";
class ManUserCnt extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('ManUserMod');
	}
	
	//获取所有用户的某些信息
	public function getUsersInfo(){
		echo json_encode($this->ManUserMod->getUsersInfo());
	}
	
	//登录
	public function toLogin(){
		$login_name = $_POST['user_name'];
		$password = $_POST['password'];
		$Adata = $this->getLoginUserId($login_name,$password);
		$isExist = $this->isUserExist($Adata);
		
		if($isExist){
			$id = $Adata[0]->id;
			//$who = $Adata[0]->login_name;
			$who = getMemberFromIP();
			$role = $Adata[0]->role;
			
			//设置Global变量 curLoginRole，用来判断当前登录用户的等级，登录以后才能用此变量
			//$GLOBALS['curLoginRole'] = $role;
			
			if($role == 2){
				//echo "refuse";
				exit();
			}
			
			$theTime = date('y-m-d h:i:s',time());
			$where = "从".$_SERVER["REMOTE_ADDR"];
			$doThings = "登录了设备管理系统";
			writeToLog($theTime,$who,$where,$doThings);
			
			//0524：session方法与ManUserMod方法不一致，暂时先注销此处createSession方法
			echo $this->createSession($id);
			
		}else{
			echo "fail";
		}
	}
	
	
	//注册
	function toRegister(){
		$user_name = $_POST['user_name'];
		$login_name = $_POST['login_name'];
		$password = $_POST['password'];
		$registe_time = date('Y-m-d H:i:s',time());
		
		$this->ManUserMod->registerAnUser($user_name,$login_name,$password,$registe_time);
		
		$theTime = date('y-m-d h:i:s',time());
		$who = getMemberFromIP();
		$where = "从".$_SERVER['HTTP_HOST'];
		$doThings = "注册了一个用户：".$login_name;
		writeToLog($theTime,$who,$where,$doThings);
		
		echo "success";
	}
	
	
	//获取登录用户的信息
	public function getLoginUserId($login_name,$password){
		$data = json_encode($this->ManUserMod->login($login_name,$password));
		$Adata = json_decode($data);
		return $Adata;
	}
	
	//判断用户是否存在
	function isUserExist($Adata){
		$c = count($Adata);  //获取是否返回了用户id
		if($c == 0){
			return false;
		}else if($c == 1){
			return true;
		}
	}
	
	//0524：session方法与ManUserMod方法不一致，暂时先注销此处createSession方法
	function createSession($id){
		//以当前的时间戳来作为session
		$session = time();
		$login_time = date('Y-m-d H:i:s',time());
		$this->ManUserMod->createSession($id,$session,$login_time);
		return $session;
	}
	
	//删除一个用户
	function delAnUser(){
		$id = $_POST['id'];
		
		$data = json_encode($this->ManUserMod->getUserInfoFromId($id));
		$Adata = json_decode($data);
		$login_name = $Adata[0]->login_name;
		
		$this->ManUserMod->delAnUser($id);
		
		$theTime = date('y-m-d h:i:s',time());
		$who = getMemberFromIP();
		$where = "从".$_SERVER['HTTP_HOST'];
		$doThings = "删除了一个用户：".$login_name;
		writeToLog($theTime,$who,$where,$doThings);
		
		echo "success";
	}
	
	//添加一个用户
	function addAnUser(){
		$login_name = $_POST['login_name'];
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$role = $_POST['role'];
		$icon = "default.png";
		$registe_time = date('Y-m-d H:i:s',time());
		
		$this->ManUserMod->addAnUser($user_name,$login_name,$password,$role,$icon,$registe_time);
		
		$theTime = date('y-m-d h:i:s',time());
		$who = getMemberFromIP();
		$where = "从".$_SERVER['HTTP_HOST'];
		$doThings = "添加了一个用户".$login_name;
		writeToLog($theTime,$who,$where,$doThings);
		
		echo "success";
	}
	
	//修改用户信息
	function changeUserInfo(){
		$id = $_POST['id'];
		$login_name = $_POST['login_name'];
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$role = $_POST['role'];
		$registe_time = $_POST['registe_time'];
		$login_time = $_POST['login_time'];
		$session = $_POST['session'];
			
		$this->ManUserMod->changeUserInfo($id,$user_name,$login_name,$password,$role,$login_time,$registe_time,$session);
		
		$theTime = date('y-m-d h:i:s',time());
		$who = getMemberFromIP();
		$where = "从".$_SERVER['HTTP_HOST'];
		$doThings = "修改了".$login_name."的用户信息";
		writeToLog($theTime,$who,$where,$doThings);
		
		echo "success";
	}
	
	//修改部分用户信息
	function changeUserInfoPart(){
		$id = $_POST['id'];
		$login_name = $_POST['login_name'];
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
			
		$this->ManUserMod->changeUserInfoPart($id,$user_name,$login_name,$password);
		
		$theTime = date('y-m-d h:i:s',time());
		$who = getMemberFromIP();
		$where = "从".$_SERVER['HTTP_HOST'];
		$doThings = "修改了".$login_name."的用户信息";
		writeToLog($theTime,$who,$where,$doThings);
		
		echo "success";
	}
	
	//修改用户头像
	function changeUserIcon(){
		$id = $_POST['id'];
		$icon = $_POST['icon'];
		$this->ManUserMod->changeUserIcon($id,$icon);
		
		echo "success";
	}
	
	//判断是否登录
	function isLogin(){
		$session = $_POST['session'];
		$result = $this->ManUserMod->getUserInfoFromSession($session);
		if(count($result) == 1){
			echo 1;   //表示登录
		}else if(count($result) == 0){
			echo 0;   //表示未登陆
		}
	}
}

?>