$(document).ready(function() {
    // Инициализация Select2 для выбора страны
    $('.select2').select2({
        width: '100%'
    });

    // Обработка выбора плана
    $('.plan-card').click(function() {
        $('.plan-card').removeClass('selected');
        $(this).addClass('selected');
        const plan = $(this).data('plan');
        $('input[name="selected_plan"]').val(plan);
    });

    // Обработка переключения табов
    $('.tab-custom').click(function() {
        const tab = $(this).data('tab');
        $('.tab-custom').removeClass('active');
        $(this).addClass('active');
        $('.content-custom').removeClass('active');
        $(`#${tab}`).addClass('active');
    });

    // Обработка загрузки файла
    let uploadedFile = null;
    
    // Инициализация загрузки файла через клик
    $('.upload-area').on('click', function() {
        $('#document').click();
    });

    // Обработка drag & drop
    $('.upload-area').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    $('.upload-area').on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });

    $('.upload-area').on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            handleFileUpload(files[0]);
        }
    });

    // Обработка выбора файла через input
    $('#document').on('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileUpload(e.target.files[0]);
        }
    });

    function handleFileUpload(file) {
        uploadedFile = file;
        $('.upload-text').text(file.name);
    }

    // Обработка отправки формы регистрации
    $('#register-form').on('submit', function(e) {
        e.preventDefault();

        // Проверка выбора плана
        const selectedPlan = $('.plan-card.selected').data('plan');
        if (!selectedPlan) {
            showError('Please select a plan');
            return;
        }

        // Проверка согласия с условиями
        if (!$('#terms').is(':checked')) {
            showError('Please accept the Terms & Conditions');
            return;
        }

        // Создание FormData
        const formData = new FormData(this);
        formData.append('selected_plan', selectedPlan);

        // Правильная обработка булевых значений чекбоксов
        formData.set('same_address', $('input[name="same_address"]').is(':checked') ? '1' : '0');
        formData.set('private_controlled', $('input[name="private_controlled"]').is(':checked') ? '1' : '0');

        // Добавление файла, если он был загружен
        if (uploadedFile) {
            formData.append('document', uploadedFile);
        }

        // Отправка формы
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status === 'success') {
                    showSuccess(response.message);
                    setTimeout(() => {
                        window.location.href = '/payment/' + response.contact_id;
                    }, 1500);
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr, status, error) {
                hideLoader();
                console.error('Form submission error details:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    responseJSON: xhr.responseJSON
                });
                
                let errorMessage = 'An error occurred while submitting your registration.';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    } else if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                }
                
                showError(errorMessage);
            }
        });
    });

    // Обработка формы обновления
    $('#renew-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status === 'success') {
                    showSuccess(response.message);
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                hideLoader();
                showError('An error occurred while processing your renewal request.');
            }
        });
    });

    // Вспомогательные функции
    function showLoader() {
        $('.submit-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    }

    function hideLoader() {
        $('.submit-btn').prop('disabled', false).text('CONFIRM & CONTINUE');
    }

    function showSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            timer: 2000,
            showConfirmButton: false
        });
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message || 'An unexpected error occurred',
            customClass: {
                popup: 'my-swal-popup' // Add custom class if needed
            },
            buttonsStyling: true
        });
    }

    // Валидация формы
    function validateForm() {
        let isValid = true;
        const requiredFields = $('#register-form [required]');
        
        requiredFields.each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        return isValid;
    }

    // Обработка изменения полей формы
    $('#register-form input, #register-form select').on('change', function() {
        $(this).removeClass('is-invalid');
    });
});