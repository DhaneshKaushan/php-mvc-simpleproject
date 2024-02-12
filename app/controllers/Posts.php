<?php
   class Posts extends Controller{
    private $postsModel;
    public function __construct()
    {
      $this-> postsModel = $this->model('M_Posts');
    }
    //VIEW
    public function index(){
      $posts = $this->postsModel->getPosts();
      $data = [
        'posts' => $posts
      ];
      $this->view('posts/v_index',$data);
    }
    //CREATE
    public function create(){
     if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
      $data = [
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'title_err' => '',
        'body_err' => ''
      ];
      //validation
      if(empty($data['title'])){
        $data['title_err'] = 'Please enter a title';
      }
      if(empty($data['body'])){
        $data['body_err'] = 'Please enter a content';
      }
      if(empty($data['title_err']) && empty($data['body_err'])){
         if($this->postsModel->create($data)){
          flash('post_msg','Post is published');
          redirect('Posts/index');
         }
         else{
           die('Something went wrong');
         }
      }
      else{
        //loading view with errors
        $this->view('posts/v_create',$data);
      }
           
     }
     else{
      $data = [
        'title' => '',
        'body' => '',
        'title_err' => '',
        'body_err' => ''
      ];
      $this->view('posts/v_create',$data);
     }
    }
    //EDIT
    public function edit($postId){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
       $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
       $data = [
         'post_id' => $postId,
         'title' => trim($_POST['title']),
         'body' => trim($_POST['body']),
         'title_err' => '',
         'body_err' => ''
       ];
       //validation
       if(empty($data['title'])){
         $data['title_err'] = 'Please enter a title';
       }
       if(empty($data['body'])){
         $data['body_err'] = 'Please enter a content';
       }
       if(empty($data['title_err']) && empty($data['body_err'])){
          if($this->postsModel->edit($data)){
           flash('post_msg','Post is updated');
           redirect('Posts/index');
          }
          else{
            die('Something went wrong');
          }
       }
       else{
         //loading view with errors
         $this->view('posts/v_edit',$data);
       }
            
      }
      else{

       $post = $this->postsModel->getPostById($postId);
       if($post->user_id != $_SESSION['user_id']){
         redirect('Posts/index');
       }
       $data = [
         'post_id' => $postId,
         'title' => $post->title,
         'body' => $post->body,
         'title_err' => '',
         'body_err' => ''
       ];
       $this->view('posts/v_edit',$data);
      }
    }
    //DELETE
    public function delete($postId){
      
        $post = $this->postsModel->getPostById($postId);
        //check owner
        if($post->user_id != $_SESSION['user_id']){
          redirect('Posts/index');
        }
        else{
          if($this->postsModel->delete($postId)){
            flash('post_msg','Post is removed');
            redirect('Posts/index');
          }
          else{
            die('Something went wrong');
  
          }
        }
    }
  
  }
?>