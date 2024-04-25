<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        #maincontainer {
            min-height: 90vh;
        }
        
    </style>
</head>
<!-- ALTER TABLE threads add FULLTEXT(`thread_title`,`thread_desc`); // to enable full text search in database we apply this
query in the database first .This is like if we want to search content in the search box in frontend

select * from threads where match (thread_title, thread_desc) against ('help me'); -->

<body>

    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>



    <!-- Search Results starts here -->
    <!-- 'search' i take it from the url i.e $_GET['search'] -->
    <div class="container mt-2" id="maincontainer">
        <h1 class="py-2">Search Results for <em>"<?php echo $_GET['search']; ?>"</em></h1>

        <?php
        $noResults =true;
        $searchQuery = $_GET["search"];
        $sql = "select * from threads where match (thread_title, thread_desc) against ('$searchQuery')";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];
            $url = "thread.php?threadid=" . $thread_id;
            $noResults = false;
            //Display the search results

            echo '  <div class="result">
                        <h3> <a href="' . $url . '" class="text-dark">' . $title . '</a></h3>
                        <p>' . $desc . '</p>
                     </div>';
        }
        if($noResults){
            echo '
                <div class="jumbotron jumbotron-fluid">
                    <div class=" mt-4 p-5 bg-light text-dark rounded">
                        <p class="display-4">No Results Found</p>
                            <p class="lead">Suggestions:
                                <ul>
                                    <li>Make sure that all words are spelled correctly.</li>
                                    <li>Try different keywords.</li>
                                    <li>Try more general keywords..</li>
                                </ul>
                            </p>
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