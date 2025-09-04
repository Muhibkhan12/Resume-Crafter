
/* Bootstrap 5 JS Bundle minified (placeholder, use CDN in production) */

/* jQuery minified (placeholder, use CDN in production) */
// Add this to your existing jQuery code in form.php
$(document).ready(function() {
    // Initialize step counter and progress bar
    let currentStep = 1;
    const totalSteps = 4;
    updateProgressBar();
    
    // Next button click handler
    $('.next-btn').click(function() {
        if(currentStep < totalSteps) {
            // Validate current step before proceeding
            if(validateStep(currentStep)) {
                $('.step-'+currentStep).hide();
                currentStep++;
                $('.step-'+currentStep).show();
                updateProgressBar();
                
                // Add animation to new step
                $('.step-'+currentStep).css({
                    'opacity': 0,
                    'transform': 'translateY(20px)'
                }).animate({
                    'opacity': 1,
                    'transform': 'translateY(0)'
                }, 300);
            }
        }
    });
    
    // Previous button click handler
    $('.prev-btn').click(function() {
        if(currentStep > 1) {
            $('.step-'+currentStep).hide();
            currentStep--;
            $('.step-'+currentStep).show();
            updateProgressBar();
        }
    });
    
    // Form validation for each step
    function validateStep(step) {
        let isValid = true;
        
        // Validate personal info
        if(step === 1) {
            $('.step-1 input').each(function() {
                if(!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
        }
        
        // Validate education
        if(step === 2) {
            if(!$('#education').val()) {
                $('#education').addClass('is-invalid');
                isValid = false;
            } else {
                $('#education').removeClass('is-invalid');
            }
        }
        
        // Validate experience
        if(step === 3) {
            if(!$('#experience').val()) {
                $('#experience').addClass('is-invalid');
                isValid = false;
            } else {
                $('#experience').removeClass('is-invalid');
            }
        }
        
        return isValid;
    }
    
    // Update progress bar
    function updateProgressBar() {
        const progress = (currentStep - 1) / (totalSteps - 1) * 100;
        $('.progress-bar').css('width', progress + '%');
        
        $('.step-number').removeClass('active');
        for(let i = 1; i <= currentStep; i++) {
            $('.step-number[data-step="'+i+'"]').addClass('active');
        }
    }
    
    // Add floating animation to decorative elements
    $('.float-element').each(function(index) {
        $(this).css('animation-delay', (index * 0.2) + 's');
    });
    
    // Add input focus effects
    $('input, textarea').focus(function() {
        $(this).parent().addClass('input-focused');
    }).blur(function() {
        $(this).parent().removeClass('input-focused');
    });
});

// For preview.php - PDF generation
document.addEventListener('DOMContentLoaded', function() {
    const downloadBtn = document.getElementById('downloadPDF');
    if(downloadBtn) {
        downloadBtn.addEventListener('click', function() {
            // Load html2pdf library dynamically
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
            script.onload = function() {
                const element = document.getElementById('resumeContent');
                const opt = {
                    margin: 10,
                    filename: 'my-resume.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };
                
                // Add loading animation
                downloadBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating PDF...';
                
                // Generate PDF
                html2pdf().set(opt).from(element).save().then(() => {
                    downloadBtn.innerHTML = 'Download PDF';
                });
            };
            document.head.appendChild(script);
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    ScrollReveal().reveal('[data-sr]', {
        delay: 200,
        distance: '20px',
        duration: 1000,
        easing: 'cubic-bezier(0.5, 0, 0, 1)',
        reset: true
    });
});

// Counter animation
const animateCounters = () => {
    document.querySelectorAll('.counter').forEach(counter => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;
        const increment = target / 100;
        
        if (count < target) {
            counter.innerText = Math.ceil(count + increment);
            setTimeout(animateCounters, 20);
        }
    });
};

// Trigger on scroll
window.addEventListener('scroll', animateCounters);

// Add this to your script.js
document.querySelectorAll('.nav-link').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    window.scrollTo({
      top: target.offsetTop - 80,
      behavior: 'smooth'
    });
  });
});