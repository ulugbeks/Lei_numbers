// GLEIF API Integration for LEI Register Form
// This script connects to the GLEIF API for LEI validation, search, and data retrieval

// GLEIF API Base URL
const GLEIF_API_BASE_URL = 'https://api.gleif.org/api/v1';

// Function to initialize all GLEIF-related functionality
document.addEventListener('DOMContentLoaded', function() {
    initGleifIntegration();
});

function initGleifIntegration() {
    // Initialize LEI search functionality
    initLeiSearch();
    
    // Initialize LEI validation
    initLeiValidation();
    
    // Initialize company auto-complete
    initCompanyAutocomplete();
    
    // Initialize LEI transfer verification
    initTransferValidation();
}

/**
 * Initialize LEI search functionality for the renewal form
 */
function initLeiSearch() {
    const leiSearchInput = document.getElementById('lei');
    const renewForm = document.getElementById('renew-form');
    const searchBtn = renewForm.querySelector('.search-btn');
    
    if (!leiSearchInput || !renewForm || !searchBtn) return;
    
    searchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const searchValue = leiSearchInput.value.trim();
        if (!searchValue) return;
        
        // Show loading state
        searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        searchBtn.disabled = true;
        
        // Determine if input is an LEI or company name
        const isLei = /^[A-Z0-9]{20}$/.test(searchValue);
        
        if (isLei) {
            // Search by LEI code
            fetchLeiDetails(searchValue)
                .then(displayLeiDetails)
                .catch(handleApiError)
                .finally(() => {
                    // Reset button state
                    searchBtn.innerHTML = '<i class="fas fa-search"></i> Search';
                    searchBtn.disabled = false;
                });
        } else {
            // Search by company name
            searchCompaniesByName(searchValue)
                .then(displayCompanySearchResults)
                .catch(handleApiError)
                .finally(() => {
                    // Reset button state
                    searchBtn.innerHTML = '<i class="fas fa-search"></i> Search';
                    searchBtn.disabled = false;
                });
        }
    });
}

/**
 * Initialize LEI validation for the transfer form
 */
function initLeiValidation() {
    const transferLeiInput = document.getElementById('transfer-lei');
    const transferForm = document.getElementById('transfer-form');
    
    if (!transferLeiInput || !transferForm) return;
    
    transferLeiInput.addEventListener('blur', function() {
        const lei = transferLeiInput.value.trim();
        if (lei && !isValidLeiFormat(lei)) {
            showValidationError(transferLeiInput, 'Invalid LEI format. LEI must be 20 characters.');
        } else {
            clearValidationError(transferLeiInput);
        }
    });
    
    transferForm.addEventListener('submit', function(e) {
        const lei = transferLeiInput.value.trim();
        
        if (!isValidLeiFormat(lei)) {
            e.preventDefault();
            showValidationError(transferLeiInput, 'Invalid LEI format. LEI must be 20 characters.');
            return false;
        }
        
        // Verify LEI exists in GLEIF database before submission
        e.preventDefault();
        
        // Show loading state
        const submitBtn = transferForm.querySelector('.submit-btn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
        submitBtn.disabled = true;
        
        validateLeiExists(lei)
            .then(isValid => {
                if (isValid) {
                    transferForm.submit();
                } else {
                    showValidationError(transferLeiInput, 'LEI not found in the GLEIF database.');
                }
            })
            .catch(error => {
                showValidationError(transferLeiInput, 'Error validating LEI. Please try again.');
                console.error('LEI validation error:', error);
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = 'CONFIRM & CONTINUE';
                submitBtn.disabled = false;
            });
    });
}

/**
 * Initialize company name autocomplete with GLEIF data
 */
function initCompanyAutocomplete() {
    const companyNameInput = document.getElementById('legal_entity_name');
    
    if (!companyNameInput) return;
    
    // Create autocomplete results container
    const autocompleteContainer = document.createElement('div');
    autocompleteContainer.className = 'autocomplete-results';
    companyNameInput.parentNode.appendChild(autocompleteContainer);
    
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
        
        // Debounce API calls
        debounceTimeout = setTimeout(() => {
            // Only search if we have at least 3 characters
            if (query.length >= 3) {
                searchCompaniesByName(query)
                    .then(results => {
                        displayAutocompleteResults(results, autocompleteContainer, companyNameInput);
                    })
                    .catch(error => {
                        console.error('Company search error:', error);
                        autocompleteContainer.innerHTML = '';
                        autocompleteContainer.style.display = 'none';
                    });
            } else {
                autocompleteContainer.innerHTML = '';
                autocompleteContainer.style.display = 'none';
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
 * Initialize LEI transfer form validation
 */
function initTransferValidation() {
    const transferForm = document.getElementById('transfer-form');
    const transferLeiInput = document.getElementById('transfer-lei');
    
    if (!transferForm || !transferLeiInput) return;
    
    transferForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const lei = transferLeiInput.value.trim();
        
        if (!lei) {
            showValidationError(transferLeiInput, 'Please enter an LEI code');
            return;
        }
        
        if (!isValidLeiFormat(lei)) {
            showValidationError(transferLeiInput, 'Invalid LEI format');
            return;
        }
        
        const submitBtn = transferForm.querySelector('.submit-btn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;
        
        try {
            const leiData = await fetchLeiDetails(lei);
            
            if (!leiData) {
                showValidationError(transferLeiInput, 'LEI not found in GLEIF database');
                submitBtn.innerHTML = 'CONFIRM & CONTINUE';
                submitBtn.disabled = false;
                return;
            }
            
            // Check if LEI is eligible for transfer
            if (leiData.data.attributes.entity.status !== 'ACTIVE') {
                showValidationError(transferLeiInput, 'LEI must be in ACTIVE status to transfer');
                submitBtn.innerHTML = 'CONFIRM & CONTINUE';
                submitBtn.disabled = false;
                return;
            }
            
            // If all checks pass, proceed with the transfer
            transferForm.submit();
            
        } catch (error) {
            console.error('Error during transfer validation:', error);
            showValidationError(transferLeiInput, 'Error verifying LEI. Please try again.');
            submitBtn.innerHTML = 'CONFIRM & CONTINUE';
            submitBtn.disabled = false;
        }
    });
}

/**
 * Fetch LEI details from GLEIF API
 * @param {string} lei - LEI code to fetch
 * @returns {Promise} - Promise resolving to LEI data
 */
async function fetchLeiDetails(lei) {
    try {
        const response = await fetch(`${GLEIF_API_BASE_URL}/lei-records/${lei}`);
        
        if (!response.ok) {
            if (response.status === 404) {
                return null; // LEI not found
            }
            throw new Error(`API error: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error fetching LEI details:', error);
        throw error;
    }
}

/**
 * Search companies by name using GLEIF API
 * @param {string} query - Company name to search for
 * @returns {Promise} - Promise resolving to company search results
 */
async function searchCompaniesByName(query) {
    try {
        const response = await fetch(`${GLEIF_API_BASE_URL}/lei-records?filter[entity.legalName]=${encodeURIComponent(query)}&page[size]=10`);
        
        if (!response.ok) {
            throw new Error(`API error: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error searching companies:', error);
        throw error;
    }
}

/**
 * Validate that an LEI exists in the GLEIF database
 * @param {string} lei - LEI code to validate
 * @returns {Promise<boolean>} - Promise resolving to true if LEI exists
 */
async function validateLeiExists(lei) {
    try {
        const leiData = await fetchLeiDetails(lei);
        return !!leiData;
    } catch (error) {
        console.error('Error validating LEI:', error);
        return false;
    }
}

/**
 * Display LEI details in the form
 * @param {Object} leiData - LEI data from GLEIF API
 */
function displayLeiDetails(leiData) {
    if (!leiData || !leiData.data) {
        // Create a results container if not existing
        let resultsContainer = document.querySelector('.lei-search-results');
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.className = 'lei-search-results alert alert-danger';
            const renewForm = document.getElementById('renew-form');
            renewForm.appendChild(resultsContainer);
        }
        
        resultsContainer.innerHTML = 'LEI not found. Please check the LEI code and try again.';
        return;
    }
    
    const entity = leiData.data.attributes.entity;
    
    // Create or get results container
    let resultsContainer = document.querySelector('.lei-search-results');
    if (!resultsContainer) {
        resultsContainer = document.createElement('div');
        resultsContainer.className = 'lei-search-results';
        const renewForm = document.getElementById('renew-form');
        renewForm.appendChild(resultsContainer);
    }
    
    // Build LEI details HTML
    const expirationDate = new Date(leiData.data.attributes.registration.nextRenewalDate);
    const formattedDate = expirationDate.toLocaleDateString();
    
    let statusClass = 'alert-success';
    if (leiData.data.attributes.registration.status !== 'ISSUED') {
        statusClass = 'alert-warning';
    }
    
    resultsContainer.innerHTML = `
        <div class="lei-details">
            <div class="alert ${statusClass}">
                <h4>LEI: ${leiData.data.id}</h4>
                <p><strong>Entity Name:</strong> ${entity.legalName.name}</p>
                <p><strong>Status:</strong> ${leiData.data.attributes.registration.status}</p>
                <p><strong>Expiration Date:</strong> ${formattedDate}</p>
                <p><strong>Registration Authority:</strong> ${entity.registeredAs || 'N/A'}</p>
            </div>
            
            <div class="renewal-options">
                <h4>Select Renewal Period</h4>
                <div class="plans-container">
                    <div class="plan-card" data-plan="1-year">
                        <div class="plan-header">
                            <h4 class="plan-title">1 year</h4>
                        </div>
                        <div class="plan-price">
                            <span class="currency">€</span>75
                            <span class="period">/ year</span>
                        </div>
                        <div class="plan-total">Total €75</div>
                        <button class="plan-select-btn" data-lei="${leiData.data.id}" data-period="1">Select Plan</button>
                    </div>
                    
                    <div class="plan-card selected" data-plan="3-years">
                        <div class="popular-badge">Most popular</div>
                        <div class="plan-header">
                            <h4 class="plan-title">3 years</h4>
                        </div>
                        <div class="plan-price">
                            <span class="currency">€</span>55
                            <span class="period">/ year</span>
                        </div>
                        <div class="plan-total">Total €165</div>
                        <button class="plan-select-btn" data-lei="${leiData.data.id}" data-period="3">Select Plan</button>
                    </div>
                    
                    <div class="plan-card" data-plan="5-years">
                        <div class="plan-header">
                            <h4 class="plan-title">5 years</h4>
                        </div>
                        <div class="plan-price">
                            <span class="currency">€</span>50
                            <span class="period">/ year</span>
                        </div>
                        <div class="plan-total">Total €250</div>
                        <button class="plan-select-btn" data-lei="${leiData.data.id}" data-period="5">Select Plan</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add click handlers for plan selection buttons
    const planButtons = resultsContainer.querySelectorAll('.plan-select-btn');
    planButtons.forEach(button => {
        button.addEventListener('click', function() {
            const lei = this.getAttribute('data-lei');
            const period = this.getAttribute('data-period');
            
            // Create hidden form inputs to pass selected LEI and period
            const leiInput = document.createElement('input');
            leiInput.type = 'hidden';
            leiInput.name = 'selected_lei';
            leiInput.value = lei;
            
            const periodInput = document.createElement('input');
            periodInput.type = 'hidden';
            periodInput.name = 'renewal_period';
            periodInput.value = period;
            
            const renewForm = document.getElementById('renew-form');
            renewForm.appendChild(leiInput);
            renewForm.appendChild(periodInput);
            
            // Submit the form
            renewForm.submit();
        });
    });
}

/**
 * Display company search results
 * @param {Object} results - Search results from GLEIF API
 */
function displayCompanySearchResults(results) {
    if (!results || !results.data || results.data.length === 0) {
        // Create a results container if not existing
        let resultsContainer = document.querySelector('.lei-search-results');
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.className = 'lei-search-results alert alert-info';
            const renewForm = document.getElementById('renew-form');
            renewForm.appendChild(resultsContainer);
        }
        
        resultsContainer.innerHTML = 'No companies found matching your search.';
        return;
    }
    
    // Create or get results container
    let resultsContainer = document.querySelector('.lei-search-results');
    if (!resultsContainer) {
        resultsContainer = document.createElement('div');
        resultsContainer.className = 'lei-search-results';
        const renewForm = document.getElementById('renew-form');
        renewForm.appendChild(resultsContainer);
    }
    
    // Build company results HTML
    let resultsHtml = `
        <div class="company-search-results">
            <h4>Search Results</h4>
            <p>Please select a company to renew its LEI:</p>
            <div class="results-list">
    `;
    
    results.data.forEach(company => {
        const entityName = company.attributes.entity.legalName.name;
        const lei = company.id;
        const status = company.attributes.registration.status;
        const country = company.attributes.entity.legalAddress.country;
        
        let statusClass = 'status-active';
        if (status !== 'ISSUED') {
            statusClass = 'status-inactive';
        }
        
        resultsHtml += `
            <div class="result-item" data-lei="${lei}">
                <div class="result-entity">${entityName}</div>
                <div class="result-details">
                    <span class="result-lei">${lei}</span>
                    <span class="result-country">${country}</span>
                    <span class="result-status ${statusClass}">${status}</span>
                </div>
                <button class="select-company-btn" data-lei="${lei}">Select</button>
            </div>
        `;
    });
    
    resultsHtml += `
            </div>
        </div>
    `;
    
    resultsContainer.innerHTML = resultsHtml;
    
    // Add click handlers for company selection buttons
    const selectButtons = resultsContainer.querySelectorAll('.select-company-btn');
    selectButtons.forEach(button => {
        button.addEventListener('click', function() {
            const lei = this.getAttribute('data-lei');
            
            // Fetch and display full LEI details
            fetchLeiDetails(lei)
                .then(displayLeiDetails)
                .catch(error => {
                    console.error('Error fetching LEI details:', error);
                    resultsContainer.innerHTML = 'Error fetching company details. Please try again.';
                });
        });
    });
}

/**
 * Display autocomplete results
 * @param {Object} results - Search results from GLEIF API
 * @param {HTMLElement} container - Container to display results in
 * @param {HTMLElement} input - Input field for company name
 */
function displayAutocompleteResults(results, container, input) {
    if (!results || !results.data || results.data.length === 0) {
        container.innerHTML = '';
        container.style.display = 'none';
        return;
    }
    
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
    
    container.innerHTML = resultsHtml;
    container.style.display = 'block';
    
    // Add click handlers for autocomplete items
    const autocompleteItems = container.querySelectorAll('.autocomplete-item');
    autocompleteItems.forEach(item => {
        item.addEventListener('click', function() {
            const lei = this.getAttribute('data-lei');
            const name = this.getAttribute('data-name');
            
            // Fill input with selected company name
            input.value = name;
            
            // Create a hidden input for LEI if it doesn't exist
            let leiInput = document.getElementById('hidden_lei');
            if (!leiInput) {
                leiInput = document.createElement('input');
                leiInput.type = 'hidden';
                leiInput.id = 'hidden_lei';
                leiInput.name = 'lei';
                input.parentNode.appendChild(leiInput);
            }
            
            // Set LEI value
            leiInput.value = lei;
            
            // Hide autocomplete
            container.style.display = 'none';
            
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
}

/**
 * Auto-fill company details in registration form
 * @param {Object} leiData - LEI data from GLEIF API
 */
function autoFillCompanyDetails(leiData) {
    if (!leiData || !leiData.data || !leiData.data.attributes) return;
    
    const entity = leiData.data.attributes.entity;
    const address = entity.legalAddress;
    
    // Fill company information
    const countrySelect = document.getElementById('country');
    if (countrySelect && address.country) {
        // Find and select the matching country option
        for (let i = 0; i < countrySelect.options.length; i++) {
            if (countrySelect.options[i].value === address.country) {
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
    if (addressInput) {
        const addressLine = [
            address.addressLines ? address.addressLines[0] : '',
            address.addressNumber || ''
        ].filter(Boolean).join(' ');
        
        addressInput.value = addressLine || '';
    }
    
    const cityInput = document.getElementById('city');
    if (cityInput) {
        cityInput.value = address.city || '';
    }
    
    const zipInput = document.getElementById('zip_code');
    if (zipInput) {
        zipInput.value = address.postalCode || '';
    }
}

/**
 * Handle API errors gracefully
 * @param {Error} error - Error object
 */
function handleApiError(error) {
    console.error('GLEIF API Error:', error);
    
    // Create error notification
    const errorDiv = document.createElement('div');
    errorDiv.className = 'alert alert-danger';
    errorDiv.innerHTML = 'An error occurred while fetching data. Please try again later.';
    
    // Find an appropriate container to show the error
    const container = document.querySelector('.tab-content.active .step-section.active') || 
                     document.querySelector('.tab-content.active') || 
                     document.querySelector('.pricing-item-wrap');
    
    if (container) {
        // Insert error at the beginning of the container
        container.insertBefore(errorDiv, container.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }
}

/**
 * Validate LEI format (20 alphanumeric characters)
 * @param {string} lei - LEI to validate
 * @returns {boolean} - True if format is valid
 */
function isValidLeiFormat(lei) {
    return /^[A-Z0-9]{20}$/.test(lei);
}

/**
 * Show validation error on an input
 * @param {HTMLElement} input - Input element
 * @param {string} message - Error message
 */
function showValidationError(input, message) {
    // Remove any existing error
    clearValidationError(input);
    
    // Add error class to input
    input.classList.add('is-invalid');
    
    // Create error message element
    const errorElement = document.createElement('div');
    errorElement.className = 'invalid-feedback';
    errorElement.innerText = message;
    
    // Insert error after input
    input.parentNode.appendChild(errorElement);
}

/**
 * Clear validation error from an input
 * @param {HTMLElement} input - Input element
 */
function clearValidationError(input) {
    input.classList.remove('is-invalid');
    
    // Remove any existing error messages
    const existingError = input.parentNode.querySelector('.invalid-feedback');
    if (existingError) {
        existingError.remove();
    }
}

// Add CSS for GLEIF integration components
const style = document.createElement('style');
style.textContent = `
    /* Autocomplete styling */
    .autocomplete-results {
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
    
    .autocomplete-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }
    
    .autocomplete-item:hover {
        background-color: #f5f5f5;
    }
    
    .autocomplete-item .item-name {
        font-weight: bold;
    }
    
    .autocomplete-item .item-meta {
        font-size: 0.8em;
        color: #666;
    }
    
    /* Search results styling */
    .lei-search-results {
        margin-top: 20px;
    }
    
    .company-search-results .results-list {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .result-item {
        padding: 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .result-item:hover {
        background-color: #f9f9f9;
    }
    
    .result-entity {
        font-weight: bold;
        flex: 2;
    }
    
    .result-details {
        flex: 3;
        display: flex;
        gap: 10px;
    }
    
    .result-lei {
        color: #666;
        font-family: monospace;
    }
    
    .result-country {
        background: #e9f5ff;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 0.8em;
    }
    
    .result-status {
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 0.8em;
    }
    
    .status-active {
        background: #e3fcef;
        color: #0a906e;
    }
    
    .status-inactive {
        background: #fff4e5;
        color: #c76700;
    }
    
    .select-company-btn {
        padding: 5px 15px;
        background: #4a6cf7;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .select-company-btn:hover {
        background: #3655d7;
    }
    
    /* LEI details styling */
    .lei-details {
        margin-top: 20px;
    }
    
    .lei-details h4 {
        margin-bottom: 15px;
    }
`;

document.head.appendChild(style);




// Add this code to the end of your gleif-integration.js file or directly in a script tag in your HTML

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking renew and transfer search functionality');
    
    // Fix for Renew tab search
    const renewForm = document.getElementById('renew-form');
    const renewSearchBtn = renewForm ? renewForm.querySelector('.search-btn') : null;
    const renewSearchInput = renewForm ? document.getElementById('lei') : null;
    
    if (renewForm && renewSearchBtn && renewSearchInput) {
        console.log('Renew form elements found, attaching event listener');
        
        renewSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const searchValue = renewSearchInput.value.trim();
            if (!searchValue) {
                alert('Please enter an LEI code or company name');
                return;
            }
            
            console.log('Searching for:', searchValue);
            
            // Show loading state
            renewSearchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            renewSearchBtn.disabled = true;
            
            // Determine if input is an LEI or company name
            const isLei = /^[A-Z0-9]{20}$/.test(searchValue);
            
            if (isLei) {
                // Search by LEI code
                fetch(`https://api.gleif.org/api/v1/lei-records/${searchValue}`)
                    .then(response => {
                        if (!response.ok) {
                            if (response.status === 404) {
                                throw new Error('LEI not found');
                            }
                            throw new Error(`API error: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        displayLeiDetails(data);
                    })
                    .catch(error => {
                        console.error('Error fetching LEI details:', error);
                        
                        // Create a results container if not existing
                        let resultsContainer = document.querySelector('.lei-search-results');
                        if (!resultsContainer) {
                            resultsContainer = document.createElement('div');
                            resultsContainer.className = 'lei-search-results alert alert-danger';
                            renewForm.appendChild(resultsContainer);
                        }
                        
                        resultsContainer.style.display = 'block';
                        resultsContainer.innerHTML = `Error: ${error.message || 'An error occurred while searching. Please try again.'}`;
                    })
                    .finally(() => {
                        // Reset button state
                        renewSearchBtn.innerHTML = '<i class="fas fa-search"></i> Search';
                        renewSearchBtn.disabled = false;
                    });
            } else {
                // Search by company name
                fetch(`https://api.gleif.org/api/v1/lei-records?filter[entity.legalName]=${encodeURIComponent(searchValue)}&page[size]=10`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`API error: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(results => {
                        displayCompanySearchResults(results);
                    })
                    .catch(error => {
                        console.error('Error searching companies:', error);
                        
                        // Create a results container if not existing
                        let resultsContainer = document.querySelector('.lei-search-results');
                        if (!resultsContainer) {
                            resultsContainer = document.createElement('div');
                            resultsContainer.className = 'lei-search-results alert alert-danger';
                            renewForm.appendChild(resultsContainer);
                        }
                        
                        resultsContainer.style.display = 'block';
                        resultsContainer.innerHTML = `Error: ${error.message || 'An error occurred while searching. Please try again.'}`;
                    })
                    .finally(() => {
                        // Reset button state
                        renewSearchBtn.innerHTML = '<i class="fas fa-search"></i> Search';
                        renewSearchBtn.disabled = false;
                    });
            }
        });
    } else {
        console.error('Renew form elements not found:', {
            form: !!renewForm,
            button: !!renewSearchBtn,
            input: !!renewSearchInput
        });
    }
    
    // Fix for Transfer tab LEI verification
    const transferForm = document.getElementById('transfer-form');
    const transferLeiInput = transferForm ? document.getElementById('transfer-lei') : null;
    const verifyLeiBtn = transferForm ? transferForm.querySelector('.verify-lei-btn') : null;
    
    if (transferForm && transferLeiInput && verifyLeiBtn) {
        console.log('Transfer form elements found, attaching event listener');
        
        verifyLeiBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const lei = transferLeiInput.value.trim();
            
            if (!lei) {
                alert('Please enter an LEI code');
                return;
            }
            
            if (!/^[A-Z0-9]{20}$/.test(lei)) {
                alert('Invalid LEI format. LEI must be 20 characters.');
                return;
            }
            
            console.log('Verifying LEI:', lei);
            
            // Show loading state
            verifyLeiBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
            verifyLeiBtn.disabled = true;
            
            // Verify LEI exists in GLEIF database
            fetch(`https://api.gleif.org/api/v1/lei-records/${lei}`)
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 404) {
                            throw new Error('LEI not found in the GLEIF database');
                        }
                        throw new Error(`API error: ${response.status}`);
                    }
                    return response.json();
                })
                .then(leiData => {
                    console.log('LEI verification successful:', leiData);
                    
                    // Display verification result
                    const verificationResultsDiv = transferForm.querySelector('.lei-verification-results');
                    if (verificationResultsDiv) {
                        const entity = leiData.data.attributes.entity;
                        
                        verificationResultsDiv.style.display = 'block';
                        verificationResultsDiv.innerHTML = `
                            <div class="alert alert-success">
                                <h4>LEI Verified Successfully</h4>
                                <p><strong>Entity:</strong> ${entity.legalName.name}</p>
                                <p><strong>Status:</strong> ${leiData.data.attributes.registration.status}</p>
                                <p><strong>Country:</strong> ${entity.legalAddress.country}</p>
                            </div>
                        `;
                        
                        // Show the transfer details section
                        const transferDetailsDiv = transferForm.querySelector('.transfer-details');
                        if (transferDetailsDiv) {
                            transferDetailsDiv.style.display = 'block';
                        }
                    }
                })
                .catch(error => {
                    console.error('LEI verification error:', error);
                    
                    // Display error message
                    const verificationResultsDiv = transferForm.querySelector('.lei-verification-results');
                    if (verificationResultsDiv) {
                        verificationResultsDiv.style.display = 'block';
                        verificationResultsDiv.innerHTML = `
                            <div class="alert alert-danger">
                                <h4>Verification Failed</h4>
                                <p>${error.message || 'An error occurred during verification. Please try again.'}</p>
                            </div>
                        `;
                    }
                })
                .finally(() => {
                    // Reset button state
                    verifyLeiBtn.innerHTML = '<i class="fas fa-check"></i> Verify LEI';
                    verifyLeiBtn.disabled = false;
                });
        });
    } else {
        console.error('Transfer form elements not found:', {
            form: !!transferForm,
            input: !!transferLeiInput,
            button: !!verifyLeiBtn
        });
    }
});