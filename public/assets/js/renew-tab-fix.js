// Add this code to a new file: renew-tab-fix.js

document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing Renew tab fix...');
    
    // Function to initialize the renew search
    function initRenewSearch() {
        const renewForm = document.getElementById('renew-form');
        const leiInput = document.getElementById('lei');
        const searchBtn = renewForm ? renewForm.querySelector('.search-btn') : null;
        
        if (!renewForm || !leiInput || !searchBtn) {
            console.error('Renew form elements not found:', {
                form: !!renewForm, 
                input: !!leiInput, 
                button: !!searchBtn
            });
            return;
        }
        
        console.log('Renew form elements found, attaching event listener');
        
        // Display LEI details function
        function displayLeiDetails(leiData) {
            console.log('Displaying LEI details:', leiData);
            
            if (!leiData || !leiData.data) {
                // Create a results container if not existing
                let resultsContainer = renewForm.querySelector('.lei-search-results');
                if (!resultsContainer) {
                    resultsContainer = document.createElement('div');
                    resultsContainer.className = 'lei-search-results alert alert-danger';
                    renewForm.appendChild(resultsContainer);
                }
                
                resultsContainer.style.display = 'block';
                resultsContainer.innerHTML = 'LEI not found. Please check the LEI code and try again.';
                return;
            }
            
            const entity = leiData.data.attributes.entity;
            
            // Create or get results container
            let resultsContainer = renewForm.querySelector('.lei-search-results');
            if (!resultsContainer) {
                resultsContainer = document.createElement('div');
                resultsContainer.className = 'lei-search-results';
                renewForm.appendChild(resultsContainer);
            }
            
            resultsContainer.style.display = 'block';
            
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
                    
                    renewForm.appendChild(leiInput);
                    renewForm.appendChild(periodInput);
                    
                    // Submit the form
                    renewForm.submit();
                });
            });
        }
        
        // Display company search results function
        function displayCompanySearchResults(results) {
            console.log('Displaying company search results:', results);
            
            if (!results || !results.data || results.data.length === 0) {
                // Create a results container if not existing
                let resultsContainer = renewForm.querySelector('.lei-search-results');
                if (!resultsContainer) {
                    resultsContainer = document.createElement('div');
                    resultsContainer.className = 'lei-search-results alert alert-info';
                    renewForm.appendChild(resultsContainer);
                }
                
                resultsContainer.style.display = 'block';
                resultsContainer.innerHTML = 'No companies found matching your search.';
                return;
            }
            
            // Create or get results container
            let resultsContainer = renewForm.querySelector('.lei-search-results');
            if (!resultsContainer) {
                resultsContainer = document.createElement('div');
                resultsContainer.className = 'lei-search-results';
                renewForm.appendChild(resultsContainer);
            }
            
            resultsContainer.style.display = 'block';
            
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
                    
                    // Show loading state
                    resultsContainer.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading details...</div>';
                    
                    // Fetch and display full LEI details
                    fetch(`https://api.gleif.org/api/v1/lei-records/${lei}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`API error: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(leiData => {
                            displayLeiDetails(leiData);
                        })
                        .catch(error => {
                            console.error('Error fetching LEI details:', error);
                            resultsContainer.innerHTML = 'Error fetching company details. Please try again.';
                        });
                });
            });
        }
        
        // Add search event listener
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const searchValue = leiInput.value.trim();
            if (!searchValue) {
                alert('Please enter an LEI code or company name');
                return;
            }
            
            console.log('Renew tab searching for:', searchValue);
            
            // Show loading state
            searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            searchBtn.disabled = true;
            
            // Clear previous results
            const resultsContainer = renewForm.querySelector('.lei-search-results');
            if (resultsContainer) {
                resultsContainer.innerHTML = '';
                resultsContainer.style.display = 'none';
            }
            
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
                        
                        // Show error message
                        let resultsContainer = renewForm.querySelector('.lei-search-results');
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
                        searchBtn.innerHTML = '<i class="fas fa-search"></i> Search';
                        searchBtn.disabled = false;
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
                        
                        // Show error message
                        let resultsContainer = renewForm.querySelector('.lei-search-results');
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
                        searchBtn.innerHTML = '<i class="fas fa-search"></i> Search';
                        searchBtn.disabled = false;
                    });
            }
        });
    }
    
    // Initialize now
    initRenewSearch();
    
    // Also handle tab switching to reinitialize if needed
    const tabButtons = document.querySelectorAll('.tab-btn');
    if (tabButtons.length > 0) {
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                if (tabId === 'renew') {
                    // Short delay to ensure DOM is updated
                    setTimeout(initRenewSearch, 100);
                }
            });
        });
    }
});