<html>

<script>
    function ValidationOfForm() {
        var name = document.forms["loginform"]["name"].value;
        var email = document.forms["loginform"]["email"].value;
        if (name == "") {
            alert("Please fill the name");
            return false;
        }else if(email == ""){
            alert("Please fill the email");
            return false;
        }

        let emailchar1 = email.indexOf("@");
        let emailchar2 = email.indexOf(".");
        alert(emailchar1 || emailchar2 == 0)

        if (emailchar1 == 0 || emailchar2 == 0) { 
            alert("Please provide a correct EmailId");
            return false;
        }
    }
</script>

<body>

<form name="loginform" action="welcome_get.php" method="post" onsubmit="return ValidationOfForm()">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
<input type="submit">
</form>

</body>
</html>