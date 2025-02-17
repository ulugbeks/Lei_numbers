// document.addEventListener("DOMContentLoaded", function () {
//     var form = document.getElementById("contact-form");

//     form.addEventListener("submit", function (event) {
//         event.preventDefault(); // Отменяем стандартную отправку

//         var formData = new FormData(form);

//         fetch(form.action, {
//             method: "POST",
//             body: formData,
//             headers: {
//                 "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
//             }
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 document.getElementById("success-message").textContent = "Your message has been sent successfully!";
//                 document.getElementById("success-message").style.display = "block";
//                 document.getElementById("error-message").style.display = "none";
//                 form.reset(); // Очищаем форму
//             } else {
//                 document.getElementById("error-message").textContent = "An error occurred. Please try again.";
//                 document.getElementById("error-message").style.display = "block";
//                 document.getElementById("success-message").style.display = "none";
//             }
//         })
//         .catch(error => {
//             document.getElementById("error-message").textContent = "An error occurred. Please try again.";
//             document.getElementById("error-message").style.display = "block";
//             document.getElementById("success-message").style.display = "none";
//         });
//     });

//     // Телефон с кодом страны
//     var input = document.querySelector("#phone");
//     var iti = window.intlTelInput(input, {
//         separateDialCode: true,
//         preferredCountries: ["lv", "us", "gb", "de", "fr"],
//         utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
//     });

//     input.addEventListener("countrychange", function () {
//         var code = iti.getSelectedCountryData().dialCode;
//         document.querySelector("#phone_code").value = "+" + code;
//     });

//     setTimeout(function () {
//         var code = iti.getSelectedCountryData().dialCode;
//         document.querySelector("#phone_code").value = "+" + code;
//     }, 500);
// });


$(document).ready(function () {
    $('#register-form').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function (xhr) {
                alert("Something went wrong. Please try again.");
            }
        });
    });
});
