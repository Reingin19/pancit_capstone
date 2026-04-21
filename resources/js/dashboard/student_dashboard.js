import { supabase } from './supabaseClient';

// Global states
window.studentModules = [];

document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================
       1. NAVIGATION LOGIC
       ========================================== */
    window.navigate = function(page) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        const target = document.getElementById('page-' + page);
        if (target) target.classList.add('active');

        document.querySelectorAll('.nav-item[data-page], .sidebar-item[data-page]').forEach(b => {
            b.classList.toggle('active', b.dataset.page === page);
        });

        if (page === 'modules') {
            loadModulesForStudent();
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    /* ==========================================
       2. ARITHMETIC MODULE HANDLER (FIXED FOR 404)
       ========================================== */
    window.toggleArithmeticContent = function() {
        console.log("Toggle arithmetic triggered");
        
        const dropdown = document.getElementById('arithmetic-dropdown');
        const iframe = document.getElementById('arithmetic-frame');
        const arrow = document.getElementById('arrow-arithmetic');
        
        if (!dropdown || !iframe) {
            console.error("Missing elements: arithmetic-dropdown or arithmetic-frame");
            return;
        }

        // DYNAMIC PATH LOGIC: 
        // Siguraduhin na ang path ay relative sa root ng project mo.
        const currentPath = window.location.pathname;
        const directory = currentPath.substring(0, currentPath.lastIndexOf('/'));
        const targetFile = "/activities/arithmetic_sequences.php?mode=pre";
        const fullURL = window.location.origin + directory + targetFile;

        const isHidden = dropdown.style.display === "none" || dropdown.style.display === "";

        if (isHidden) {
            // I-load lang ang iframe kung wala pa itong content o "about:blank"
            if (!iframe.src || iframe.src === "" || iframe.src.includes("undefined")) {
                console.log("Loading activity from:", fullURL);
                iframe.src = fullURL;
            }
            
            dropdown.style.display = "block";
            if (arrow) arrow.style.transform = "rotate(180deg)";
        } else {
            dropdown.style.display = "none";
            if (arrow) arrow.style.transform = "rotate(0deg)";
        }
    };

    /* ==========================================
       3. DYNAMIC STORAGE (SUPABASE)
       ========================================== */
    async function loadModulesForStudent() {
        const detailedList = document.getElementById('dynamic-detailed-modules');
        if (!detailedList) return;

        try {
            const { data, error } = await supabase.storage.from('modules').list();
            if (error) throw error;

            window.studentModules = data.map(file => {
                const { data: urlData } = supabase.storage.from('modules').getPublicUrl(file.name);
                return {
                    id: file.id,
                    title: file.name.includes('_') ? file.name.split('_').slice(1).join('_') : file.name,
                    file_url: urlData.publicUrl
                };
            });
            renderStudentModules();
        } catch (err) {
            console.error("Error loading student modules:", err.message);
        }
    }

    function renderStudentModules() {
        const detailedList = document.getElementById('dynamic-detailed-modules');
        if (!detailedList) return;
        detailedList.innerHTML = '';

        if (window.studentModules.length === 0) {
            detailedList.innerHTML = `<p class="text-center p-10 text-slate-400">No learning modules available yet.</p>`;
            return;
        }

        window.studentModules.forEach((mod, index) => {
            const section = document.createElement('section');
            section.className = "modules-container";
            section.style = "margin-bottom: 2rem; background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);";
            
            section.innerHTML = `
                <div class="section-label" style="font-weight: bold; color: #4f46e5; font-size: 1.1rem; margin-bottom: 12px;">
                    Module ${index + 1}: ${mod.title}
                </div>
                <ul class="topic-list" style="list-style: none; padding: 0; margin: 0;">
                    <li class="topic-item" style="display: flex; align-items: center; gap: 12px; padding: 15px; background: #f8fafc; border-radius: 8px; cursor: pointer; transition: background 0.2s;" 
                        onclick="window.previewPDF('${mod.file_url}', '${mod.title}')"
                        onmouseover="this.style.background='#f1f5f9'" 
                        onmouseout="this.style.background='#f8fafc'">
                        <span class="topic-dot" style="height: 10px; width: 10px; background: #ef4444; border-radius: 50%;"></span>
                        <div style="flex-grow: 1;">
                            <span style="font-weight: 600; color: #1e293b; display: block;">${mod.title}</span>
                            <span style="font-size: 0.75rem; color: #2563eb; display: flex; align-items: center; gap: 4px;">
                                📄 Open Learning Module (PDF)
                            </span>
                        </div>
                    </li>
                </ul>
            `;
            detailedList.appendChild(section);
        });
    }

    /* ==========================================
       4. MODAL & PREVIEW HANDLERS
       ========================================== */
    window.previewPDF = function(url, title) {
        const modal = document.getElementById('modal-preview-pdf');
        const iframe = document.getElementById('pdf-viewer');
        const titleHeader = document.getElementById('preview-title');

        if (modal && iframe) {
            titleHeader.innerText = title;
            iframe.src = url;
            modal.style.display = 'flex'; 
            modal.style.position = 'fixed';
            modal.style.zIndex = '9999';
            document.body.style.overflow = 'hidden';
        } else {
            // Fallback kung walang modal elements
            window.open(url, '_blank');
        }
    };

    window.closeModal = function(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            
            // Clean up iframe src para tumigil ang loading
            const iframe = modal.querySelector('iframe');
            if (iframe) iframe.src = ''; 
        }
    };

    // Initial Load
    loadModulesForStudent();
});