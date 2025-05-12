// LEI Registration Form Validation and Auto-complete
document.addEventListener('DOMContentLoaded', function() {
    // Initialize form validation and auto-completion
    initRegistrationFormHelpers();
});

/**
 * Initialize registration form validation and auto-completion
 */
function initRegistrationFormHelpers() {
    // Initialize company name auto-completion
    initCompanyNameSearch();
    
    // Initialize registration ID validation
    initRegistrationIdValidation();
    
    // Initialize address toggle functionality
    initSameAddressToggle();
    
    // Initialize form validation
    initFormValidation();
}

/**
 * Initialize company name search and auto-completion
 */
function initCompanyNameSearch() {
    const companyNameInput = document.getElementById('legal_entity_name123');
    
    if (!companyNameInput) return;
    
    // Create autocomplete results container if it doesn't exist
    let autocompleteContainer = document.querySelector('.company-autocomplete-results');
    if (!autocompleteContainer) {
        autocompleteContainer = document.createElement('div');
        autocompleteContainer.className = 'company-autocomplete-results';
        companyNameInput.parentNode.appendChild(autocompleteContainer);
    }
    
    let debounceTimeout;
    
    companyNameInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Clear previous timeout
        clearTimeout(debounceTimeout);
        
        // Clear results if input is empty
        if (!query) {
            autocompleteContainer.innerHTML = '';
            autocompleteContainer.style.display = 'none';
            return;
        }
        
        // Show loading indicator
        autocompleteContainer.innerHTML = '<div class="autocomplete-loading"><i class="fas fa-spinner fa-spin"></i> Searching...</div>';
        autocompleteContainer.style.display = 'block';
        
        // Debounce API calls
        debounceTimeout = setTimeout(() => {
            // Only search if we have at least 3 characters
            if (query.length >= 3) {
                searchCompaniesByName(query)
                    .then(results => {
                        if (!results || !results.data || results.data.length === 0) {
                            autocompleteContainer.innerHTML = '<div class="no-results">No matching companies found</div>';
                            return;
                        }
                        
                        // Build results HTML
                        let resultsHtml = '';
                        
                        results.data.forEach(company => {
                            const entityName = company.attributes.entity.legalName.name;
                            const lei = company.id;
                            const country = company.attributes.entity.legalAddress.country;
                            
                            resultsHtml += `
                                <div class="autocomplete-item" data-lei="${lei}" data-name="${entityName}">
                                    <div class="item-name">${entityName}</div>
                                    <div class="item-meta">${country} | ${lei}</div>
                                </div>
                            `;
                        });
                        
                        autocompleteContainer.innerHTML = resultsHtml;
                        
                        // Add click handlers for autocomplete items
                        const autocompleteItems = autocompleteContainer.querySelectorAll('.autocomplete-item');
                        autocompleteItems.forEach(item => {
                            item.addEventListener('click', function() {
                                const lei = this.getAttribute('data-lei');
                                const name = this.getAttribute('data-name');
                                
                                // Fill input with selected company name
                                companyNameInput.value = name;
                                
                                // Create a hidden input for LEI if it doesn't exist
                                let leiInput = document.getElementById('hidden_lei');
                                if (!leiInput) {
                                    leiInput = document.createElement('input');
                                    leiInput.type = 'hidden';
                                    leiInput.id = 'hidden_lei';
                                    leiInput.name = 'lei';
                                    companyNameInput.parentNode.appendChild(leiInput);
                                }
                                
                                // Set LEI value
                                leiInput.value = lei;
                                
                                // Hide autocomplete
                                autocompleteContainer.style.display = 'none';
                                
                                // Fetch company details to auto-fill other fields
                                fetchLeiDetails(lei)
                                    .then(leiData => {
                                        if (leiData && leiData.data) {
                                            autoFillCompanyDetails(leiData);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error fetching company details:', error);
                                    });
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Company search error:', error);
                        autocompleteContainer.innerHTML = '<div class="search-error">Error searching companies</div>';
                    });
            } else {
                autocompleteContainer.innerHTML = '<div class="min-chars">Enter at least 3 characters</div>';
            }
        }, 300); // 300ms debounce
    });
    
    // Hide autocomplete when clicking outside
    document.addEventListener('click', function(e) {
        if (!companyNameInput.contains(e.target) && !autocompleteContainer.contains(e.target)) {
            autocompleteContainer.style.display = 'none';
        }
    });
}

/**
 * Initialize registration ID validation with GLEIF format checking
 */
function initRegistrationIdValidation() {
    const registrationIdInput = document.getElementById('registration_id');
    const countrySelect = document.getElementById('country');
    
    if (!registrationIdInput || !countrySelect) return;
    
    countrySelect.addEventListener('change', function() {
        // Clear any previous validation messages
        clearValidationError(registrationIdInput);
        
        // Add help text based on the selected country
        const country = this.value;
        updateRegistrationIdHelp(country);
    });
    
    registrationIdInput.addEventListener('blur', function() {
        const regId = this.value.trim();
        if (!regId) return;
        
        const country = countrySelect.value;
        
        // Validate registration ID format based on country
        validateRegistrationId(regId, country);
    });
}

/**
 * Update registration ID help text based on country
 * @param {string} country - Country code
 */
function updateRegistrationIdHelp(country) {
    const registrationIdInput = document.getElementById('registration_id');
    if (!registrationIdInput) return;
    
    let helpText = 'Enter the business registration number';
    
    // Get any existing help text element
    let helpElement = registrationIdInput.parentNode.querySelector('.form-text');
    
    // Create help text element if it doesn't exist
    if (!helpElement) {
        helpElement = document.createElement('div');
        helpElement.className = 'form-text';
        registrationIdInput.parentNode.appendChild(helpElement);
    }
    
    // Set country-specific help text
    switch(country) {
        case 'US':
            helpText = 'Enter the EIN (Employer Identification Number)';
            break;
        case 'GB':
            helpText = 'Enter the Companies House registration number';
            break;
        case 'DE':
            helpText = 'Enter the Handelsregister registration number';
            break;
        case 'FR':
            helpText = 'Enter the SIREN number';
            break;
        case 'IT':
            helpText = 'Enter the Registro Imprese number';
            break;
        case 'ES':
            helpText = 'Enter the Registro Mercantil number';
            break;
        case 'CN':
            helpText = 'Enter the Unified Social Credit Code';
            break;
        case 'JP':
            helpText = 'Enter the Corporate Number';
            break;
    }
    
    helpElement.textContent = helpText;
}

/**
 * Validate registration ID format based on country
 * @param {string} regId - Registration ID to validate
 * @param {string} country - Country code
 */
function validateRegistrationId(regId, country) {
    const registrationIdInput = document.getElementById('registration_id');
    if (!registrationIdInput) return;
    
    let isValid = true;
    let errorMessage = '';
    
    // Country-specific validation
    switch(country) {
        case 'US':
            // EIN format: XX-XXXXXXX
            if (!/^\d{2}-\d{7}$|^\d{9}$/.test(regId)) {
                isValid = false;
                errorMessage = 'EIN should be in format XX-XXXXXXX or XXXXXXXXX';
            }
            break;
        case 'GB':
            // UK Company Number format: 8 digits
            if (!/^\d{8}$/.test(regId)) {
                isValid = false;
                errorMessage = 'Company number should be 8 digits';
            }
            break;
        case 'DE':
            // German format: HRA/HRB XXXXX
            if (!/^HRA\s\d+$|^HRB\s\d+$/.test(regId)) {
                isValid = false;
                errorMessage = 'Format should be HRA XXXXX or HRB XXXXX';
            }
            break;
        // Add more country-specific validations as needed
    }
    
    if (!isValid) {
        showValidationError(registrationIdInput, errorMessage);
    } else {
        clearValidationError(registrationIdInput);
        
        // Check with GLEIF if the registration ID exists
        verifyRegistrationId(regId, country);
    }
}

/**
 * Verify registration ID with GLEIF API
 * @param {string} regId - Registration ID to verify
 * @param {string} country - Country code
 */
async function verifyRegistrationId(regId, country) {
    try {
        // Search for the company by registration ID
        const response = await fetch(`${GLEIF_API_BASE_URL}/lei-records?filter[entity.registeredAs]=${encodeURIComponent(regId)}&filter[entity.legalAddress.country]=${country}`);
        
        if (!response.ok) {
            throw new Error(`API error: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.data && result.data.length > 0) {
            // Company found - add a notification
            const registrationIdInput = document.getElementById('registration_id');
            const container = registrationIdInput.parentNode;
            
            // Create notification if it doesn't exist
            let notification = container.querySelector('.registration-match');
            if (!notification) {
                notification = document.createElement('div');
                notification.className = 'registration-match alert alert-info mt-2';
                container.appendChild(notification);
            }
            
            // Get company data
            const company = result.data[0];
            const entityName = company.attributes.entity.legalName.name;
            const lei = company.id;
            
            notification.innerHTML = `
                <p><strong>Existing registration found:</strong> ${entityName}</p>
                <p>This company already has an LEI: ${lei}</p>
                <button type="button" class="btn btn-sm btn-primary use-existing-btn">
                    Use Existing LEI
                </button>
            `;
            
            // Add click handler for the button
            const useExistingBtn = notification.querySelector('.use-existing-btn');
            useExistingBtn.addEventListener('click', function() {
                // Redirect to renew page with this LEI
                window.location.href = `/renew?lei=${lei}`;
            });
        }
    } catch (error) {
        console.error('Error verifying registration ID:', error);
    }
}

/**
 * Initialize same address toggle functionality
 */
function initSameAddressToggle() {
    const sameAddressToggle = document.getElementById('same_address');
    
    if (!sameAddressToggle) return;
    
    // Create headquarters address fields container
    const headQuartersContainer = document.createElement('div');
    headQuartersContainer.className = 'headquarters-address-container';
    headQuartersContainer.style.display = 'none'; // Hide by default
    
    // Insert container after the toggle row
    const toggleRow = sameAddressToggle.closest('.row');
    toggleRow.parentNode.insertBefore(headQuartersContainer, toggleRow.nextSibling);
    
    // Clone address fields for headquarters
    const addressFields = `
        <div class="form-section headquarters-section">
            <h4 class="form-section-title">Headquarters Address</h4>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hq_address">Office, building, street <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" id="hq_address" name="hq_address" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hq_city">City, state <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-city"></i>
                            <input type="text" id="hq_city" name="hq_city" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hq_zip_code">Post code <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-map-pin"></i>
                            <input type="text" id="hq_zip_code" name="hq_zip_code" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    headQuartersContainer.innerHTML = addressFields;
    
    // Add toggle event handler
    sameAddressToggle.addEventListener('change', function() {
        if (this.checked) {
            // If checked, addresses are identical, hide HQ fields
            headQuartersContainer.style.display = 'none';
            
            // Remove required attribute from HQ fields
            const hqFields = headQuartersContainer.querySelectorAll('input');
            hqFields.forEach(field => {
                field.removeAttribute('required');
            });
        } else {
            // If unchecked, show HQ fields
            headQuartersContainer.style.display = 'block';
            
            // Add required attribute to HQ fields
            const hqFields = headQuartersContainer.querySelectorAll('input');
            hqFields.forEach(field => {
                field.setAttribute('required', 'required');
            });
        }
    });
}

/**
 * Initialize form validation
 */
function initFormValidation() {
    const registerForm = document.getElementById('register-form');
    
    if (!registerForm) return;
    
    registerForm.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Get all required fields
        const requiredFields = registerForm.querySelectorAll('[required]');
        
        // Check each required field
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                showValidationError(field, 'This field is required');
            } else {
                clearValidationError(field);
            }
        });
        
        // Check email format
        const emailField = registerForm.querySelector('input[type="email"]');
        if (emailField && emailField.value.trim() && !isValidEmail(emailField.value.trim())) {
            isValid = false;
            showValidationError(emailField, 'Please enter a valid email address');
        }
        
        // Check phone format
        const phoneField = registerForm.querySelector('input[type="tel"]');
        if (phoneField && phoneField.value.trim() && !isValidPhone(phoneField.value.trim())) {
            isValid = false;
            showValidationError(phoneField, 'Please enter a valid phone number');
        }
        
        // Check terms checkbox
        const termsCheckbox = registerForm.querySelector('#terms');
        if (termsCheckbox && !termsCheckbox.checked) {
            isValid = false;
            showValidationError(termsCheckbox, 'You must accept the terms and conditions');
        }
        
        if (!isValid) {
            e.preventDefault();
            
            // Scroll to the first error
            const firstError = registerForm.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Add input event listeners to clear validation errors on input
    const formInputs = registerForm.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearValidationError(this);
        });
    });
}

/**
 * Validate email format
 * @param {string} email - Email to validate
 * @returns {boolean} - True if email is valid
 */
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

/**
 * Validate phone format
 * @param {string} phone - Phone to validate
 * @returns {boolean} - True if phone is valid
 */
function isValidPhone(phone) {
    // Basic phone validation - should be improved for international numbers
    return /^[+]?[0-9]{8,15}$/.test(phone.replace(/\s/g, ''));
}

/**
 * Auto-fill company details based on LEI data
 * @param {Object} leiData - LEI data from GLEIF API
 */
function autoFillCompanyDetails(leiData) {
    if (!leiData || !leiData.data || !leiData.data.attributes) return;
    
    const entity = leiData.data.attributes.entity;
    const legalAddress = entity.legalAddress;
    const hqAddress = entity.headquartersAddress;
    
    // Fill company information
    const countrySelect = document.getElementById('country');
    if (countrySelect && legalAddress.country) {
        // Find and select the matching country option
        for (let i = 0; i < countrySelect.options.length; i++) {
            if (countrySelect.options[i].value === legalAddress.country) {
                countrySelect.selectedIndex = i;
                
                // Trigger change event if using Select2
                if (window.jQuery && jQuery.fn.select2) {
                    jQuery(countrySelect).trigger('change');
                }
                
                break;
            }
        }
    }
    
    // Fill registration ID if available
    const regIdInput = document.getElementById('registration_id');
    if (regIdInput && entity.registeredAs) {
        regIdInput.value = entity.registeredAs;
    }
    
    // Fill address information
    const addressInput = document.getElementById('address');
    if (addressInput && legalAddress) {
        const addressLine = [
            legalAddress.addressLines ? legalAddress.addressLines[0] : '',
            legalAddress.addressNumber || ''
        ].filter(Boolean).join(' ');
        
        addressInput.value = addressLine || '';
    }
    
    const cityInput = document.getElementById('city');
    if (cityInput && legalAddress) {
        cityInput.value = legalAddress.city || '';
    }
    
    const zipInput = document.getElementById('zip_code');
    if (zipInput && legalAddress) {
        zipInput.value = legalAddress.postalCode || '';
    }
    
    // Handle headquarters address
    const sameAddressToggle = document.getElementById('same_address');
    if (sameAddressToggle && hqAddress) {
        // Check if headquarters address is different
        const isSameAddress = 
            (!hqAddress.addressLines || !hqAddress.addressLines[0]) ||
            (legalAddress.addressLines && hqAddress.addressLines && 
             legalAddress.addressLines[0] === hqAddress.addressLines[0] &&
             legalAddress.city === hqAddress.city &&
             legalAddress.postalCode === hqAddress.postalCode);
        
        // Set toggle based on address comparison
        sameAddressToggle.checked = isSameAddress;
        
        // Trigger change event to show/hide fields
        const changeEvent = new Event('change');
        sameAddressToggle.dispatchEvent(changeEvent);
        
        // Fill headquarters address fields if different
        if (!isSameAddress) {
            const hqAddressInput = document.getElementById('hq_address');
            if (hqAddressInput) {
                const hqAddressLine = [
                    hqAddress.addressLines ? hqAddress.addressLines[0] : '',
                    hqAddress.addressNumber || ''
                ].filter(Boolean).join(' ');
                
                hqAddressInput.value = hqAddressLine || '';
            }
            
            const hqCityInput = document.getElementById('hq_city');
            if (hqCityInput) {
                hqCityInput.value = hqAddress.city || '';
            }
            
            const hqZipInput = document.getElementById('hq_zip_code');
            if (hqZipInput) {
                hqZipInput.value = hqAddress.postalCode || '';
            }
        }
    }
}

// Add additional CSS for validation
const validationStyle = document.createElement('style');
validationStyle.textContent = `
    /* Validation styling */
    .form-group {
        position: relative;
        margin-bottom: 20px;
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
    }
    
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }
    
    .form-text {
        display: block;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #6c757d;
    }
    
    /* Autocomplete styling */
    .company-autocomplete-results {
        position: absolute;
        z-index: 1000;
        width: 100%;
        max-height: 300px;
        overflow-y: auto;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        display: none;
    }
    
    .autocomplete-loading, .no-results, .min-chars, .search-error {
        padding: 10px;
        text-align: center;
        color: #666;
    }
    
    .search-error {
        color: #dc3545;
    }
    
    /* Registration match notification */
    .registration-match {
        margin-top: 10px;
        padding: 10px;
        border-radius: 4px;
        background-color: #e8f4fd;
        border: 1px solid #b8daff;
    }
    
    .use-existing-btn {
        margin-top: 5px;
    }
    
    /* Headquarters section styling */
    .headquarters-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px dashed #ddd;
    }
`;

document.head.appendChild(validationStyle);