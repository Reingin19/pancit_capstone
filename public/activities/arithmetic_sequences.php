<?php
// Kunin ang mode (pre, lesson, o post) mula sa URL
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'pre';

$questions_data = [
    "pre" => [
        ["q" => "What is the next number in the pattern: 0, 4, 8, 12, 16, ___?", "choices" => ["18", "20", "22", "24"], "answer" => 1],
        ["q" => "In the sequence 9, 4, -1, -6, -11, what is the next number?", "choices" => ["-15", "-16", "-17", "-12"], "answer" => 1],
        ["q" => "If a pattern follows 'multiply by 3', what is after 1, 3, 9, 27, 81?", "choices" => ["162", "243", "124", "324"], "answer" => 1],
        ["q" => "What is the 10th number in the sequence 0, 4, 8, 12, 16...?", "choices" => ["32", "36", "40", "44"], "answer" => 1],
        ["q" => "In the sequence 160, 80, 40, 20, 10, what is the next term?", "choices" => ["0", "5", "2", "1"], "answer" => 1],
    ],
    "post" => [
        ["q" => "Find the common difference (d) in the sequence: 5, 12, 19, 26...", "choices" => ["5", "6", "7", "8"], "answer" => 2],
        ["q" => "Which formula is used for Arithmetic Sequences?", "choices" => ["an = a1 + (n-1)d", "an = a1 * r^(n-1)", "a^2 + b^2 = c^2", "an = d + (a1-1)n"], "answer" => 0],
        ["q" => "If a1 = 10 and d = -3, what is the 4th term?", "choices" => ["1", "4", "7", "13"], "answer" => 0],
    ]
];

$current_questions = ($mode === 'post') ? $questions_data['post'] : $questions_data['pre'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arithmetic Activity</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f0ebf8; padding: 15px; font-family: sans-serif; }
        .form-card { background: white; border-radius: 8px; border: 1px solid #dadce0; margin-bottom: 12px; padding: 20px; }
        .form-header { border-top: 10px solid #673ab7; }
        .choice-row { display: flex; align-items: center; padding: 12px; cursor: pointer; border-radius: 4px; border: 1px solid transparent; }
        .choice-row:hover { background: #f8f9fa; }
        .active { border: 1px solid #673ab7; background: #f0ebf8; }
        .radio-circle { height: 18px; width: 18px; border: 2px solid #5f6368; border-radius: 50%; margin-right: 12px; }
        .active .radio-circle { border-color: #673ab7; background: radial-gradient(#673ab7 50%, transparent 50%); }
        .correct { border-left: 6px solid #1e8e3e; background: #e6f4ea; }
        .wrong { border-left: 6px solid #d93025; background: #fce8e6; }
    </style>
</head>
<body>
    <div class="max-w-2xl mx-auto">
        <?php if ($mode === 'lesson'): ?>
            <div class="form-card form-header">
                <h1 class="text-2xl font-bold text-slate-800">Arithmetic Sequences Lesson</h1>
                <p class="text-gray-600 mt-2">Basahin muna bago ang Post-test.</p>
            </div>
            <div class="form-card leading-relaxed">
                <h2 class="text-lg font-bold text-indigo-700">The Basics</h2>
                <p class="mt-2 text-slate-700 text-sm">Ang Arithmetic Sequence ay may **constant common difference (d)**. Ibig sabihin, pare-pareho ang dagdag sa bawat term.</p>
                <div class="bg-indigo-50 p-4 my-4 font-mono text-center rounded italic border border-indigo-100">
                    Formula: a<sub>n</sub> = a<sub>1</sub> + (n-1)d
                </div>
                <button onclick="window.location.href='arithmetic_sequences.php?mode=post'" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold mt-4">Take Post-test →</button>
            </div>
        <?php else: ?>
            <div class="form-card form-header">
                <h1 class="text-2xl font-semibold text-black uppercase tracking-tight"><?php echo $mode; ?>-test: Sequences</h1>
            </div>
            <div id="quiz-content"></div>
            <div id="footer-actions" class="mt-4">
                <button onclick="submitQuiz()" class="w-full bg-[#673ab7] text-white py-3 rounded-md font-bold shadow-lg">Submit Answers</button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const questions = <?php echo json_encode($current_questions); ?>;
        let userAnswers = new Array(questions.length).fill(null);

        if (document.getElementById('quiz-content')) {
            document.getElementById('quiz-content').innerHTML = questions.map((q, i) => `
                <div class="form-card" id="q-box-${i}">
                    <div class="mb-4 font-medium text-slate-800">${i+1}. ${q.q}</div>
                    ${q.choices.map((c, ci) => `
                        <div class="choice-row" id="c-${i}-${ci}" onclick="selectAns(${i},${ci})">
                            <div class="radio-circle"></div><span>${c}</span>
                        </div>
                    `).join('')}
                    <div id="msg-${i}" class="mt-2 hidden text-xs font-bold p-2 rounded"></div>
                </div>
            `).join('');
        }

        window.selectAns = (qi, ci) => {
            userAnswers[qi] = ci;
            document.querySelectorAll(`[id^="c-${qi}-"]`).forEach(el => el.classList.remove('active'));
            document.getElementById(`c-${qi}-${ci}`).classList.add('active');
        };

        window.submitQuiz = () => {
            if (userAnswers.includes(null)) return alert("Sagutan lahat!");
            let score = 0;
            questions.forEach((q, i) => {
                const box = document.getElementById(`q-box-${i}`);
                const msg = document.getElementById(`msg-${i}`);
                msg.classList.remove('hidden');
                if (userAnswers[i] === q.answer) {
                    score++; box.classList.add('correct'); msg.innerHTML = "Correct!"; msg.classList.add('text-green-700');
                } else {
                    box.classList.add('wrong'); msg.innerHTML = "Wrong. Correct: " + q.choices[q.answer]; msg.classList.add('text-red-700');
                }
            });
            window.scrollTo({top: 0, behavior: 'smooth'});
            const isPre = "<?php echo $mode; ?>" === 'pre';
            document.getElementById('footer-actions').innerHTML = `
                <div class="form-card text-center border-t-4 border-indigo-500">
                    <p class="text-sm text-gray-500">Score</p>
                    <h2 class="text-4xl font-black text-indigo-700 mb-4">${score}/${questions.length}</h2>
                    <button onclick="window.location.href='arithmetic_sequences.php?mode=${isPre ? 'lesson' : 'post'}'" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold">
                        ${isPre ? 'Proceed to Lesson' : 'Try Post-test Again'}
                    </button>
                </div>`;
        };
    </script>
</body>
</html>