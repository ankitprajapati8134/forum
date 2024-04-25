<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Login to Coding Forum</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="/forum/partials/_handleLogin.php" method="post">
                <div class="modal-body">

                    <div class="mb-3">

                        <input type="text" class="form-control" id="loginEmail" name="loginEmail" 
                        placeholder="Username"  aria-describedby="emailHelp">
                        
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Password" 
                            id="loginPass" name="loginPass">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>

                </div>

            </form>
        </div>
    </div>
</div>