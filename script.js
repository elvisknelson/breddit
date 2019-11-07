function hasSpaces(s)
{
    return s.indexOf(' ') >= 0;
}

function throwError(er, e)
{
    e.preventDefault();
    document.getElementById("errormessage").innerHTML = er;
}

function validate(e)
{
    var username = document.getElementById("newusername").value;
    var password1 = document.getElementById("newpassword1").value;
    var password2 = document.getElementById("newpassword2").value;

    if(hasSpaces(username))
    {
        throwError("Username cannot have spaces", e);
    }

    if(password1 != password2)
    {
        throwError("Passwords did not match", e);
    }
}

function load()
{
    document.getElementById("createnewuser").addEventListener("click", validate);
}


document.addEventListener("DOMContentLoaded", load());