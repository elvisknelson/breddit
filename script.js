function hasSpaces(s)
{
    return s.indexOf(' ') >= 0;
}

function trim(str) 
{
	// Uses a regex to remove spaces from a string.
	return str.replace(/^\s+|\s+$/g,"");
}

function hasText(s)
{
	if(s.value == null || trim(s.value) == "")
	{
		return false;
	}

	return true;
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

    if(username.length < 8)
    {
        throwError("Username must be 8 characters or longer", e);
    }
    else if(password1.length < 8)
    {
        throwError("Password must be 8 characters or longer", e);
    }

    if(username == "")
    {
        throwError("Username cannot be blank", e);
    }
    else if(password1 == "" && password2 == "")
    {
        throwError("Password cannot be blank", e);
    }

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
