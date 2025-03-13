<div class="loginSignUpDisplay">
    <div id="inputForm1" class="inputForm">  
        <div class="form">
            Nueva Contraseña
            <input type="text" id="password" class="input">
            <button type="button"class="button" onclick=validarPassword(<?= $email ?>)>submit</button>
        </div>
    </div>
</div>
<script>
    function validarPassword(email)
    {
        const password = document.getElementById('password').value
        const validarPassword = new validaciones(password)
        if(validarPassword.validarPassword()==true)
        {
            $.ajax({
            method: "POST",
            url: "recuperarContrasena",
            data: {'password':password,'email':email}
            })
        }

    }
</script>