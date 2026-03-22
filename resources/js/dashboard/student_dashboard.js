/* ================================
   STUDENT DASHBOARD — dashboard.js
   ================================ */

document.addEventListener('DOMContentLoaded', function () {

    /* ── Navigation ── */
    function navigate(page) {
        // hide all pages
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        // show target
        const target = document.getElementById('page-' + page);
        if (target) target.classList.add('active');

        // bottom nav active
        document.querySelectorAll('.nav-item[data-page]').forEach(b => {
            b.classList.toggle('active', b.dataset.page === page);
        });
        // sidebar active
        document.querySelectorAll('.sidebar-item[data-page]').forEach(b => {
            b.classList.toggle('active', b.dataset.page === page);
        });

        // scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Wire up all data-page buttons
    document.querySelectorAll('[data-page]').forEach(btn => {
        btn.addEventListener('click', function () {
            navigate(this.dataset.page);
        });
    });

    // Expose navigate globally (used inline in HTML)
    window.navigate = navigate;

    /* ================================
       CHATBOT — chatbot.js
       ================================ */

    const chatWindow  = document.getElementById('ai-chat-window');
    const chatContent = document.getElementById('chat-content');
    const input       = document.getElementById('ai-input');
    let isOpen = false;

    function getTime() {
        return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function openChat() {
        if (isOpen) return;
        isOpen = true;
        chatWindow.classList.add('open');
        setTimeout(() => input?.focus(), 320);
    }

    function closeChat() {
        isOpen = false;
        chatWindow.classList.remove('open');
    }

    const genericResponses = [
        "I can help you with that math problem! Could you share more details?",
        "Great question! Let me break that down step by step.",
        "Let's work through this together. Start by identifying what's given.",
        "Good thinking! Apply the formula systematically and you'll get there.",
        "That's a classic concept — here's how to approach it.",
    ];

    const topicMap = {
        sequences:    "Sequences follow a pattern! <em>Arithmetic sequences</em> have a constant difference <em>d</em>, while geometric ones multiply by a ratio <em>r</em>. Which type are you working on?",
        series:       "A series is the sum of a sequence. For arithmetic: S = n/2 · (a₁ + aₙ). For geometric: S = a₁(1−rⁿ)/(1−r). Want me to walk through an example?",
        polynomials:  "Polynomials are expressions like aₙxⁿ + ... + a₀. Key skills include <em>factoring</em>, <em>long division</em>, and the <em>remainder theorem</em>. What do you need help with?",
        polynomial:   "For polynomial equations, try factoring first. If degree ≤ 4, synthetic division or the quadratic formula can help. What's the equation you're solving?",
        functions:    "Functions map inputs to outputs. Common types: <em>linear</em>, <em>quadratic</em>, <em>polynomial</em>, and <em>exponential</em>. Which one are you studying?",
        quadratic:    "For quadratics: ax² + bx + c = 0, use the quadratic formula: x = (−b ± √(b²−4ac)) / 2a. The discriminant (b²−4ac) tells you how many real roots there are!",
        arithmetic:   "In an arithmetic sequence, each term increases by a constant <em>d</em>. The nth term formula is: aₙ = a₁ + (n−1)d. Need an example?",
        geometric:    "In a geometric sequence, each term is multiplied by a constant ratio <em>r</em>. The nth term is: aₙ = a₁ · rⁿ⁻¹. Want to try one together?",
        'study tips': "Here are my top study tips for math: 1) Practice daily — even 20 minutes helps. 2) Don't just read solutions — work through problems yourself. 3) Review your mistakes carefully. 4) Try teaching the concept to someone else!",
        factor:       "To factor a polynomial, first look for a GCF, then try techniques like grouping, difference of squares, or the AC method for trinomials. What polynomial are you working with?",
    };

    function getBotResponse(text) {
        const lower = text.toLowerCase();
        for (const [key, res] of Object.entries(topicMap)) {
            if (lower.includes(key)) return res;
        }
        return genericResponses[Math.floor(Math.random() * genericResponses.length)];
    }

    function showTyping() {
        removeTyping();
        const t = document.createElement('div');
        t.id = 'typing-indicator';
        t.className = 'typing-indicator';
        t.innerHTML = '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>';
        chatContent.appendChild(t);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    function removeTyping() {
        document.getElementById('typing-indicator')?.remove();
    }

    function appendMessage(text, type) {
        const msg = document.createElement('div');
        msg.className = `msg ${type}`;

        const bbl = document.createElement('div');
        bbl.className = 'msg-bubble';
        bbl.innerHTML = text.replace(/\*(.*?)\*/g, '<em>$1</em>');

        const time = document.createElement('span');
        time.className = 'msg-time';
        time.textContent = getTime();

        msg.appendChild(bbl);
        msg.appendChild(time);
        chatContent.appendChild(msg);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    function showWelcome() {
        if (chatContent.dataset.welcomed) return;
        chatContent.dataset.welcomed = '1';
    }

    function sendMessage(text) {
        const message = text || input?.value.trim();
        if (!message) return;

        appendMessage(message, 'user');
        if (input && !text) input.value = '';

        showTyping();
        const delay = 700 + Math.random() * 600;
        setTimeout(() => {
            removeTyping();
            appendMessage(getBotResponse(message), 'bot');
        }, delay);
    }

    document.getElementById('start-chat-btn')?.addEventListener('click', () => { openChat(); showWelcome(); });
    document.getElementById('sidebar-chat-btn')?.addEventListener('click', () => { openChat(); showWelcome(); });
    document.getElementById('fab-chat')?.addEventListener('click', () => { openChat(); showWelcome(); });

    document.addEventListener('openChatbot', () => { openChat(); showWelcome(); });

    document.getElementById('close-chat')?.addEventListener('click', closeChat);
    document.getElementById('ai-send-btn')?.addEventListener('click', () => sendMessage());

    input?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    chatContent.addEventListener('click', (e) => {
        if (e.target.classList.contains('quick-reply-btn')) {
            sendMessage(e.target.textContent.replace(/[^\w\s]/g, '').trim());
        }
    });

    /* ── Logout — SweetAlert2 ── */
    window.confirmLogout = function () {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will be logged out of your account.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Laravel: document.getElementById('logout-form').submit();
                toast('success', 'Logged out successfully.');
            }
        });
    };

    /* ── Toast utility ── */
    window.toast = function (icon, title) {
        Swal.fire({ icon, title, timer: 2000, timerProgressBar: true, showConfirmButton: false });
    };

    /* ================================
       SUMMATIVE TEST — quiz logic
       ================================ */
    const quizQuestions = [
        { q: "In an arithmetic sequence, the first term is 3 and the common difference is 4. What is the 6th term?", choices: ["19","23","21","17"], answer: 1 },
        { q: "What is the sum of the first 5 terms of the geometric sequence 2, 6, 18, 54, ...?", choices: ["162","242","182","122"], answer: 1 },
        { q: "Which of the following is a polynomial expression?", choices: ["x⁻² + 3", "√x + 2", "3x³ − 2x + 1", "1/x + 5"], answer: 2 },
        { q: "What is the remainder when P(x) = x³ − 2x² + x − 5 is divided by (x − 2)?", choices: ["-3","-1","3","1"], answer: 0 },
        { q: "Factor completely: x² − 9", choices: ["(x−3)²","(x+3)(x−3)","(x−9)(x+1)","(x+3)²"], answer: 1 },
        { q: "Which is the correct form of the quadratic formula?", choices: ["x = (b ± √(b²−4ac)) / 2a","x = (−b ± √(b²+4ac)) / 2a","x = (−b ± √(b²−4ac)) / 2a","x = (−b ± √(b²−4ac)) / a"], answer: 2 },
        { q: "Solve for x: 2^x = 32", choices: ["4","5","6","3"], answer: 1 },
        { q: "What is log₂(64)?", choices: ["5","8","6","7"], answer: 2 },
        { q: "If f(x) = 2x + 3, what is f(4)?", choices: ["10","11","12","9"], answer: 1 },
        { q: "An infinite geometric series converges when the common ratio r satisfies:", choices: ["r > 1","|r| < 1","r = 1","r < 0"], answer: 1 },
    ];

    let quizCurrent = 0;
    let quizAnswers = new Array(quizQuestions.length).fill(null);
    let quizRevealed = false;
    let quizScore = 0;

    function startQuiz() {
        quizCurrent = 0;
        quizAnswers = new Array(quizQuestions.length).fill(null);
        quizScore = 0;
        document.getElementById('quiz-start-screen').style.display = 'none';
        document.getElementById('quiz-question-screen').style.display = 'block';
        document.getElementById('quiz-result-screen').style.display = 'none';
        renderQuestion();
    }

    function renderQuestion() {
        const q = quizQuestions[quizCurrent];
        const total = quizQuestions.length;
        document.getElementById('quiz-q-label').textContent = `Question ${quizCurrent + 1} of ${total}`;
        document.getElementById('quiz-progress-bar').style.width = `${((quizCurrent + 1) / total) * 100}%`;
        document.getElementById('quiz-question-text').textContent = q.q;
        document.getElementById('quiz-score-badge').textContent = `Score: ${quizScore}`;

        const choicesEl = document.getElementById('quiz-choices');
        choicesEl.innerHTML = '';
        const letters = ['A','B','C','D'];
        q.choices.forEach((choice, i) => {
            const btn = document.createElement('button');
            btn.className = 'quiz-choice';
            if (quizAnswers[quizCurrent] === i) btn.classList.add('selected');
            btn.innerHTML = `<span class="choice-letter">${letters[i]}</span>${choice}`;
            btn.addEventListener('click', () => selectAnswer(i));
            choicesEl.appendChild(btn);
        });

        // Prev button visibility
        document.getElementById('quiz-prev-btn').style.opacity = quizCurrent === 0 ? '0.3' : '1';
        document.getElementById('quiz-prev-btn').disabled = quizCurrent === 0;

        // Next vs Submit
        const nextBtn = document.getElementById('quiz-next-btn');
        if (quizCurrent === total - 1) {
            nextBtn.textContent = 'Submit ✓';
        } else {
            nextBtn.textContent = 'Next →';
        }
    }

    function selectAnswer(index) {
        quizAnswers[quizCurrent] = index;
        document.querySelectorAll('.quiz-choice').forEach((btn, i) => {
            btn.classList.toggle('selected', i === index);
            const letter = btn.querySelector('.choice-letter');
            if (i === index) { letter.style.background = 'var(--blue)'; letter.style.color = 'white'; }
            else { letter.style.background = ''; letter.style.color = ''; }
        });
    }

    function quizNext() {
        if (quizAnswers[quizCurrent] === null) {
            toast('warning', 'Please select an answer first!');
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
        if (quizCurrent > 0) {
            quizCurrent--;
            renderQuestion();
        }
    }

    function submitQuiz() {
        quizScore = quizAnswers.reduce((acc, ans, i) => acc + (ans === quizQuestions[i].answer ? 1 : 0), 0);
        const total = quizQuestions.length;
        const pct = Math.round((quizScore / total) * 100);

        document.getElementById('quiz-question-screen').style.display = 'none';
        document.getElementById('quiz-result-screen').style.display = 'block';
        document.getElementById('quiz-result-score').textContent = `${quizScore}/${total}`;

        let emoji = '😢', title = 'Keep Practicing!', msg = 'Review your modules and try again.';
        if (pct >= 90)      { emoji = '🏆'; title = 'Outstanding!';  msg = 'Excellent work! You mastered the material.'; }
        else if (pct >= 75) { emoji = '🎉'; title = 'Great Job!';    msg = 'You passed! Keep reviewing for mastery.'; }
        else if (pct >= 50) { emoji = '👍'; title = 'Good Effort!';  msg = 'Almost there — review your weak areas.'; }

        document.getElementById('quiz-result-emoji').textContent = emoji;
        document.getElementById('quiz-result-title').textContent = title;
        document.getElementById('quiz-result-msg').textContent = `${pct}% — ${msg}`;
    }

    function retakeQuiz() {
        document.getElementById('quiz-result-screen').style.display = 'none';
        startQuiz();
    }

    // Expose quiz functions globally (used inline in HTML)
    window.startQuiz   = startQuiz;
    window.quizNext    = quizNext;
    window.quizPrev    = quizPrev;
    window.retakeQuiz  = retakeQuiz;

});