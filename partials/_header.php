<?php
session_start();
echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand" href="/forum">Forum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/forum">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   Top Categories
                </a>
                <ul class="dropdown-menu">';

                $sql = "SELECT category_name, category_id FROM `categories` LIMIT 3";
                $result = mysqli_query($conn, $sql); 
                while($row = mysqli_fetch_assoc($result)){
                  echo '<a class="dropdown-item" href="threadlist.php?catid='. $row['category_id']. '">' . $row['category_name']. '</a>'; 
                }
echo '  </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
        </ul>';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { //if user login then i will show this content
    echo '<form class="d-flex" role="search" action="search.php" method="get">
                <input class="form-control  me-2 my-1" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-danger mt-2 mx-2" type="submit">Search</button>
                <p class="text-light my-0 mx-2 text-center" >Welcome ' . $_SESSION['username'] . '</p>
                <a href="partials/_logout.php" class="btn btn-outline-success ml-2 mt-2">Logout</a>
                
                </form>';
} else { // if user is not login then i will show this content  
    echo ' <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-danger mx-2" type="submit">Search</button>
        </form>
        <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>';
}
echo ' </div>  
        </div>
        </nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You can now login
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </button>
        </div>';
}
