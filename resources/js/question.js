$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

document.addEventListener('DOMContentLoaded', function() {

  let isTransitioning = false;
  let totalQuestions = document.querySelectorAll('.question[data-question-id]').length;
  let answeredQuestions = 0;
  let currentQuestionIndex = null;

  function updateProgressBar() {
    let progressPercentage = (answeredQuestions / totalQuestions) * 100;
    document.querySelectorAll("[id^='progress-bar-']").forEach(bar => {
      bar.style.width = progressPercentage + "%";
    });

  }

  function checkAnsweredQuestions() {
    answeredQuestions = 0;
    currentQuestionIndex = null; // Reset current question index

    document.querySelectorAll(".question[data-question-id]").forEach(question => {
      let hasAnswer = false;
      let questionIndex = parseInt(question.getAttribute("data-question-index"));

      // Check if any radio button (either "Today" or "Next Three Years") is selected
      let radioToday = question.querySelector("input[name^='answers']:checked");
      let radioFuture = question.querySelector("input[name^='ans_future']:checked");

      if (radioToday || radioFuture) {
        hasAnswer = true;
      }

      // Check if any checkbox in the question is checked
      if (question.querySelector("input[type='checkbox']:checked")) {
        hasAnswer = true;
      }

      // Check for text inputs, date inputs, and textareas (ensuring they are not empty)
      if (question.querySelector("input[type='text']:not(:placeholder-shown)")) {
        hasAnswer = true;
      }

      if (question.querySelector("input[type='date']:not(:placeholder-shown)")) {
        hasAnswer = true;
      }

      if (question.querySelector("textarea:not(:placeholder-shown)")) {
        hasAnswer = true;
      }

      // If any input has an answer, increase the count
      if (hasAnswer) {
        answeredQuestions++;
        currentQuestionIndex = questionIndex; // Update current question index
      }
    });

    updateProgressBar();
    console.log("Current Question Index: " + currentQuestionIndex);
  }

  document.querySelectorAll(".question input, .question textarea").forEach(input => {
    input.addEventListener("input", checkAnsweredQuestions);
  });

  // Also trigger on 'change' event for radio buttons and checkboxes
  document.querySelectorAll(".question input[type='radio'], .question input[type='checkbox']").forEach(input => {
    input.addEventListener("change", checkAnsweredQuestions);
  });

  // Initialize the progress bar
  checkAnsweredQuestions();


  function startQuiz(sectionId) {
    console.log(`Starting Quiz for Section ID: ${sectionId}`);
    const sectionCard = document.getElementById(`section-card-${sectionId}`);
    const questionCard = document.getElementById(`question-card-${sectionId}`);

    if (sectionCard) {
      sectionCard.style.display = 'none';
    } else {
      console.error(`Section card not found for Section ID: ${sectionId}`);
    }
    if (questionCard) {
      questionCard.style.display = 'block';
      showQuestion(sectionId, 'next');
    } else {
      console.error(`Question card not found for Section ID: ${sectionId}`);
    }
  }

  function showNextSection(currentSectionId) {
    if (isTransitioning) {
      console.log("Transition already in progress, skipping...");
      return;
    }
    console.log(`showNextSection called for Section ID: ${currentSectionId}`);
    isTransitioning = true;
    const sectionCards = Array.from(document.querySelectorAll('.card[id^="section-card-"]'));
    let currentSectionIndex = sectionCards.findIndex(section => section.id === `section-card-${currentSectionId}`);

    if (currentSectionIndex === -1) {
      console.error(`Section with ID ${currentSectionId} not found!`);
      isTransitioning = false;
      return;
    }
    console.log(`Hiding current section (ID: ${currentSectionId})`);
    sectionCards[currentSectionIndex].style.display = 'none';
    if (currentSectionIndex + 1 < sectionCards.length) {
      const nextSectionCard = sectionCards[currentSectionIndex + 1];
      console.log(`Displaying next section (ID: ${nextSectionCard.id})`);
      const nextSectionId = nextSectionCard.id.split('-').pop();
      console.log(`Next Section ID: ${nextSectionId}`);

      nextSectionCard.style.display = 'block';
      const startQuizBtn = document.getElementById(`start-quiz-btn-${nextSectionId}`);
      if (startQuizBtn) {
        startQuizBtn.style.display = 'block';
              startQuizBtn.onclick = function() {
          startQuiz(nextSectionId);
        };
      }

      isTransitioning = false;
    } else {
      console.log('No more sections. Quiz completed!');
      showCompletionCard();
      showStatusCard();
      isTransitioning = false;
    }
  }

  function showQuestion(sectionId, direction) {
    const questionsContainer = document.querySelector(`#questions-container-${sectionId}`);
    const sectionCard = document.querySelector(`#question-card-${sectionId}`);
    const questionNumberDisplay = document.querySelector(`#current-question-number-${sectionId}`);
    const completionCard = document.getElementById("completion-card");

    if (!questionsContainer || !sectionCard) {
      console.error(`Missing elements for Section ID: ${sectionId}`);
      return;
    }

    const questions = questionsContainer.querySelectorAll('.question');

    if (questions.length === 0) {
      console.error(`No questions found for Section ID: ${sectionId}`);
      return;
    }

    let currentQuestionIndex;

    if (direction === 'last') {
      currentQuestionIndex = questions.length - 1;
    } else {
      currentQuestionIndex = Array.from(questions).findIndex(q => q.style.display === 'block');

        if (currentQuestionIndex === -1) {
          currentQuestionIndex = 0;
        } else {
          if (direction === 'next' && currentQuestionIndex < questions.length - 1) {
            if (!validateCurrentQuestion(sectionId, currentQuestionIndex)) {
              return; // Stop if validation fails
          }
            currentQuestionIndex++;
          } else if (direction === 'prev' && currentQuestionIndex > 0) {
            currentQuestionIndex--;
          }

      }
    }
    if (completionCard) {
      completionCard.style.display = "none";
    }

    questions.forEach(q => q.style.display = 'none');
    if (currentQuestionIndex >= 0) {
      questions[currentQuestionIndex].style.display = 'block';
    }
    document.querySelectorAll('.card[id^="question-card-"]').forEach(card => {
      card.style.display = 'none'; // Hide all section cards
    });
    let allQuestions = Array.from(document.querySelectorAll('.question[data-question-id]'));
    let currentQuestionGlobalIndex = allQuestions.indexOf(questions[currentQuestionIndex]) + 1;
    document.querySelectorAll("[id^='question-progress']").forEach(counter => {
      counter.textContent = `Question ${currentQuestionGlobalIndex} out of ${allQuestions.length}`;
    });
    console.log(`Current Question Index: ${currentQuestionGlobalIndex} / ${allQuestions.length}`);
    sectionCard.style.display = 'block';

    toggleButtons(sectionId, currentQuestionIndex, questions.length);
  }
  function showLastQuestion(sectionId) {
    console.log("Returning to last question of section:", sectionId);

    // Hide the completion card
    let completionCard = document.getElementById("completion-card");
    if (completionCard) {
      completionCard.style.display = "none";
    }

    // Find the last question in the section
    let questionsContainer = document.querySelector(`#questions-container-${sectionId}`);
    if (!questionsContainer) {
      console.error("Questions container not found!");
      return;
    }

    let questions = questionsContainer.querySelectorAll('.question');
    if (questions.length === 0) {
      console.error("No questions found in the section!");
      return;
    }

    let lastQuestionIndex = questions.length - 1;

    // Hide all questions
    questions.forEach(q => q.style.display = "none");

    // Show the last question
    let lastQuestion = questions[lastQuestionIndex];
    if (lastQuestion) {
      lastQuestion.style.display = "block";
    }

    // Ensure the correct question card is visible
    let questionCard = document.querySelector(`#question-card-${sectionId}`);
    if (questionCard) {
      questionCard.style.display = "block";
    }

    // Update navigation buttons
    toggleButtons(sectionId, lastQuestionIndex, questions.length);
  }


  function toggleButtons(sectionId, currentQuestionIndex, totalQuestions) {
    const prevBtn = document.getElementById(`prev-btn${sectionId}`);
    const nextBtn = document.getElementById(`next-btn${sectionId}`);

    // Show the previous button only when not on the first question
    prevBtn.style.display = currentQuestionIndex === 0 ? 'none' : 'inline-block';
    // alert(currentQuestionIndex);
    if (currentQuestionIndex === totalQuestions - 1) {
      nextBtn.textContent = 'Next';
      nextBtn.onclick = function() {
        if (!validateCurrentQuestion(sectionId, currentQuestionIndex)) return;
        if (currentQuestionIndex === totalQuestions - 1) finishSection(sectionId);
        else showQuestion(sectionId, 'next');
    };


    } else {
      nextBtn.textContent = 'Next';
      nextBtn.onclick = function() {
        showQuestion(sectionId, 'next');

      };
    }

    // Handle prev button functionality
    prevBtn.textContent = 'Prev';
  prevBtn.onclick = function() {
      if (currentQuestionIndex === 0) {
        // If it's the first question, navigate to the last question of the previous section
        const previousSectionIndex = Array.from(document.querySelectorAll('.card[id^="question-card-"]')).findIndex(card => card.id === `question-card-${sectionId}`) - 1;

        if (previousSectionIndex >= 0) {
          const previousSectionId = document.querySelectorAll('.card[id^="question-card-"]')[previousSectionIndex].id.split('-').pop();
          const previousQuestionsContainer = document.querySelector(`#questions-container-${previousSectionId}`);
          const previousQuestions = previousQuestionsContainer.querySelectorAll('.question');

          // Ensure we're selecting the last question in the previous section
          const lastQuestionIndex = previousQuestions.length - 1;
          showQuestion(previousSectionId, 'last'); // Use a new direction for clarity
        }
      } else {
        showQuestion(sectionId, 'prev');

      }
    };
  }
  function validateCurrentQuestion(sectionId, currentQuestionIndex) {
    const questionsContainer = document.querySelector(`#questions-container-${sectionId}`);
    const currentQuestion = questionsContainer.querySelectorAll('.question')[currentQuestionIndex];
    const todayRadios = Array.from(currentQuestion.querySelectorAll('input[type="radio"][name^="answers"]'));
    const futureRadios = Array.from(currentQuestion.querySelectorAll('input[type="radio"][name^="ans_future"]'));
    let isTodayChecked = todayRadios.some(radio => radio.checked);
    let isFutureChecked = futureRadios.some(radio => radio.checked);
    todayRadios.forEach(radio => {
        radio.parentElement.classList.remove("radio-error");
    });
    if (!isTodayChecked) {
        todayRadios.forEach(radio => {
            radio.parentElement.classList.add("radio-error");
        });
        return false;
    }
    if (!isTodayChecked && isFutureChecked) {
        futureRadios.forEach(radio => {
            radio.parentElement.classList.add("radio-error");
        });
        return false;
    }
    return true;
}
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', (event) => {
        event.target.parentElement.classList.remove("radio-error");
    });
});




  function finishSection(sectionId) {
    console.log(`Finishing Section ID: ${sectionId}`);
    const sectionCard = document.getElementById(`section-card-${sectionId}`);
    const questionCard = document.getElementById(`question-card-${sectionId}`);
    questionCard.style.display = 'none';
    sectionCard.style.display = 'block';
    showNextSection(sectionId);
  }

  function showCompletionCard() {
    const completionCard = document.getElementById('completion-card');
    if (completionCard) {
      console.log("Displaying completion card...");
      completionCard.style.display = 'block';
    }
  }

  function showStatusCard() {

    const statusCard = document.getElementById('questionTable');
    if (statusCard) {
      console.log("Displaying status card...");
      statusCard.style.display = 'block';
    }
  }

  document.querySelectorAll('input[type="date"]').forEach(input => {
      input.addEventListener('change', function() {
      const selectedDate = this.value;
      console.log(`Date selected for Question: ${this.name} - ${selectedDate}`);
    });
  });

  document.querySelectorAll('.rating .star').forEach(star => {
      star.addEventListener('click', function() {
      const questionId = this.closest('.rating').dataset.questionId;
      const ratingValue = this.dataset.index;


      document.querySelector(`#selectedRating_${questionId}`).value = ratingValue;


      setRating(questionId, ratingValue);
    });
  });

  function highlightStars(questionId, ratingIndex) {
    const stars = document.querySelectorAll(`#rating_${questionId} .star`);
    stars.forEach((star, index) => {
      if (index < ratingIndex) {
        star.style.color = 'gold';
      } else {
        star.style.color = '#ccc';
      }
    });
  }

  function resetStars(questionId) {
    const stars = document.querySelectorAll(`#rating_${questionId} .star`);
    const selectedRating = parseInt(document.querySelector(`#selectedRating_${questionId}`).value);
    stars.forEach((star, index) => {
      if (index < selectedRating) {
        star.style.color = 'gold';
      } else {
        star.style.color = '#ccc';
      }
    });
  }

  function setRating(questionId, rating) {
    const stars = document.querySelectorAll(`#rating_${questionId} .star`);
    stars.forEach((star, index) => {
      star.style.color = index < rating ? 'gold' : '#ccc';
    });
  }

  document.querySelectorAll('.star').forEach(star => {
    const questionId = star.parentElement.id.split('_')[1];
  star.addEventListener('mouseover', function() {
      const ratingIndex = parseInt(star.getAttribute('data-index'));
      highlightStars(questionId, ratingIndex);
    });

  star.addEventListener('mouseout', function() {
      resetStars(questionId);
    });
  });



  const radioButtons = document.querySelectorAll("input[type='radio']");

  radioButtons.forEach(radio => {
    radio.addEventListener("change", function () {
      let questionId = this.getAttribute("data-question-id"); // Get the question ID
      let sectionId = this.closest("form")?.getAttribute("data-section-id"); // Get section ID (optional)

      console.log(`Selected Question ID: ${questionId}, Section ID: ${sectionId}`);

      if (!questionId) {
        console.error("❌ Failed to retrieve question ID.");
        return;
      }

      // Find the corresponding table cell
      let questionCell = document.getElementById(`question-${questionId}`);

      if (questionCell) {
        questionCell.style.backgroundColor = "rgb(73, 138, 73)"; // Change background color
        questionCell.style.color = "white"; // Ensure text is readable
      } else {
        console.warn(`⚠️ No table cell found for question ID: ${questionId}`);
      }
    });
  });



  window.startQuiz = startQuiz;
  window.showQuestion = showQuestion;
  Window.showLastQuestion = showLastQuestion;
  window.finishSection = finishSection;
  window.showNextSection = showNextSection;
});


