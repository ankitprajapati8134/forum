<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id = $id";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }

    ?>

    <!-- Here i handle the Post method -->
    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //Insert thread into db
        $th_title = $_POST['title']; // this 'title' and 'desc' is mentioned in the form tag in this file 
        $th_desc = $_POST['desc'];
        $th_title = str_replace("<","&lt;",$th_title); // here if user enter the details with <>tag then it convert it into string
        $th_title = str_replace(">","&gt;", $th_title);

        $th_desc = str_replace("<","&lt;",$th_desc); // here if user enter the details with <>tag then it convert it into string
        $th_desc = str_replace(">","&gt;", $th_desc);

        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, 
                `thread_user_id`, `timestamp`) VALUES('$th_title','$th_desc','$id','$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Thread has been added!, Please wait for Community respond to this forum.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }

    ?>


    <!-- Categories container starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> Forums</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>This is a Peer to Peer forum for sharing knowledge with each other.
                Do not offer to pay for help.
                Do not advertise on the support forums.
                Do not post about commercial products.
                Do not create multiple accounts.
                Be mindful when creating links to external resources.
                We reserve the right to manage the forums to the best of our ability.
            </p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <!-- if i want to make a post request in the same page then
         we use this technique inside form action="<?php echo $_SERVER['REQUEST_URI'] ?>" -->
    
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
       echo'<div class="container">
        <h1 class="py-2">Start a Discussion</h1>
        <form action= "'. $_SERVER["REQUEST_URI"]. '" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="title">
                <small id="eamilHelp" class="form-text text-muted">Keep your title as short and crisp as
                    possible</small>
            </div>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">

            <div class="form-group mt-3">
                <label for="exampleFormControlTextarea1">Elaborate Your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success mt-2">Submit</button>
        </form>
    </div>';
    }
    else{
        echo '
            <div class="container">
                <h1 class="py-2">Start a Discussion</h1>
                <p class="lead">You are not logged in. Please login to start a Discussion.</p>
            </div>';
       
    }
    ?>

    <div class="container mb-5" id="ques">
        <h1 class="py-2">Browse Questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id= $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true; // here i didnt get the result initially
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false; // here i got the result that is why we same inside the loop
            $id = $row["thread_id"];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            // Now i m matching thread_user_id(threads table) with users sno (users table)
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);

            // Check if any rows were returned
        if ($result2 && mysqli_num_rows($result2) > 0) {
            $row2 = mysqli_fetch_assoc($result2);
            $user_email = $row2['user_email'];
        } else {
            // Set a default user email or handle this case as per your requirement
            $user_email = "Unknown User";
        }
            
            // $row2 = mysqli_fetch_assoc($result2);
            


            echo '   <div class="media mt-3">
            <img src="img/userdefault.png" width="54px"  class="mr-3" alt="...">
            <div class="media-body">
            <p class="fw-bold my-0 text-end">Asked by: '. $user_email . '  at '. $thread_time .'</p>
                <h5 class="mt-0"> <a class="text-dark" href="thread.php?threadid=' . $id . '">' . $title . ' </a></h5>
                ' . $desc . '
            </div>
        </div>';
        }
        // echo var_dump($noResult); here we use var_dump to check the $noResult is working or not
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <p class="display-4">No Threads Found</p>
                  <h3 class="lead">Be the first person to ask a question.</h3>
                </div>
              </div>';
        }
        ?>

    </div>

    <?php include 'partials/_footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>