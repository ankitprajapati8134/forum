<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="signupModalLabel">SignUp for the Coding Forum</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/forum/partials/_handleSignup.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="signupEmail" name="signupEmail" placeholder="Username" aria-describedby="emailHelp">
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="signupPassword" id="signupPassword">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="signupcPassword" id="signupcPassword">
                    </div>
                    <button type="submit" class="btn btn-primary">SignUp</button>

                </div>

            </form>
        </div>
    </div>
</div>