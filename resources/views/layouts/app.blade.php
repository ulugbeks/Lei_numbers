<!DOCTYPE HTML>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon" type="image/icon" href="{{ asset('assets/img/favicon.png') }}">
    <!-- CSS Here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jarallax.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link href="{{ asset('assets/css/select2.css') }}?v={{ time() }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body> 



    @yield('content')


<!-- JS Here -->
@yield('scripts')
<script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.odometer.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.appear.js') }}"></script>
<script src="{{ asset('assets/js/gsap.js') }}"></script>
<script src="{{ asset('assets/js/ScrollTrigger.js') }}"></script>
<script src="{{ asset('assets/js/SplitText.js') }}"></script>
<script src="{{ asset('assets/js/gsap-animation.js') }}"></script>
<script src="{{ asset('assets/js/jarallax.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.parallaxScroll.min.js') }}"></script>
<script src="{{ asset('assets/js/particles.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.inview.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/ajax-form.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/aos.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}?v={{ time() }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://js.stripe.com/v3/"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    $(document).ready(function() {
        // === 1. Инициализация Select2 (Страны с флагами) ===
        $('#country').select2({
            placeholder: "Select Your Country...",
            allowClear: true, // Позволяет очистить выбор
            templateResult: formatCountry,
            templateSelection: formatCountry,
            width: '100%'
        });

        function formatCountry(country) {
            if (!country.id) return country.text;
            var countryCode = $(country.element).data('code');
            if (!countryCode) return country.text;

            var flagUrl = "https://flagcdn.com/w40/" + countryCode + ".png";
            return $('<span><img src="' + flagUrl + '" class="img-flag" /> ' + country.text + '</span>');
        }

        // === 2. Инициализация intlTelInput (Телефон с кодом страны) ===
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            initialCountry: "auto",
            preferredCountries: ["lv", "us", "gb", "de", "fr"],
            separateDialCode: true,
            geoIpLookup: function(success, failure) {
                fetch("https://ipapi.co/json/")
                    .then(response => response.json())
                    .then(data => success(data.country_code.toLowerCase()))
                    .catch(() => success("us"));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // === 3. При изменении страны в Select2 — обновлять код телефона ===
        $('#country').on('change', function() {
            var selectedCountry = $(this).val();
            iti.setCountry(selectedCountry.toLowerCase());
        });

        // === 4. Автоопределение страны пользователя при загрузке ===
        $.get("https://ipapi.co/json/", function(data) {
            var userCountry = data.country_code.toUpperCase();
            $('#country').val(userCountry).trigger('change');
            iti.setCountry(userCountry.toLowerCase());
        }, "json");
    });
</script>

<style>
    .img-flag {
        width: 20px;
        height: 14px;
        margin-right: 10px;
        display: inline-block;
    }
</style>


<script>
    $(document).ready(function() {
        $('.register-form').on('submit', function(e) {
            e.preventDefault(); // Отменяем стандартное поведение формы

            let formData = $(this).serialize(); // Собираем данные формы

            $.ajax({
                url: "{{ url('/contact-submit') }}",
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('.register-form').trigger('reset'); // Очищаем форму
                    $('#success-message').text(response.success).fadeIn().delay(3000).fadeOut();
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "An error occurred.";
                    if (errors) {
                        errorMessage = Object.values(errors).join("<br>");
                    }
                    $('#error-message').html(errorMessage).fadeIn().delay(5000).fadeOut();
                }
            });
        });
    });
</script>

<script>
    document.querySelector("form").addEventListener("submit", function(event) {
        var checkbox = document.getElementById("terms");
        if (!checkbox.checked) {
            alert("You must accept the Terms and Conditions before submitting the form.");
            event.preventDefault();
        }
    });
</script>

</body>
</html>