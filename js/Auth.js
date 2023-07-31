document.addEventListener("DOMContentLoaded", function () {
    const Button_Register = document.getElementById("button_Register");
    const LoginContainer = document.getElementById("login-container");
    const RegisterContainer = document.getElementById("register-container");
    const AlertContainer = document.getElementsByClassName("row-alert");
    const Button_Login = document.getElementById("button_Login");
    RegisterContainer.style.display = "none";

    function HideRegister_ShowLogin() {

        setTimeout(() => {
            RegisterContainer.style.display = "none";
            LoginContainer.style.display = "block";
        }, 300);

    }
    Button_Login.addEventListener("click", function () {
        HideRegister_ShowLogin();
    });


    function HideLogin_ShowRegister() {

        setTimeout(() => {
            LoginContainer.style.display = "none";
            RegisterContainer.style.display = "block";
        }, 300)
    };
    Button_Register.addEventListener("click", function () {
        HideLogin_ShowRegister();

    });
    function ClearMsgAlert(obj) {
        setTimeout(() => {
            obj.style.display = "none";
        }, 5000);
    }

    ClearMsgAlert(AlertContainer[0])

});
