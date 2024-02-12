<?php require APPROOT.'/views/inc/header.php';?>
    <!--top navigationbar -->
    <?php require APPROOT.'/views/inc/components/topnavbar.php';?>
    
   <h1>Posts edit</h1>

   <div class="posts-container">
    <center><h2>Edit the post</h2></center>
    <form action="<?php echo URLROOT;?>/Posts/edit/<?php echo $data['post_id']?>" method ="post">
        <input type="text" name="title" placeholder="Title" value="<?php  echo $data['title'];?>">
        <span class="form-invalid"><?php echo $data['title_err'];?></span>
        <br>
        <textarea type="text" name="body" placeholder="Content" rows="10" cols="70" ><?php  echo $data['body'];?></textarea>
        <span class="form-invalid"><?php echo $data['body_err'];?></span>
        <br>
        <input type="submit" value="Update" class="post-btn">
    </form>
   </div>
    
<?php require APPROOT.'/views/inc/footer.php';?>       
   