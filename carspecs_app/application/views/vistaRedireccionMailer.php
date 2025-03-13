<div class="loginSignUpDisplay">
    <div id="inputForm1" class="inputForm">  
        <div class="form">
            Introduzca su correo;
            <input type="email" id="emailInput" class="input">
            <button type="button"class="button" onclick=validarEmail()>submit</button>
        </div>
    </div>
</div>
<script>
    function validarEmail()
    {
        const email = document.getElementById('emailInput').value
        const validar = new validaciones(email)
        if(validar.validarEmail()==true)
        {
            alert('ok')
            $.ajax({
            method: "POST",
            url: "mailer",
            data: {'email':email}
            })
        }
    }
</script>