        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');
            const stepNumbers = document.querySelectorAll('.step-number');
            const progressBar = document.querySelector('.progress-bar');
            let currentStep = 0;
            
            // Show first step initially
            showStep(currentStep);
            
            // Next button click handler
            document.querySelectorAll('.next-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (validateStep(currentStep)) {
                        currentStep++;
                        showStep(currentStep);
                        updateProgress();
                    }
                });
            });
            
            // Previous button click handler
            document.querySelectorAll('.prev-btn').forEach(button => {
                button.addEventListener('click', function() {
                    currentStep--;
                    showStep(currentStep);
                    updateProgress();
                });
            });
            
            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    step.classList.toggle('active', index === stepIndex);
                });
            }
            
            function updateProgress() {
                const progressPercentage = (currentStep / (steps.length - 1)) * 100;
                
                // Create a style element to update the pseudo-element
                const style = document.createElement('style');
                style.innerHTML = `.progress-bar::after { width: ${progressPercentage}% !important; }`;
                document.head.appendChild(style);
                
                stepNumbers.forEach((number, index) => {
                    number.classList.toggle('active', index <= currentStep);
                });
            }
            
            function validateStep(stepIndex) {
                // Add validation logic here
                // For now, just return true
                return true;
            }
        });
        
// Create a new experience block with inputs and remove button
  function createExperienceBlock() {
    const block = document.createElement('div');
    block.classList.add('experience-item', 'p-3', 'mb-3');
    block.innerHTML = `
      <div class="row g-2 align-items-center">
        <div class="col-md-4">
          <input type="text" class="form-control mb-2" name="job_title[]" placeholder="Job Title">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control mb-2" name="company_name[]" placeholder="Company Name">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" name="job_duration[]" placeholder="Duration (e.g. 2021 - 2023)">
        </div>
        <div class="col-md-1 d-flex justify-content-end">
          <button type="button" class="btn btn-outline-danger btn-sm remove-experience" title="Remove Experience">&times;</button>
        </div>
      </div>
    `;
    return block;
  }

  // Add new experience block
  document.getElementById('add-experience').addEventListener('click', function () {
    document.getElementById('experience-fields').appendChild(createExperienceBlock());
  });

  // Remove experience block on clicking remove button
  document.getElementById('experience-fields').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-experience')) {
      const item = e.target.closest('.experience-item');
      if (item) item.remove();
    }
  });

  // Freshie checkbox toggles experience input fields and add button
  document.getElementById('freshie').addEventListener('change', function () {
    const disabled = this.checked;
    // Disable or enable all inputs inside experience-fields
    const inputs = document.querySelectorAll('#experience-fields input');
    inputs.forEach(input => input.disabled = disabled);
    // Disable or enable the add button
    document.getElementById('add-experience').disabled = disabled;
  });



  document.getElementById('toggleCollege').addEventListener('change', function () {
    document.getElementById('collegeSection').classList.toggle('d-none', !this.checked);
  });

  document.getElementById('toggleDiploma').addEventListener('change', function () {
    document.getElementById('diplomaSection').classList.toggle('d-none', !this.checked);
  });
  
    // Show/Hide Diploma Section
    const toggleDiploma = document.getElementById('toggleDiploma');
  const diplomaSection = document.getElementById('diplomaSection');

  // Function to toggle diploma section visibility
  function toggleDiplomaSection() {
    diplomaSection.classList.toggle('d-none', !toggleDiploma.checked);
  }

  // Run on page load
  window.addEventListener('DOMContentLoaded', () => {
    toggleDiplomaSection();
  });

  // Run when checkbox changes
  toggleDiploma.addEventListener('change', toggleDiplomaSection);

   function createDiplomaBlock() {
    const block = document.createElement('div');
    block.classList.add('row', 'g-2', 'mt-2', 'diploma-item', 'align-items-center');
    block.innerHTML = `
      <div class="col-md-5">
        <input type="text" class="form-control" name="diploma_name[]" placeholder="Diploma Name">
      </div>
      <div class="col-md-5">
        <input type="text" class="form-control" name="diploma_duration[]" placeholder="e.g. 2022 - 2023">
      </div>
      <div class="col-md-2">
        <button type="button" class="btn btn-outline-danger btn-sm remove-diploma">Remove</button>
      </div>
    `;
    return block;
  }

  document.getElementById('add-diploma').addEventListener('click', function () {
    document.getElementById('diploma-wrapper').appendChild(createDiplomaBlock());
  });

  document.getElementById('diploma-wrapper').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-diploma')) {
      const diplomaItem = e.target.closest('.diploma-item');
      if (diplomaItem) diplomaItem.remove();
    }
  });


//   skills

   const fieldSkills = {
    it: ['HTML', 'CSS', 'JavaScript', 'Python', 'Git'],
    marketing: ['SEO', 'Content Writing', 'Email Marketing', 'Google Ads'],
    education: ['Lesson Planning', 'Student Counseling', 'Assessment Design'],
    engineering: ['AutoCAD', 'SolidWorks', 'MATLAB', 'Project Management'],
    health: ['First Aid', 'Patient Care', 'CPR Certified', 'Health Records']
  };

  const fieldSelect = document.getElementById('fieldSelect');
  const suggestedSkills = document.getElementById('suggested-skills');
  const customFieldWrapper = document.getElementById('custom-field-wrapper');
  const addSkillBtn = document.getElementById('add-skill');

  fieldSelect.addEventListener('change', function () {
    const selected = this.value;
    suggestedSkills.innerHTML = '';

    // Show custom field input if "other" selected
    customFieldWrapper.style.display = selected === 'other' ? 'block' : 'none';

    if (fieldSkills[selected]) {
      fieldSkills[selected].forEach(skill => {
        const checkBoxDiv = document.createElement('div');
        checkBoxDiv.classList.add('form-check');
        checkBoxDiv.innerHTML = `
          <input class="form-check-input" type="checkbox" name="skills[]" value="${skill}" id="skill-${skill}">
          <label class="form-check-label" for="skill-${skill}">${skill}</label>
        `;
        suggestedSkills.appendChild(checkBoxDiv);
      });
    }
  });

 addSkillBtn.addEventListener('click', function () {
  // Create wrapper div for input + remove button
  const wrapper = document.createElement('div');
  wrapper.classList.add('input-group', 'mt-2');

  // Create input
  const input = document.createElement('input');
  input.type = 'text';
  input.name = 'skills[]';
  input.placeholder = 'Add custom skill';
  input.classList.add('form-control');

  // Create remove button
  const removeBtn = document.createElement('button');
  removeBtn.type = 'button';
  removeBtn.classList.add('btn', 'btn-danger');
  removeBtn.style.minWidth = '38px';
  removeBtn.textContent = '×';  // Cross sign

  // Remove input group on clicking removeBtn
  removeBtn.addEventListener('click', () => {
    wrapper.remove();
  });

  // Append input and removeBtn to wrapper
  wrapper.appendChild(input);
  wrapper.appendChild(removeBtn);

  // Insert wrapper before the "Add More" button (this)
  this.parentNode.insertBefore(wrapper, this);
});