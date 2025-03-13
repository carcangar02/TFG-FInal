<div class="loginSignUpDisplay">
    <div id="inputForm2" class="inputForm">
            <div class="header"><h1>Sign Up</h1></div>
            <form  action="<?php echo base_url();?>SignUpController/signUp" method="POST" class="form">
                <input type="text" class="input" name="signUsername" placeholder="Usuario" required>
                <input type="text" class="input" name="signEmail" placeholder="Correo" required>
                <input type="password" class="input" name="signPassword" placeholder="Contraseña" required>
                <button type="submit" class="button">Submit</button>
            </form >
            
        </div>
</div>
