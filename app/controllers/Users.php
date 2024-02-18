<?php
   class Users extends controller{
    private $userModel;
    public function __construct()
    {
      $this->userModel = $this->model('M_Users');
    }
    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //form is submiting
            //validate the data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            
            //input data
            $data = [
                'profile_image'=>$_FILES['profile_image'],
                'profile_image_name'=> time().'_'.$_FILES['profile_image']['name'],
                'name' =>trim($_POST['name']),
                'email'=>isset($_POST['email']) ? trim($_POST['email']) : '',
                'password'=>trim($_POST['password']),
                'confirm_password'=>trim($_POST['confirm_password']),

                'profile_image_err' =>'',
                'name_err'=>'',
                'email_err'=>'',
                'password_err'=>'',
                'confirm_password_err'=>''
            ];
            //validate all inputs
            //validate profile image and upload
            if(uploadImage($data['profile_image']['tmp_name'], $data['profile_image_name'], '/img/profileImgs')){
                //done
            }
            else{
                $data['profile_image_err'] = 'Profile picture uploading unsuccessful';
            }
            //validate name
            if(empty($data['name'])){
                $data['name_err']='Please enter a name';
            }
            //validate email
            if(empty($data['email'])){
                $data['email_err']='Please enter a email';
            }
            else{
                //check email is already registered or not
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err']='Email is already registered'; 
                }
            }
            //validate password
            if(empty($data['password'])){
                $data['password_err']='Please enter a password';
            }
            elseif(empty($data['confirm_password'])){
                $data['confirm_password_err']='Please confirm the password';
            }
            else{
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err']='Passwords are not matching';  
                }
            }

            //validate is completed and no error then register the user
            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['profile_image_err']) ){
                //Hash Passsword
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

                //register user
                if($this->userModel->register($data)){
                    //create a flash message
                    flash('reg_flash','You are successfully registered!');
                    redirect('Users/login');
                }
                else{
                    die('Something went wrong');
                }
            }
            else{
                $this->view('users/v_register',$data);
            } 
            
        }
        else{
            //initial form
            $data = [
                'profile_image'=>'',
                'profile_image_name'=> '',
                'name' =>'',
                'email'=>'',
                'password'=>'',
                'confirm_password'=>'',

                'profile_image_err' =>'',
                'name_err'=>'',
                'email_err'=>'',
                'password_err'=>'',
                'confirm_password_err'=>''
            ];
            //load view 
            $this->view('users/v_register',$data);
        }
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //form is submiting
            //validate the data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            
            //input data
            $data = [
                'email'=>isset($_POST['email']) ? trim($_POST['email']) : '',
                'password'=>trim($_POST['password']),

                'email_err'=>'',
                'password_err'=>''
            ];
            
            //validate email
            if(empty($data['email'])){
                $data['email_err']='Please enter a email';
            }
            else{
                if($this->userModel->findUserByEmail($data['email'])){
                    //user found
                }
                else{
                    $data['email_err']='No user found'; 
                }
            }
            //validate password
            if(empty($data['password'])){
                $data['password_err']='Please enter a password';
            }

            //validate is completed and no error then register the user
            if(empty($data['email_err']) && empty($data['password_err'])){
              //log the user 
              $loggedUser = $this->userModel->login($data['email'],$data['password']);
              if($loggedUser){
                //user the athenticated
                //create user session 
                $this->createUserSession($loggedUser);
                redirect('Posts/index');

              }else{
                $data['password_err']='Password is incorrect';
                $this->view('users/v_login',$data);
              }
            }else{
                $this->view('users/v_login',$data);
            }
        }
        else{
            //initial form
            $data = [
                'email'=>"",
                'password'=>"",
               

               
                'email_err'=>'',
                'password_err'=>''
                
            ];
            //load view 
            $this->view('users/v_login',$data);
        }
    
    }  

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_profile_image'] = $user->profile_image;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        
        redirect('Pages/index');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_profile_image']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();

        redirect('Users/login');
    }

    public function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
        else{
            return false;
        }
    }
}

?>  