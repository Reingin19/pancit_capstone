/* ================================
   resources/js/student_dashboard.js
   ================================ */

document.addEventListener('DOMContentLoaded', function () {

    /* ================================
       NAVIGATION
       ================================ */
    function navigate(page) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));

        const target = document.getElementById('page-' + page);
        if (target) target.classList.add('active');

        document.querySelectorAll('.nav-item[data-page]').forEach(b => {
            b.classList.toggle('active', b.dataset.page === page);
        });
        document.querySelectorAll('.sidebar-item[data-page]').forEach(b => {
            b.classList.toggle('active', b.dataset.page === page);
        });

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.querySelectorAll('[data-page]').forEach(btn => {
        btn.addEventListener('click', function () {
            navigate(this.dataset.page);
        });
    });

    // Expose globally for Blade inline onclick attributes
    window.navigate = navigate;

    /* ================================
       SUMMATIVE TEST — Quiz Logic
       ================================ */
    const quizQuestions = [
        { q: "In an arithmetic sequence, the first term is 3 and the common difference is 4. What is the 6th term?",     choices: ["19","23","21","17"],                                                                                          answer: 1 },
        { q: "What is the sum of the first 5 terms of the geometric sequence 2, 6, 18, 54, ...?",                        choices: ["162","242","182","122"],                                                                                      answer: 1 },
        { q: "Which of the following is a polynomial expression?",                                                        choices: ["x⁻² + 3","√x + 2","3x³ − 2x + 1","1/x + 5"],                                                              answer: 2 },
        { q: "What is the remainder when P(x) = x³ − 2x² + x − 5 is divided by (x − 2)?",                              choices: ["-3","-1","3","1"],                                                                                            answer: 0 },
        { q: "Factor completely: x² − 9",                                                                                choices: ["(x−3)²","(x+3)(x−3)","(x−9)(x+1)","(x+3)²"],                                                              answer: 1 },
        { q: "Which is the correct form of the quadratic formula?",                                                       choices: ["x = (b ± √(b²−4ac)) / 2a","x = (−b ± √(b²+4ac)) / 2a","x = (−b ± √(b²−4ac)) / 2a","x = (−b ± √(b²−4ac)) / a"], answer: 2 },
        { q: "Solve for x: 2^x = 32",                                                                                    choices: ["4","5","6","3"],                                                                                              answer: 1 },
        { q: "What is log₂(64)?",                                                                                        choices: ["5","8","6","7"],                                                                                              answer: 2 },
        { q: "If f(x) = 2x + 3, what is f(4)?",                                                                         choices: ["10","11","12","9"],                                                                                            answer: 1 },
        { q: "An infinite geometric series converges when the common ratio r satisfies:",                                 choices: ["r > 1","|r| < 1","r = 1","r < 0"],                                                                            answer: 1 },
    ];

    let quizCurrent = 0;
    let quizAnswers = new Array(quizQuestions.length).fill(null);
    let quizScore   = 0;

    function startQuiz() {
        quizCurrent = 0;
        quizAnswers = new Array(quizQuestions.length).fill(null);
        quizScore   = 0;
        document.getElementById('quiz-start-screen').style.display    = 'none';
        document.getElementById('quiz-question-screen').style.display = 'block';
        document.getElementById('quiz-result-screen').style.display   = 'none';
        renderQuestion();
    }

    function renderQuestion() {
        const q     = quizQuestions[quizCurrent];
        const total = quizQuestions.length;

        document.getElementById('quiz-q-label').textContent      = `Question ${quizCurrent + 1} of ${total}`;
        document.getElementById('quiz-progress-bar').style.width = `${((quizCurrent + 1) / total) * 100}%`;
        document.getElementById('quiz-question-text').textContent = q.q;
        document.getElementById('quiz-score-badge').textContent   = `Score: ${quizScore}`;

        const choicesEl = document.getElementById('quiz-choices');
        choicesEl.innerHTML = '';
        ['A','B','C','D'].forEach((letter, i) => {
            const btn = document.createElement('button');
            btn.className = 'quiz-choice';
            if (quizAnswers[quizCurrent] === i) btn.classList.add('selected');
            btn.innerHTML = `<span class="choice-letter">${letter}</span>${q.choices[i]}`;
            btn.addEventListener('click', () => selectAnswer(i));
            choicesEl.appendChild(btn);
        });

        const prevBtn = document.getElementById('quiz-prev-btn');
        prevBtn.style.opacity = quizCurrent === 0 ? '0.3' : '1';
        prevBtn.disabled      = quizCurrent === 0;

        document.getElementById('quiz-next-btn').textContent =
            quizCurrent === total - 1 ? 'Submit ✓' : 'Next →';
    }

    function selectAnswer(index) {
        quizAnswers[quizCurrent] = index;
        document.querySelectorAll('.quiz-choice').forEach((btn, i) => {
            btn.classList.toggle('selected', i === index);
            const letter = btn.querySelector('.choice-letter');
            letter.style.background = i === index ? 'var(--blue)' : '';
            letter.style.color      = i === index ? 'white'       : '';
        });
    }

    function quizNext() {
        if (quizAnswers[quizCurrent] === null) {
            // window.toast is defined in chatbot.js (loaded on the same page)
            window.toast('warning', 'Please select an answer first!');
            return;
        }
        if (quizCurrent < quizQuestions.length - 1) {
            quizCurrent++;
            renderQuestion();
        } else {
            submitQuiz();
        }
    }

    function quizPrev() {
        if (quizCurrent > 0) { quizCurrent--; renderQuestion(); }
    }

    function submitQuiz() {
        quizScore = quizAnswers.reduce((acc, ans, i) =>
            acc + (ans === quizQuestions[i].answer ? 1 : 0), 0);

        const total = quizQuestions.length;
        const pct   = Math.round((quizScore / total) * 100);

        document.getElementById('quiz-question-screen').style.display = 'none';
        document.getElementById('quiz-result-screen').style.display   = 'block';
        document.getElementById('quiz-result-score').textContent      = `${quizScore}/${total}`;

        let emoji = '😢', title = 'Keep Practicing!', msg = 'Review your modules and try again.';
        if      (pct >= 90) { emoji = '🏆'; title = 'Outstanding!'; msg = 'Excellent work! You mastered the material.'; }
        else if (pct >= 75) { emoji = '🎉'; title = 'Great Job!';   msg = 'You passed! Keep reviewing for mastery.';   }
        else if (pct >= 50) { emoji = '👍'; title = 'Good Effort!'; msg = 'Almost there — review your weak areas.';    }

        document.getElementById('quiz-result-emoji').textContent = emoji;
        document.getElementById('quiz-result-title').textContent = title;
        document.getElementById('quiz-result-msg').textContent   = `${pct}% — ${msg}`;
    }

    function retakeQuiz() {
        document.getElementById('quiz-result-screen').style.display = 'none';
        startQuiz();
    }

    // Expose quiz functions globally for Blade inline onclick attributes
    window.startQuiz  = startQuiz;
    window.quizNext   = quizNext;
    window.quizPrev   = quizPrev;
    window.retakeQuiz = retakeQuiz;

});