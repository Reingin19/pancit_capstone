/* ================================
   resources/js/chatbot.js
   ================================ */

import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function () {

    const chatWindow  = document.getElementById('ai-chat-window');
    const chatContent = document.getElementById('chat-content');
    const input       = document.getElementById('ai-input');
    let isOpen = false;

    /* ── Helpers ── */
    function getTime() {
        return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    /* ── Open / Close ── */
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

    /* ── Bot Responses ── */
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

    /* ── Typing Indicator ── */
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

    /* ── Append Message ── */
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

    /* ── Welcome ── */
    function showWelcome() {
        if (chatContent.dataset.welcomed) return;
        chatContent.dataset.welcomed = '1';
    }

    /* ── Send Message ── */
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

    /* ── Event Listeners ── */
    document.getElementById('start-chat-btn')?.addEventListener('click',   () => { openChat(); showWelcome(); });
    document.getElementById('sidebar-chat-btn')?.addEventListener('click', () => { openChat(); showWelcome(); });
    document.getElementById('fab-chat')?.addEventListener('click',         () => { openChat(); showWelcome(); });
    document.addEventListener('openChatbot',                               () => { openChat(); showWelcome(); });

    document.getElementById('close-chat')?.addEventListener('click', closeChat);
    document.getElementById('ai-send-btn')?.addEventListener('click', () => sendMessage());

    input?.addEventListener('keypress', e => {
        if (e.key === 'Enter') sendMessage();
    });

    chatContent.addEventListener('click', e => {
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
            cancelButtonText: 'Cancel',
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Logged out',
                    text: 'Goodbye!',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                }).then(() => {
                    document.getElementById('logout-form').submit();
                });
            }
        });
    };

    /* ── Toast utility ── */
    window.toast = function (icon, title) {
        Swal.fire({ icon, title, timer: 2000, timerProgressBar: true, showConfirmButton: false });
    };

});