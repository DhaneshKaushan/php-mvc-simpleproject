<?php require APPROOT.'/views/inc/header.php';?>
    <!--top navigationbar -->
    <?php require APPROOT.'/views/inc/components/topnavbar.php';?>
    
   <h1>Posts Create</h1>

   <div class="posts-container">
    <center><h2>Create a post</h2></center>
    <form action="<?php echo URLROOT;?>/Posts/create" method ="post">
        <input type="text" name="title" placeholder="Title" value="<?php $data['title'];?>">
        <span class="form-invalid"><?php echo $data['title_err'];?></span>
        <br>
        <textarea type="text" name="body" placeholder="Content" rows="10" cols="70" value="<?php $data['body'];?>"></textarea>
        <span class="form-invalid"><?php echo $data['body_err'];?></span>
        <br>
        <input type="submit" value="Post" class="post-btn">
    </form>
   </div>
    
<?php require APPROOT.'/views/inc/footer.php';?>       
   