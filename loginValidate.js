
function validation()
{
    if(document.loginForm.txtName.value == "")
    {
        alert("Enter username");
        return false;
    }   

    if(document.loginForm.txtPassword.value == "")
    {
        alert("Enter password");
        return false;
    }  

    if(document.loginForm.userType.value == "")
    {
       alert("select user type");
       return false;
    }  
        
    return true;
}