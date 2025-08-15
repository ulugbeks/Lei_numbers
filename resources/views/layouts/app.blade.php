<!DOCTYPE HTML>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    
    <!-- SEO Component -->
    <x-seo :page="$page ?? null" />
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <!-- Favicon -->
    <link rel="icon" type="image/icon" href="{{ asset('assets/img/lei-favicon.png') }}">
    
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
    <link rel="stylesheet" href="{{ asset('assets/css/payment.css') }}">
    <link href="{{ asset('assets/css/select2.css') }}?v={{ time() }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->


    <!-- Инициализация Consent Mode перед GTM -->
    <script>
    // Инициализация Google Consent Mode V2
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}

    // Установка значений по умолчанию для Consent Mode V2
    gtag('consent', 'default', {
        'ad_storage': 'denied',
        'analytics_storage': 'denied',
        'functionality_storage': 'denied',
        'personalization_storage': 'denied',
        'security_storage': 'granted',
        'ad_user_data': 'denied',
        'ad_personalization': 'denied'
    });

    // Проверка сохраненных настроек согласия
    function checkSavedConsent() {
        const match = document.cookie.match(new RegExp('(^| )cookie_consent=([^;]+)'));
        if (match) {
            try {
                const preferences = JSON.parse(decodeURIComponent(match[2]));
                gtag('consent', 'update', {
                    'analytics_storage': preferences.analytics ? 'granted' : 'denied',
                    'ad_storage': preferences.marketing ? 'granted' : 'denied',
                    'functionality_storage': preferences.necessary ? 'granted' : 'denied',
                    'personalization_storage': preferences.marketing ? 'granted' : 'denied',
                    'ad_user_data': preferences.marketing ? 'granted' : 'denied',
                    'ad_personalization': preferences.marketing ? 'granted' : 'denied'
                });
            } catch (e) {
                console.error('Error parsing consent cookie', e);
            }
        }
    }
    
    // Проверяем и применяем сохраненные настройки
    checkSavedConsent();
    </script>


     <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-1111111');</script>
    <!-- End Google Tag Manager -->

    <!-- Стили для cookie-баннера -->
    <style>
    /* Cookie Banner Styles */
    .cookie-banner {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.cookie-banner-container {
    background-color: #fff;
    border-radius: 8px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    overflow-y: auto;
}

.cookie-banner-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.cookie-banner-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.cookie-settings-btn {
    background: none;
    border: none;
    color: #1d2a4d;
    font-size: 14px;
    cursor: pointer;
    text-decoration: underline;
    padding: 0;
}

.cookie-banner-content {
    margin-bottom: 20px;
}

.cookie-banner-content p {
    margin: 0 0 10px;
    font-size: 14px;
    line-height: 1.5;
    color: #666;
}

.cookie-banner-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: flex-end;
}

.cookie-btn {
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s;
}

.cookie-btn-primary {
    background-color: #1d2a4d;
    color: white;
}

.cookie-btn-primary:hover {
    background-color: #2c5cc5;
}

.cookie-btn-secondary {
    background-color: #f1f1f1;
    color: #333;
}

.cookie-btn-secondary:hover {
    background-color: #e0e0e0;
}

    /* Cookie Settings Modal */
    .cookie-settings-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 10000;
        justify-content: center;
        align-items: center;
    }

    .cookie-settings-container {
        background-color: #fff;
        border-radius: 8px;
        width: 90%;
        max-width: 600px;
        max-height: 80vh;
        overflow-y: auto;
    }

    .cookie-settings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }

    .cookie-settings-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

    .close-settings-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #666;
    }

    .cookie-settings-content {
        padding: 20px;
    }

    .cookie-category {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .cookie-category:last-child {
        border-bottom: none;
    }

    .cookie-category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .cookie-category-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .cookie-category p {
        margin: 0;
        font-size: 14px;
        line-height: 1.5;
        color: #666;
    }

    /* Toggle Switch */
    .cookie-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .cookie-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .cookie-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .cookie-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .cookie-slider {
        background-color: #1d2a4d;
    }

    input:checked + .cookie-slider:before {
        transform: translateX(26px);
    }

    .cookie-settings-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        text-align: right;
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
        .cookie-banner {
            bottom: 0;
            left: 0;
            right: 0;
            max-width: none;
            border-radius: 8px 8px 0 0;
        }
        
        .cookie-banner-actions {
            flex-direction: column;
        }
        
        .cookie-btn {
            width: 100%;
        }
    }
    </style>

</head>
<body> 
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-1111111"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


    @yield('content')



<!-- Cookie Banner HTML -->
<div id="cookie-banner" class="cookie-banner">
    <div class="cookie-banner-container">
        <div class="cookie-banner-header">
            <h3>We use cookies on this website</h3>
            
        </div>
        <div class="cookie-banner-content">
            <p>This website uses cookies to improve your experience while browsing our site. Of these cookies, those that are classified as necessary are stored in your browser as they are essential for the basic functionality of the website.</p>
            <p>We also use third-party cookies that help us analyze and understand how you use this website. These cookies will be stored in your browser only with your consent.</p>
        </div>
        <div class="cookie-banner-actions">
            <button id="accept-all-btn" class="cookie-btn cookie-btn-primary">Accept all</button>
            <button id="reject-all-btn" class="cookie-btn cookie-btn-secondary">Reject</button>
            <button id="cookie-settings-btn" class="cookie-btn cookie-btn-secondary">Customize selection</button>
        </div>
    </div>
    
    <!-- Cookie Settings Modal -->
    <div id="cookie-settings-modal" class="cookie-settings-modal">
        <div class="cookie-settings-container">
            <div class="cookie-settings-header">
                <h3>Cookie settings</h3>
                <button id="close-settings-btn" class="close-settings-btn">&times;</button>
            </div>
            <div class="cookie-settings-content">
                <div class="cookie-category">
                    <div class="cookie-category-header">
                        <h4>Necessary cookies</h4>
                        <label class="cookie-switch">
                            <input type="checkbox" checked disabled>
                            <span class="cookie-slider"></span>
                        </label>
                    </div>
                    <p>These cookies are necessary for the website to function and cannot be disabled in our systems.</p>
                </div>
                
                <div class="cookie-category">
                    <div class="cookie-category-header">
                        <h4>Analytics cookies</h4>
                        <label class="cookie-switch">
                            <input type="checkbox" id="analytics-cookies-checkbox">
                            <span class="cookie-slider"></span>
                        </label>
                    </div>
                    <p>These cookies allow us to count visits and traffic sources so we can measure and improve our website's performance.</p>
                </div>
                
                <div class="cookie-category">
                    <div class="cookie-category-header">
                        <h4>Marketing cookies</h4>
                        <label class="cookie-switch">
                            <input type="checkbox" id="marketing-cookies-checkbox">
                            <span class="cookie-slider"></span>
                        </label>
                    </div>
                    <p>These cookies may be set on our website as a result of our advertising partners' activities to create a profile of your interests.</p>
                </div>
            </div>
            <div class="cookie-settings-footer">
                <button id="save-settings-btn" class="cookie-btn cookie-btn-primary">Save settings</button>
            </div>
        </div>
    </div>
</div>


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
<script src="{{ asset('assets/js/gleif-integration.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/gleif-lookup-tool.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/gleif-validation-helper.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/renew-tab-fix.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/transfer-tab-fix.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/plan-selection.js') }}?v={{ time() }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://js.stripe.com/v3/"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
    // Handle registration form submission
    $('#registration-form').on('submit', function(e) {
        // Don't prevent default - let the form submit normally
        // Remove e.preventDefault();
        
        // Optional: Add loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.text();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        // The form will submit normally through POST
    });
    
    // If you want AJAX registration, use this instead:
    /*
    $('#registration-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var originalText = submitBtn.text();
        
        // Disable button and show loading
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Redirect to profile or show success message
                window.location.href = "{{ route('user.profile') }}";
            },
            error: function(xhr) {
                // Re-enable button
                submitBtn.prop('disabled', false).text(originalText);
                
                // Show validation errors
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    
                    // Clear previous errors
                    $('.text-danger').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    
                    // Display new errors
                    $.each(errors, function(field, messages) {
                        var input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<span class="text-danger">' + messages[0] + '</span>');
                    });
                    
                    // Scroll to first error
                    var firstError = $('.is-invalid').first();
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                } else {
                    alert('An error occurred during registration. Please try again.');
                }
            }
        });
    });
    */
});
</script>

<!-- <script>
    document.querySelector("form").addEventListener("submit", function(event) {
        var checkbox = document.getElementById("terms");
        if (!checkbox.checked) {
            alert("You must accept the Terms and Conditions before submitting the form.");
            event.preventDefault();
        }
    });
</script> -->


<script>
// Cookie Banner JavaScript с интеграцией Google Consent Mode
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const cookieBanner = document.getElementById('cookie-banner');
    const settingsBtn = document.getElementById('cookie-settings-btn');
    const acceptAllBtn = document.getElementById('accept-all-btn');
    const rejectAllBtn = document.getElementById('reject-all-btn');
    const savePreferencesBtn = document.getElementById('save-preferences-btn');
    const cookieSettingsModal = document.getElementById('cookie-settings-modal');
    const closeSettingsBtn = document.getElementById('close-settings-btn');
    const saveSettingsBtn = document.getElementById('save-settings-btn');
    const analyticsCheckbox = document.getElementById('analytics-cookies-checkbox');
    const marketingCheckbox = document.getElementById('marketing-cookies-checkbox');
    
    // Cookie expiration time (1 year)
    const cookieExpiration = 365;
    
    // Check if cookie consent is already given
    const consentCookie = getCookie('cookie_consent');
    
    if (!consentCookie) {
        // Show the cookie banner if no consent cookie exists
        cookieBanner.style.display = 'flex'; // Изменено с 'block' на 'flex' для центрирования
    } else {
        // Apply saved consent preferences
        applyConsentPreferences(JSON.parse(consentCookie));
    }
    
    // Event listeners
    settingsBtn.addEventListener('click', function() {
        cookieSettingsModal.style.display = 'flex';
        
        // Load saved preferences if they exist
        const savedPreferences = getCookie('cookie_consent');
        if (savedPreferences) {
            const preferences = JSON.parse(savedPreferences);
            analyticsCheckbox.checked = preferences.analytics || false;
            marketingCheckbox.checked = preferences.marketing || false;
        }
    });
    
    closeSettingsBtn.addEventListener('click', function() {
        cookieSettingsModal.style.display = 'none';
    });
    
    acceptAllBtn.addEventListener('click', function() {
        const preferences = {
            necessary: true,
            analytics: true,
            marketing: true
        };
        
        setConsentCookie(preferences);
        hideBanner();
    });
    
    rejectAllBtn.addEventListener('click', function() {
        const preferences = {
            necessary: true,
            analytics: false,
            marketing: false
        };
        
        setConsentCookie(preferences);
        hideBanner();
    });
    
    savePreferencesBtn.addEventListener('click', function() {
        cookieSettingsModal.style.display = 'flex';
    });
    
    saveSettingsBtn.addEventListener('click', function() {
        const preferences = {
            necessary: true,
            analytics: analyticsCheckbox.checked,
            marketing: marketingCheckbox.checked
        };
        
        setConsentCookie(preferences);
        cookieSettingsModal.style.display = 'none';
        hideBanner();
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === cookieSettingsModal) {
            cookieSettingsModal.style.display = 'none';
        }
    });
    
    // Helper functions
    function getCookie(name) {
        const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }
    
    function setCookie(name, value, days) {
        let expires = '';
        
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        
        document.cookie = name + '=' + value + expires + '; path=/; SameSite=Lax';
    }
    
    function setConsentCookie(preferences) {
        setCookie('cookie_consent', JSON.stringify(preferences), cookieExpiration);
        applyConsentPreferences(preferences);
    }
    
    function hideBanner() {
        cookieBanner.style.display = 'none';
    }
    
    function applyConsentPreferences(preferences) {
        // Используем gtag API для обновления согласий
        window.dataLayer = window.dataLayer || [];
        function gtag(){window.dataLayer.push(arguments);}
        
        // Обновляем настройки согласия
        gtag('consent', 'update', {
            'analytics_storage': preferences.analytics ? 'granted' : 'denied',
            'ad_storage': preferences.marketing ? 'granted' : 'denied',
            'functionality_storage': preferences.necessary ? 'granted' : 'denied',
            'personalization_storage': preferences.marketing ? 'granted' : 'denied',
            'ad_user_data': preferences.marketing ? 'granted' : 'denied',
            'ad_personalization': preferences.marketing ? 'granted' : 'denied'
        });
        
        // Также отправляем событие для отслеживания
        window.dataLayer.push({
            'event': 'consent_update',
            'consent_settings': preferences
        });
    }
});
</script>

</body>
</html>