<table class="table table-bordered">
  <thead>
    <tr>
      <th>id</th>
      <th>title</th>
      <th>author</th>
      <th>cat</th>
      <th>date</th>
      <th>image</th>
      <th>content</th>
      <th>tags</th>
      <th>comment_<br>count</th>
      <th>status</th>
    </tr>
  </thead>

  <tbody>

    <?php
    $query = "SELECT * FROM posts";
    $select_posts = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($select_posts)) {
      $post_id = $row['post_id'];
      $post_cat_id = $row['post_cat_id'];
      $post_title = $row['post_title'];
      $post_author = $row['post_author'];
      $post_date = $row['post_date'];
      $post_image = $row['post_image'];
      $post_content = $row['post_content'];
      $post_tags = $row['post_tags'];
      $post_comment_count = $row['post_comment_count'];
      $post_status = $row['post_status'];

      echo "<tr>";
      echo "<td>{$post_id}</td>";
      echo "<td><a href='../post.php?p_id={$post_id}';>{$post_title}</a></td>";
      echo "<td>{$post_author}</td>";

      $query = "SELECT * FROM categories WHERE cat_id = {$post_cat_id}";
      $select_categories_id = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($select_categories_id)) {
        $cat_id = $row['cat_id'];

        $cat_title = $row['cat_title'];


      echo "<td>{$cat_title}</td>";
      }




      echo "<td>{$post_date}</td>";
      echo "<td><img class='rj-img-posts' src='../images/$post_image' alt='img'></td>";
      echo "<td><div class='rj-td-wrap'>{$post_content}</div></td>";
      echo "<td>{$post_tags}</td>";
      echo "<td>{$post_comment_count}</td>";
      echo "<td>{$post_status}</td>";

      
      // echo "<td><a href='../post.php?p_id={$post_id}';>View Post</a></td>";

      echo "<td style='display: flex;justify-content: center;align-items: center;background: orange;'>";
      echo "<a href='posts.php?source=edit_post&p_id={$post_id}' class='';>Edit</a></td>";

      echo "<td style='display: flex;justify-content: center;align-items: center;background: red;'>";
      echo "<a href='posts.php?delete={$post_id}' class=''; onClick=\" return confirm('Are you sure you want to delete?'); \">Delete</a></td>";
      
      echo "</tr>";
    }


    ?>
<script>
function confirmMe() {
//TODO write better confirm function!!

confirm('are you sure you want to delete?');

return

}
</script>


  </tbody>

  <?php 
  
  if(isset($_GET['delete'])) {

    $del_post_id = $_GET['delete'];

    $query = "DELETE FROM posts WHERE post_id = {$del_post_id}";

    $delete_query = mysqli_query($conn ,$query);

    header("Location: posts.php");

  }
  
  ?>





</table>