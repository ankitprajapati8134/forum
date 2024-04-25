<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        #ques {
            min-height: 433px;
        }
    </style>

</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    


    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];

        //Query the users table to find out the name of Original Post
        $sql2 = "SELECT user_email FROM `users` WHERE sno = '$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];

    }

    ?>

    <!-- Post a method for comment in the same page -->
    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {

        //Insert comments into db
        $comment = $_POST['comment']; // this 'comment' is mentioned in the form tag in this file  
        $comment = str_replace("<","&lt;",$comment); // here if user enter the details with <>tag then it convert it into string
        $comment = str_replace(">","&gt;", $comment);

        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`)
                 VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Comment has been added to this forum! .
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }

    ?>

    <!-- Categories container starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This is a Peer to Peer forum for sharing knowledge with each other.
                Do not offer to pay for help.
                Do not advertise on the support forums.
                Do not post about commercial products.
                Do not create multiple accounts.
                Be mindful when creating links to external resources.
                We reserve the right to manage the forums to the best of our ability.
            </p>
            <p>Posted by : <em><?php echo $posted_by; ?> </em></p>
        </div>
    </div>

    <!-- if i want to make a post request in the same page then
         we use this technique inside form action="<?php echo $_SERVER['REQUEST_URI'] ?>" -->
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '<div class="container">
       <h1 class="py-2">Post a Comment</h1>
       <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
           <div class="form-group mt-3">
               <label for="exampleFormControlTextarea1">Type Your Comment</label>
               <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
               <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">

           </div>
           <button type="submit" class="btn btn-success mt-2">Post Comment</button>
       </form>
   </div>';
    } else {
        echo '
            <div class="container">
                <h1 class="py-2">Post a Comment</h1>
                <p class="lead">You are not logged in. Please login to Post comments.</p>
            </div>';
    }
    ?>




    <div class="container mb-5" id="ques">
        <h1 class="py-2">Discussions</h1>
        <?php
        $id = $_GET['threadid']; //here we use threadid which we use or saw in the url of the page
        $sql = "SELECT * FROM `comments` WHERE thread_id= $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true; // here i didnt get the result initially
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false; // here i got the result that is why we same inside the loop
            $id = $row["comment_id"];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];

            $thread_user_id = $row['comment_by'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);


            echo '<div class="media mt-3">
            <img src="img/userdefault.png" width="54px"  class="mr-3" alt="...">
            <div class="media-body">
               <p class="fw-bold  text-right">'. $row2['user_email'] .' at ' . $comment_time . '</p>
                ' . $content . '
            </div>
        </div>';
        }

        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <p class="display-4">No Comments Found</p>
                  <h3 class="lead">Be the first person to comment.</h3>
                </div>
              </div>';
        }

        ?>

    </div>

    <?php include 'partials/_footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>