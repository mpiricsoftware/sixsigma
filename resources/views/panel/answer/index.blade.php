<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Question Answer System</title>
</head>
<body>
    <h1>Dynamic Form</h1>

    <!-- Form Type Selection (For selecting Form ID) -->
    <label for="formId">Select Form ID:</label>
    <select id="formId">
        <option value="" disabled selected>Select a Form</option>
        <option value="1">Form 1</option>
        <option value="2">Form 2</option>
    </select>
    <br><br>

    <!-- Questions will be dynamically loaded here -->
    <div id="questionsContainer"></div>

    <script>
        // Fetch and display questions based on Form ID
        document.getElementById('formId').addEventListener('change', function() {
            const formId = this.value;
            if (formId) {
                fetchQuestions(formId);
            }
        });

        // Function to fetch questions for a specific Form ID
        function fetchQuestions(formId) {
            fetch(`/form/${formId}/questions`)
                .then(response => response.json())
                .then(data => {
                    const questionsContainer = document.getElementById('questionsContainer');
                    questionsContainer.innerHTML = ''; // Clear previous questions

                    data.questions.forEach((question) => {
                        const questionDiv = document.createElement('div');
                        questionDiv.style.marginBottom = '10px';

                        // Create the question text
                        const questionLabel = document.createElement('label');
                        questionLabel.textContent = question.text;
                        questionDiv.appendChild(questionLabel);

                        // Create the dropdown to answer the question
                        const answerDropdown = document.createElement('select');
                        answerDropdown.setAttribute('data-question-id', question.id);  // Store question ID

                        // Example answers: You can dynamically load these based on question or form type
                        const answers = ['Answer 1', 'Answer 2', 'Answer 3'];  // Placeholder answers

                        answers.forEach((answer) => {
                            const option = document.createElement('option');
                            option.value = answer;
                            option.textContent = answer;
                            answerDropdown.appendChild(option);
                        });

                        questionDiv.appendChild(answerDropdown);
                        questionsContainer.appendChild(questionDiv);

                        // Handle answer submission when a dropdown answer is selected
                        answerDropdown.addEventListener('change', function() {
                            const selectedAnswer = this.value;
                            const questionId = this.getAttribute('data-question-id');
                            submitAnswer(questionId, selectedAnswer);
                        });
                    });
                })
                .catch(error => console.error('Error fetching questions:', error));
        }

        // Function to submit the answer for a question
        function submitAnswer(questionId, answer) {
            fetch(`/form/${questionId}/answer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token
                },
                body: JSON.stringify({ answer: answer })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(error => console.error('Error submitting answer:', error));
        }
    </script>
</body>
</html>
