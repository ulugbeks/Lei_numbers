// LEI Lookup Tool functionality
document.addEventListener('DOMContentLoaded', function() {
    initLeiLookupTool();
});

/**
 * Initialize the LEI lookup tool
 */
function initLeiLookupTool() {
    const lookupBtn = document.getElementById('lookup-btn');
    const lookupQuery = document.getElementById('lookup-query');
    const lookupResults = document.getElementById('lookup-results');
    
    if (!lookupBtn || !lookupQuery || !lookupResults) return;
    
    lookupBtn.addEventListener('click', function() {
        const query = lookupQuery.value.trim();
        
        if (!query) {
            lookupResults.innerHTML = '<div class="alert alert-warning">Please enter an LEI code or company name</div>';
            return;
        }
        
        // Show loading state
        lookupResults.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Searching GLEIF database...</div>';
        lookupBtn.disabled = true;
        
        // Determine if the query is an LEI or company name
        const isLei = /^[A-Z0-9]{20}$/.test(query);
        
        if (isLei) {
            // Search by LEI code
            fetchLeiDetails(query)
                .then(displayLookupResults)
                .catch(error => {
                    console.error('Error fetching LEI details:', error);
                    lookupResults.innerHTML = '<div class="alert alert-danger">Error fetching LEI details. Please try again.</div>';
                })
                .finally(() => {
                    lookupBtn.disabled = false;
                });
        } else {
            // Search by company name
            searchCompaniesByName(query)
                .then(results => {
                    if (!results || !results.data || results.data.length === 0) {
                        lookupResults.innerHTML = '<div class="alert alert-info">No results found for that company name. Try a different search term.</div>';
                    } else {
                        displayLookupCompanyResults(results);
                    }
                })
                .catch(error => {
                    console.error('Error searching companies:', error);
                    lookupResults.innerHTML = '<div class="alert alert-danger">Error searching companies. Please try again.</div>';
                })
                .finally(() => {
                    lookupBtn.disabled = false;
                });
        }
    });
    
    // Add enter key support
    lookupQuery.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            lookupBtn.click();
        }
    });
}

/**
 * Display detailed information about an LEI in the lookup tool
 * @param {Object} leiData - LEI data from GLEIF API
 */
function displayLookupResults(leiData) {
    const lookupResults = document.getElementById('lookup-results');
    
    if (!leiData || !leiData.data || !leiData.data.attributes) {
        lookupResults.innerHTML = '<div class="alert alert-warning">LEI not found in the GLEIF database</div>';
        return;
    }
    
    const entity = leiData.data.attributes.entity;
    const registration = leiData.data.attributes.registration;
    const legalAddress = entity.legalAddress;
    const hqAddress = entity.headquartersAddress;
    
    // Format dates
    const formatDate = dateStr => {
        if (!dateStr) return 'N/A';
        const date = new Date(dateStr);
        return date.toLocaleDateString();
    };
    
    // Build HTML for the LEI details
    let html = `
        <div class="lei-detail-card">
            <div class="lei-detail-header">
                <h3>${entity.legalName.name}</h3>
                <div class="lei-badge">${leiData.data.id}</div>
            </div>
            
            <div class="lei-detail-section">
                <h4>Entity Information</h4>
                <div class="lei-detail-grid">
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Legal Form</div>
                        <div class="lei-detail-value">${entity.legalForm ? entity.legalForm.description || 'N/A' : 'N/A'}</div>
                    </div>
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Entity Status</div>
                        <div class="lei-detail-value">${entity.status || 'N/A'}</div>
                    </div>
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Registration Authority</div>
                        <div class="lei-detail-value">${entity.registeredAs || 'N/A'}</div>
                    </div>
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Registration Authority ID</div>
                        <div class="lei-detail-value">${entity.registeredAs || 'N/A'}</div>
                    </div>
                </div>
            </div>
            
            <div class="lei-detail-section">
                <h4>Legal Address</h4>
                <div class="lei-detail-grid">
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Country</div>
                        <div class="lei-detail-value">${legalAddress.country || 'N/A'}</div>
                    </div>
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">City</div>
                        <div class="lei-detail-value">${legalAddress.city || 'N/A'}</div>
                    </div>
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Address</div>
                        <div class="lei-detail-value">${(legalAddress.addressLines && legalAddress.addressLines[0]) || 'N/A'}</div>
                    </div>
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Postal Code</div>
                        <div class="lei-detail-value">${legalAddress.postalCode || 'N/A'}</div>
                    </div>
                </div>
            </div>
    `;
    
    // Add headquarters address if different from legal address
    if (hqAddress && hqAddress.country) {
        html += `
            <div class="lei-detail-section">
                <h4>Headquarters Address</h4>
                <div class="lei-detail-grid">
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Country</div>
                        <div class="lei-detail-value">${hqAddress.country || 'N/A'}</div>
                    </div>
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">City</div>
                        <div class="lei-detail-value">${hqAddress.city || 'N/A'}</div>
                    </div>
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Address</div>
                        <div class="lei-detail-value">${(hqAddress.addressLines && hqAddress.addressLines[0]) || 'N/A'}</div>
                    </div>
                    <div class="lei-detail-item">
                        <div class="lei-detail-label">Postal Code</div>
                        <div class="lei-detail-value">${hqAddress.postalCode || 'N/A'}</div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Add registration information
    html += `
        <div class="lei-detail-section">
            <h4>Registration Information</h4>
            <div class="lei-detail-grid">
                <div class="lei-detail-item">
                    <div class="lei-detail-label">Registration Status</div>
                    <div class="lei-detail-value status-badge ${registration.status === 'ISSUED' ? 'status-active' : 'status-inactive'}">${registration.status || 'N/A'}</div>
                </div>
                <div class="lei-detail-item">
                    <div class="lei-detail-label">Initial Registration</div>
                    <div class="lei-detail-value">${formatDate(registration.initialRegistrationDate)}</div>
                </div>
                <div class="lei-detail-item">
                    <div class="lei-detail-label">Last Update</div>
                    <div class="lei-detail-value">${formatDate(registration.lastUpdateDate)}</div>
                </div>
                <div class="lei-detail-item">
                    <div class="lei-detail-label">Next Renewal</div>
                    <div class="lei-detail-value ${new Date(registration.nextRenewalDate) < new Date() ? 'expired' : ''}">${formatDate(registration.nextRenewalDate)}</div>
                </div>
                <div class="lei-detail-item">
                    <div class="lei-detail-label">Managing LOU</div>
                    <div class="lei-detail-value">${registration.managingLOU || 'N/A'}</div>
                </div>
                <div class="lei-detail-item">
                    <div class="lei-detail-label">Validation Sources</div>
                    <div class="lei-detail-value">${registration.validationSources || 'N/A'}</div>
                </div>
            </div>
        </div>
    `;
    
    // Add action buttons
    html += `
        <div class="lei-detail-actions">
            <a href="${`https://search.gleif.org/#/record/details/${leiData.data.id}`}" target="_blank" class="action-btn view-gleif-btn">
                <i class="fas fa-external-link-alt"></i> View on GLEIF
            </a>
            <a href="${`/renew?lei=${leiData.data.id}`}" class="action-btn renew-btn">
                <i class="fas fa-sync"></i> Renew This LEI
            </a>
            <a href="${`/transfer?lei=${leiData.data.id}`}" class="action-btn transfer-btn">
                <i class="fas fa-exchange-alt"></i> Transfer This LEI
            </a>
        </div>
    `;
    
    html += '</div>';
    
    lookupResults.innerHTML = html;
}

/**
 * Display company search results in the lookup tool
 * @param {Object} results - Company search results from GLEIF API
 */
function displayLookupCompanyResults(results) {
    const lookupResults = document.getElementById('lookup-results');
    
    let html = `
        <div class="lookup-company-results">
            <h3>Search Results</h3>
            <p>Found ${results.data.length} entities matching your search. Click on an entity to view details.</p>
            <div class="company-results-grid">
    `;
    
    results.data.forEach(company => {
        const entityName = company.attributes.entity.legalName.name;
        const lei = company.id;
        const status = company.attributes.registration.status;
        const country = company.attributes.entity.legalAddress.country;
        const statusClass = status === 'ISSUED' ? 'status-active' : 'status-inactive';
        
        html += `
            <div class="company-result-card" data-lei="${lei}">
                <div class="company-card-header">
                    <div class="company-name">${entityName}</div>
                    <div class="company-status ${statusClass}">${status}</div>
                </div>
                <div class="company-card-body">
                    <div class="company-lei">${lei}</div>
                    <div class="company-country">${country}</div>
                </div>
                <button class="view-details-btn" data-lei="${lei}">View Details</button>
            </div>
        `;
    });
    
    html += `
            </div>
        </div>
    `;
    
    lookupResults.innerHTML = html;
    
    // Add click handlers for company cards
    const detailButtons = lookupResults.querySelectorAll('.view-details-btn');
    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const lei = this.getAttribute('data-lei');
            
            // Show loading state
            lookupResults.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading details...</div>';
            
            // Fetch and display full LEI details
            fetchLeiDetails(lei)
                .then(displayLookupResults)
                .catch(error => {
                    console.error('Error fetching LEI details:', error);
                    lookupResults.innerHTML = '<div class="alert alert-danger">Error fetching entity details. Please try again.</div>';
                });
        });
    });
}

// Add CSS for the LEI lookup tool
const lookupStyle = document.createElement('style');
lookupStyle.textContent = `
    /* LEI Lookup Tool Styling */
    .lei-lookup-section {
        padding: 60px 0;
        background-color: #f8f9fa;
    }
    
    .lei-lookup-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        padding: 30px;
        margin-top: 30px;
    }
    
    .lookup-form {
        margin-bottom: 30px;
    }
    
    .loading-spinner {
        text-align: center;
        padding: 40px;
        color: #666;
        font-size: 18px;
    }
    
    .loading-spinner i {
        margin-right: 10px;
        color: #4a6cf7;
    }
    
    /* Company Search Results Styling */
    .company-results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .company-result-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .company-result-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .company-card-header {
        padding: 15px;
        background-color: #f5f7ff;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .company-name {
        font-weight: bold;
        font-size: 16px;
    }
    
    .company-status {
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    
    .company-card-body {
        padding: 15px;
    }
    
    .company-lei {
        font-family: monospace;
        color: #666;
        margin-bottom: 10px;
    }
    
    .company-country {
        font-size: 14px;
        color: #444;
    }
    
    .view-details-btn {
        display: block;
        width: 100%;
        padding: 10px;
        text-align: center;
        background-color: #4a6cf7;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .view-details-btn:hover {
        background-color: #3655d7;
    }
    
    /* LEI Detail Card Styling */
    .lei-detail-card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .lei-detail-header {
        padding: 20px;
        background-color: #4a6cf7;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .lei-detail-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }
    
    .lei-badge {
        background-color: rgba(255,255,255,0.2);
        padding: 5px 10px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 14px;
    }
    
    .lei-detail-section {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .lei-detail-section h4 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 16px;
        color: #333;
    }
    
    .lei-detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .lei-detail-item {
        margin-bottom: 10px;
    }
    
    .lei-detail-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }
    
    .lei-detail-value {
        font-size: 14px;
        color: #333;
    }
    
    .status-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    
    .expired {
        color: #e74c3c;
    }
    
    .lei-detail-actions {
        padding: 20px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .action-btn {
        padding: 10px 15px;
        border-radius: 4px;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background-color 0.2s;
    }
    
    .action-btn i {
        margin-right: 8px;
    }
    
    .view-gleif-btn {
        background-color: #f8f9fa;
        color: #333;
    }
    
    .view-gleif-btn:hover {
        background-color: #e9ecef;
    }
    
    .renew-btn {
        background-color: #4a6cf7;
        color: white;
    }
    
    .renew-btn:hover {
        background-color: #3655d7;
    }
    
    .transfer-btn {
        background-color: #6c757d;
        color: white;
    }
    
    .transfer-btn:hover {
        background-color: #5a6268;
    }
`;

document.head.appendChild(lookupStyle);