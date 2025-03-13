class validaciones
{
    constructor(param)
    {
        this.param = param
    }

    validarEmail()
    {
        let email = this.param
        let valido= true

    


        if(!email.match(/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/) )
        {
        }
        else
        {
            alert('Email no valido')
            valido=false;
        }
        return valido
    }


    validarPassword()
    {
        let password = this.param
        let valido= true
        if(!password.match(/^(?=.*[A-Z])(?=.*\d)[0-9A-Za-z]{8,}$/))
        {
            alert('La contraseña debe contener al menos un numero')
            valido= false
        }
        return valido
    }


    validarNombre()
    {
        let nombre = this.param
        var validNombre =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
        if( nombre.test(validNombre.value) )
        {
        }
        else
        {
            alert('nombre no valido')
            valido=false;
        }
        if(nombre.length < 1)
        {
            alert('nombre no valido')
            valido=false;
        }
        return valido
    }




}