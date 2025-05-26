/**
 * This JavaScript fixes the plan selection in the registration and renewal forms
 * to persist selections across page reloads
 */
document.addEventListener('DOMContentLoaded', function() {
    // Handle plan selection for registration form
    const planCards = document.querySelectorAll('.plan-card');
    const selectedPlanInput = document.getElementById('selected_plan');
    
    if (planCards.length > 0 && selectedPlanInput) {
        // Store the currently selected plan in local storage when changed
        planCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from all cards
                planCards.forEach(c => c.classList.remove('selected'));
                
                // Add active class to clicked card
                card.classList.add('selected');
                
                // Update hidden input
                const planValue = card.getAttribute('data-plan');
                selectedPlanInput.value = planValue;
                
                // Store in localStorage
                localStorage.setItem('selectedPlan', planValue);
            });
        });
        
        // On page load, check localStorage and select the saved plan
        const savedPlan = localStorage.getItem('selectedPlan');
        if (savedPlan) {
            // Find the card with this plan and click it
            const matchingCard = Array.from(planCards).find(card => 
                card.getAttribute('data-plan') === savedPlan
            );
            
            if (matchingCard) {
                // Remove selected class from all cards
                planCards.forEach(c => c.classList.remove('selected'));
                
                // Add selected class to matching card
                matchingCard.classList.add('selected');
                
                // Update hidden input
                selectedPlanInput.value = savedPlan;
            }
        }
    }
    
    // Handle renewal form options
    const renewalOptions = document.querySelectorAll('.renewal-option');
    
    if (renewalOptions.length > 0) {
        // Store the currently selected renewal period in local storage when changed
        renewalOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all options
                renewalOptions.forEach(opt => {
                    opt.classList.remove('active');
                    const radio = opt.querySelector('input[type="radio"]');
                    if (radio) radio.checked = false;
                });
                
                // Add active class to clicked option
                option.classList.add('active');
                
                // Check the radio button
                const radio = option.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
                
                // Store in localStorage
                const periodValue = option.getAttribute('data-value');
                localStorage.setItem('renewalPeriod', periodValue);
            });
        });
        
        // On page load, check localStorage and select the saved period
        const savedPeriod = localStorage.getItem('renewalPeriod');
        if (savedPeriod) {
            // Find the option with this period and click it
            const matchingOption = Array.from(renewalOptions).find(option => 
                option.getAttribute('data-value') === savedPeriod
            );
            
            if (matchingOption) {
                // Remove active class from all options
                renewalOptions.forEach(opt => {
                    opt.classList.remove('active');
                    const radio = opt.querySelector('input[type="radio"]');
                    if (radio) radio.checked = false;
                });
                
                // Add active class to matching option
                matchingOption.classList.add('active');
                
                // Check the radio button
                const radio = matchingOption.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            }
        }
    }
});