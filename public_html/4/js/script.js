$(document).ready( function () {
    //Авто-вход по сессии
    $.ajax({
        method: "POST",
        url: "session_check.php",
        dataType: "json",
    }).done(function (response) {
        if (response.status) {
            alert('yep');
        } else {
            alert('nope');
        }
    })

    //Сохранение кода для восстановлени пароля
    let codeOriginal = "";

    //Подсказки
    $(".help-button").click($(function () {
        $('[data-toggle="tooltip"]').tooltip()
    }));

    //Очистка формы при регистрации
    $("#clearForm").on('click', function (e) {
        e.preventDefault();
        $("#form-singin").reset();
    })

    //Ошибки AJAX
    $.ajaxSetup({
        error: function (x, status, error) {
            alert("An error occurred: " + status + " Error: " + error);}
    });

    //Авторизация
    $("#form-auth").on('submit', function (e) {
        e.preventDefault();
        let login = $("#login").val();
        let password = $("#password").val();
        let session = $("#rememberMe").is(':checked');
        $.ajax({
            method: "POST",
            url: "index.php",
            dataType: "json",
            data: {
                login: login,
                password: password,
                session: session
            },
            error: function (data) {
                alert('err: no ajax: ' + data);
            }
        }).done(function (response) {
            if (response.auth) {
                alert("Добро пожаловать, "+login);
                //location.href = 'home.html';
            } else {
                alert("Неправильный логин или пароль");
            }
        })
    });

    //Регистрация
    $("#form-singin").on('submit', function (e) {
        e.preventDefault();
        let name = $("#name").val();
        let email = $("#email").val();
        let login = $("#login").val();
        let password = $("#password").val();
        let passwordRep = $("#passwordRep").val();
        $.ajax({
            method: "POST",
            url: "singin.php",
            dataType: "json",
            data: {
                name: name,
                email: email,
                login: login,
                password: password,
                passwordRep: passwordRep
            },
            error: function (data) {
                alert('err: no ajax: ' + data);
            }
        }).done(function (response) {
            if (response.regFlag === 'yep') {
                alert("Добро пожаловать, "+login);
                location.href = 'index.html';
            } else {
                alert(response.errors);
            }
        })
    });

    //Отправка кода для восстановления пароля
    $("#sendCode").on('click', function (e) {
        e.preventDefault();
        let login = $("#login").val();
        let email = $("#email").val();
        $.ajax({
            method: "POST",
            url: "rec.php",
            dataType: "json",
            data: {
                login: login,
                email: email
            },
            error: function (data) {
                alert("no ajax: " + data);
            }
        }).done(function (response) {
            if (!response.loginInvalid && !response.emailInvalid) {
                $("#stage-two").attr("style", "");
                alert("Ваш код для восстаовления пароля: " + response.codeOriginal);
                codeOriginal = response.codeOriginal;
            } else {
                if (response.loginInvalid) {
                    alert("Логин не найден");
                    $("#stage-two").attr("style", "display: none");
                }
                if (response.emailInvalid) {
                    alert("Почта не найдена");
                    $("#stage-two").attr("style", "display: none");
                }
            }
        });
    });

    //Подтверждение кода для восстановления пароля
    $("#confirmCode").on('click', function (e) {
        e.preventDefault();
        let codeInput = $("#code").val();
        if (codeInput === codeOriginal) {
            $("#stage-three").attr("style", "");
        } else {
            alert("Неправильный код");
            $("#stage-two").attr("style", "display: none");
        }
    })

    //Изменение пароля
    $("#form-recovery").on('submit', function (e) {
        e.preventDefault();
        let login = $("#login").val();
        let password = $("#password").val();
        let passwordRep = $("#passwordRep").val();
        $.ajax({
            method: "POST",
            url: "password_change.php",
            dataType: "json",
            data: {
                login: login,
                password: password,
                passwordRep: passwordRep
            },
            error: function (data) {
                alert("err ajax: " + data);
            }
        }).done( function (response) {
            if (response.change === 'yep') {
                alert('Пароль успешно измененн');
                location.href = 'index.html';
            } else {
                alert(response.msg);
            }
        })
    });

});