const form = document.querySelector("form");
const notificationDiv = document.getElementById("notification");
const notificationTitle = document.getElementById("notification-title");
const notificationBody = document.getElementById("notification-body");

form.addEventListener("submit", Validate);
function Validate(event) {
    const username = document.getElementById("Inputusername");
    const password = document.getElementById("InputPassword");

    if (username.value.length <= 0) {
        notificationDiv.style.display = "block";
        notificationBody.innerHTML = "نام کاربری نمی تواند خالی باشد";
        event.preventDefault();
    }else if (password.value.length <= 0){
        notificationDiv.style.display = "block";
        notificationBody.innerHTML = "کلمه عبور نمی تواند خالی باشد";
        event.preventDefault();
    }else{
    //    event.preventDefault();
    //    onSubmit();
    }
}
function onSubmit() {
    const formData = new FormData();

    const username = $("#Inputusername").val();
    const password = $("#InputPassword").val();

    const remember_me = $("#Checkremember").val();

    formData.append("username",username);
    formData.append("password",password);
    formData.append("remember_me",remember_me.toString());

    $.ajax({
        url: 'login.php',
        type: 'post',
        data : formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
        }

    });

}
