$(function () {
    // login Class Authentication

    let loginForm = document.querySelector(".loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", (e) => {
            e.preventDefault();
            let btn = document.querySelector(".login-btn");
            btn.disabled = true;
            btn.style.backgroundColor = "#fe980f";
            btn.textContent = "Please Wait...";
            let formdata = new FormData(loginForm);
            formdata = JSON.stringify(Object.fromEntries(formdata.entries()));
            $.ajax({
                type: "POST",
                url: "/E_Commerce/public/Login",
                data: formdata,
                success: function (res) {
                    console.log(res);
                    res = JSON.parse(res);
                    console.log('success' in res);
                    if ('success' in res) {
                        $(".not-exists").css("display", 'none');
                        $(".success").css("display", 'block');
                        location.replace("/E_Commerce/public")
                        // location.reload();
                    }
                    else {
                        $(".not-exists").css("display", 'not-exists' in res ? 'block' : 'none');
                    }
                    btn.disabled = false;
                    btn.textContent = "Login";
                },
            });
        });
    }
    let SignupForm = document.querySelector(".sign-up-form");
    if (SignupForm) {
        SignupForm.addEventListener("submit", (e) => {
            e.preventDefault();
            let btn = document.querySelector(".signup-btn");
            btn.disabled = true;
            btn.style.backgroundColor = "#fe980f";
            btn.textContent = "Please Wait...";
            let formdata = new FormData(SignupForm);
            formdata = JSON.stringify(Object.fromEntries(formdata.entries()));
            let errors = ['.valid-name', '.valid-email', '.exists', '.pass'];
            $.ajax({
                type: "POST",
                url: "/E_Commerce/public/Signup",
                data: formdata,
                success: function (res) {
                    res = JSON.parse(res);
                    if ('success' in res) {
                        errors.forEach((e) => {
                            $(e).css('display', 'none');
                        })
                        $(".success").css("display", 'block');
                        location.replace("/E_Commerce/public")
                    }
                    else {
                        errors.forEach((e) => {
                            $(e).css("display", e.slice(1) in res ? 'block' : 'none');
                        })
                    }
                    btn.disabled = false;
                    btn.textContent = "Sign Up";
                },
            });
        });
    }



});
function getProducts() {
    let parent = $(".features_items")
    $.ajax({
        type: "POST",
        url: parent.attr("link"),
        success: function (res) {
            res = JSON.parse(res)
            parent.append(res);
        }
    });
}
if (document.title == "Home | E-Shopper" || document.title == 'Shop | E-Shopper') {
    getProducts()
}