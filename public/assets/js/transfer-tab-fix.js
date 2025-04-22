// Add this code to a new file: transfer-tab-fix.js

document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing Transfer tab fix...');
    
    // Function to initialize the transfer verification
    function initTransferVerification() {
        const transferForm = document.getElementById('transfer-form');
        const transferLeiInput = document.getElementById('transfer-lei');
        const verifyLeiBtn = transferForm ? transferForm.querySelector('.verify-lei-btn') : null;
        
        if (!transferForm || !transferLeiInput || !verifyLeiBtn) {
            console.error('Transfer form elements not found:', {
                form: !!transferForm, 
                input: !!transferLeiInput, 
                button: !!verifyLeiBtn
            });
            
            // Log all buttons for debugging
            const allButtons = document.querySelectorAll('button');
            console.log('All buttons on page:', allButtons.length);
            allButtons.forEach((btn, index) => {
                console.log(`Button ${index}:`, btn.innerText, btn.className);
            });
            
            return;
        }
        
        console.log('Transfer form elements found, attaching event listener');
        
        // Add the event listener for the verify button
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
    }
    
    // Initialize now
    initTransferVerification();
    
    // Also handle tab switching to reinitialize if needed
    const tabButtons = document.querySelectorAll('.tab-btn');
    if (tabButtons.length > 0) {
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                if (tabId === 'transfer') {
                    // Short delay to ensure DOM is updated
                    setTimeout(initTransferVerification, 100);
                }
            });
        });
    }
});