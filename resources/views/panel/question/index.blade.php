<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Creator</title>
</head>
<body>
    <h1>Create a Dynamic Form</h1>

    <!-- Form Type Selection -->
    <label for="formType">Select Form Type:</label>
    <select id="formType">
        <option value="" disabled selected>Select a form type</option>
        <option value="address">Address</option>
        <option value="personalDetails">Personal Details</option>
        <option value="contact">Contact</option>
    </select>
    <br><br>

    <!-- Form Questions will appear here -->
    <div id="formQuestions"></div>
    <br>

    <!-- Save Form Button -->
    <button id="saveFormButton">Save Form</button>

    <!-- Saved Forms Display -->
    <h2>Saved Forms</h2>
    <div id="savedForms"></div>

    <script>
        const formTypeSelect = document.getElementById('formType');
        const formQuestionsContainer = document.getElementById('formQuestions');
        const savedFormsContainer = document.getElementById('savedForms');
        const savedForms = [];

        // Predefined questions for each form type
        const formTemplates = {
            address: [
                { question: "Street Address", type: "text" },
                { question: "City", type: "text" },
                { question: "State", type: "text" },
                { question: "Zip Code", type: "text" }
            ],
            personalDetails: [
                { question: "What is your name?", type: "text" },
                { question: "What is your age?", type: "number" },
                { question: "What is your gender?", type: "text" }
            ],
            contact: [
                { question: "Email Address", type: "email" },
                { question: "Phone Number", type: "tel" }
            ]
        };

        // Event listener for form type selection
        formTypeSelect.addEventListener('change', (e) => {
            const selectedFormType = e.target.value;
            displayFormQuestions(selectedFormType);
        });

        // Display the form questions based on selected form type
        function displayFormQuestions(formType) {
            formQuestionsContainer.innerHTML = ''; // Clear previous questions

            if (formTemplates[formType]) {
                formTemplates[formType].forEach((field, index) => {
                    const fieldDiv = document.createElement('div');
                    fieldDiv.style.marginBottom = '10px';

                    // Create the question label
                    const questionLabel = document.createElement('label');
                    questionLabel.textContent = field.question;
                    questionLabel.setAttribute('for', `question-${index}`);
                    fieldDiv.appendChild(questionLabel);

                    // Create the input field
                    const inputField = document.createElement('input');
                    inputField.type = field.type;
                    inputField.id = `question-${index}`;
                    inputField.placeholder = `Enter your ${field.question.toLowerCase()}`;
                    inputField.style.marginTop = '5px';
                    fieldDiv.appendChild(inputField);

                    // Append the field div to the form questions container
                    formQuestionsContainer.appendChild(fieldDiv);
                });
            }
        }

        // Save the form when the button is clicked
        document.getElementById('saveFormButton').addEventListener('click', () => {
            const formType = formTypeSelect.value;

            if (!formType) {
                alert('Please select a form type.');
                return;
            }

            const formFields = [];
            formQuestionsContainer.querySelectorAll('div').forEach((fieldDiv, index) => {
                const inputField = fieldDiv.querySelector('input');
                formFields.push({
                    question: formTemplates[formType][index].question,
                    answer: inputField.value
                });
            });

            if (formFields.length === 0) {
                alert('No fields to save.');
                return;
            }

            // Save the form with its answers
            savedForms.push({ formType, fields: formFields });

            // Clear the form questions container
            formQuestionsContainer.innerHTML = '';

            // Display saved forms
            displaySavedForms();
        });

        // Display all saved forms with their answers
        function displaySavedForms() {
            savedFormsContainer.innerHTML = '';
            savedForms.forEach((savedForm, index) => {
                const formDiv = document.createElement('div');
                formDiv.style.marginBottom = '20px';

                const formTitle = document.createElement('h3');
                formTitle.textContent = `${savedForm.formType.charAt(0).toUpperCase() + savedForm.formType.slice(1)} Form`;

                const fieldsList = document.createElement('ul');
                savedForm.fields.forEach(field => {
                    const fieldItem = document.createElement('li');
                    fieldItem.textContent = `${field.question}: ${field.answer}`;
                    fieldsList.appendChild(fieldItem);
                });

                formDiv.appendChild(formTitle);
                formDiv.appendChild(fieldsList);
                savedFormsContainer.appendChild(formDiv);
            });
        }
    </script>
</body>
</html>
