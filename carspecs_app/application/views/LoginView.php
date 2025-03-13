    <div class="loginSignUpDisplay">
        <a href="<?php echo base_url();?>BuscadorController/display">
            <button type="button" class="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>

            </button>
        </a>
        <div id="inputForm1" class="inputForm">
            <div class="header"><h1>Login</h1></div>
            <form action="<?php echo base_url();?>LoginController/login"method="post" class="form">
                <input type="text" class="input" name="loginUsername" placeholder="Usuario" required>
                <input type="password" class="input" name="loginPassword" placeholder="Contraseña" required>
                <button type="submit" class="button" id="iniciarSesion">Entrar</button>
            </form>
            <a href="<?php echo base_url();?>SignUpController/signUp"><button class="button">Registrarse</button></a>
            <a href="<?php echo base_url();?>LoginController/redireccionMailer">Olvide mi contraseña</a>
        </div>
    </div>

    
