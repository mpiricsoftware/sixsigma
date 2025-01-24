$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

document.addEventListener('DOMContentLoaded', function() {

  let isTransitioning = false;

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
      isTransitioning = false;
    }
  }

  function showQuestion(sectionId, direction) {
    const questionsContainer = document.querySelector(`#questions-container-${sectionId}`);
    const sectionCard = document.querySelector(`#question-card-${sectionId}`);

    if (!questionsContainer || !sectionCard) {
        console.error(`Questions container or Section Card not found for Section ID: ${sectionId}`);
        return;
    }

    const questions = questionsContainer.querySelectorAll('.question');
    console.log(`Found questions for Section ID ${sectionId}:`, questions);

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
                currentQuestionIndex++;
            } else if (direction === 'prev' && currentQuestionIndex > 0) {
                currentQuestionIndex--;
            }
        }
    }

    // Hide all questions in the current section
    questions.forEach(q => q.style.display = 'none');

    // Show the selected question
    if (currentQuestionIndex >= 0) {
        questions[currentQuestionIndex].style.display = 'block';
    }
    document.querySelectorAll('.card[id^="question-card-"]').forEach(card => {
        card.style.display = 'none'; // Hide all section cards
    });

    sectionCard.style.display = 'block'; // Show the current section card

    toggleButtons(sectionId, currentQuestionIndex, questions.length);
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
          finishSection(sectionId);
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
  window.startQuiz = startQuiz;
  window.showQuestion = showQuestion;
  window.finishSection = finishSection;
  window.showNextSection = showNextSection;
});


