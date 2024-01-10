<?php
include "header.php";
include "../Config.php";
// GET BLOG ID
$blogId = $_GET['blog_id'];
if(empty($blogId)){
    header("location:index.php");
}
if (isset($_SESSION['user_data'])) {
    $author_id = $_SESSION['user_data']['0'];
}

$sql = "SELECT * FROM categories";
$query = mysqli_query($config, $sql);


$sql2 = "SELECT * FROM blog LEFT JOIN categories ON
         blog.category = categories.cat_id LEFT JOIN user ON
         blog.author_id=user.user_id WHERE blog_id='$blogId' ORDER BY blog.publish_date DESC";
$query2 = mysqli_query($config, $sql2);
$result = mysqli_fetch_assoc($query2);
?>

<div class="container">
    <h5 class="mb-2 text-gray-800">Blogs</h5>
    <div class="row">
        <div class="col-xl-7 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary mt-2">Publish blog/article</h6>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" name="blog_title" placeholder="Blog Title" class="form-control" value="<?= $result['blog_title'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Body/Description</label>
                            <textarea name="blog_body" id="blog" placeholder="body" rows="2" required><?= $result['blog_body'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="blog_image" class="form-control">
                            <img src="upload/<?= $result['blog_image'] ?>" width="100px" class="border">
                        </div>
                        <div class="mb-3">
                            <select name="category" class="form-control" required>
                                <?php while ($cats = mysqli_fetch_assoc($query)) { ?>
                                    <option value="<?= $cats['cat_id'] ?>" <?= ($result['category'] == $cats['cat_id']) ? "
                                            selected" : ''; ?>>
                                        <?= $cats['cat_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="update_blog" value="Update" class="btn btn-primary">
                            <a href="index.php" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";

if (isset($_POST['update_blog'])) {
    $title = mysqli_real_escape_string($config, $_POST['blog_title']);
    $body = mysqli_real_escape_string($config, $_POST['blog_body']);
    $filename = $_FILES['blog_image']['name'];
    $temp_name = $_FILES['blog_image']['tmp_name'];
    $size = $_FILES['blog_image']['size'];
    $image_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allow_type = ['jpg', 'png', 'jpeg'];
    $destination = "upload/" . basename($filename); // Include directory separator
    $category = mysqli_real_escape_string($config, $_POST['category']);

    if (!empty($filename)) {
        if (in_array($image_ext, $allow_type)) {
            if ($size <= 2000000) {
                $unlink = "upload/" . $result['blog_image'];
                unlink($unlink);
                move_uploaded_file($temp_name, $destination);
                $sql3 = "UPDATE blog SET blog_title='$title',blog_body='$body',
                    blog_image='$filename',category='$category',author_id='$author_id'
                    WHERE blog_id='$blogId'";
                $query3 = mysqli_query($config, $sql3);

                if ($query3) {
                    $msg = ["Post published successfully", 'alert-success'];
                    $_SESSION['msg'] = $msg;
                    header("location:index.php");
                } else {
                    $msg = ["Failed, please try again", 'alert-danger'];
                    $_SESSION['msg'] = $msg;
                    header("location:index.php");
                }
            } else {
                $msg = ["image size should not be greater than 2mb", 'alert-danger'];
                $_SESSION['msg'] = $msg;
                header("location:index.php");
            }
        } else {
            echo "";
            $msg = ["Invalid file type('jpg', 'png', 'jpeg')", 'alert-danger'];
            $_SESSION['msg'] = $msg;
            header("location:index.php");
        }
    } else {
        $sql3 = "UPDATE blog SET blog_title='$title',blog_body='$body',
                    category='$category',author_id='$author_id'
                    WHERE blog_id='$blogId'";
        $query3 = mysqli_query($config, $sql3);

        if ($query3) {
            $msg = ["Post published successfully", 'alert-success'];
            $_SESSION['msg'] = $msg;
            header("location:index.php");
        } else {
            $msg = ["Failed, please try again", 'alert-danger'];
            $_SESSION['msg'] = $msg;
            header("location:index.php");
        }
    }
}
?>