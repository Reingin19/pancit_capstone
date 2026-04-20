import { supabase } from './supabaseClient';

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

        if (page === 'modules') {
            loadModulesForStudent();
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.querySelectorAll('[data-page]').forEach(btn => {
        btn.addEventListener('click', function () {
            navigate(this.dataset.page);
        });
    });

    window.navigate = navigate;
}); 

/* ==========================================
   STUDENT SIDE: DYNAMIC DASHBOARD (STORAGE)
   ========================================== */
window.studentModules = [];

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
        section.style = "margin-bottom: 2rem; background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);";
        
        section.innerHTML = `
            <div class="section-label" style="font-weight: bold; color: #4f46e5; font-size: 1.1rem; margin-bottom: 5px;">
                Module ${index + 1}: ${mod.title}
            </div>
            <div class="section-sub" style="color: #64748b; font-size: 0.85rem; margin-bottom: 15px;">Mathematics Learning Resource</div>
            
            <ul class="topic-list" style="list-style: none; padding: 0;">
                <li class="topic-item" style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #f8fafc; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                    onclick="window.previewPDF('${mod.file_url}', '${mod.title}')">
                    <span class="topic-dot" style="height: 10px; width: 10px; background: #ef4444; border-radius: 50%;"></span>
                    <div style="flex-grow: 1;">
                        <span style="font-weight: 600; color: #1e293b; display: block;">${mod.title}</span>
                        <span style="font-size: 0.75rem; color: #2563eb;">📄 Open Lesson PDF</span>
                    </div>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                </li>
            </ul>
        `;
        detailedList.appendChild(section);
    });
}

/* ==========================================
   PDF PREVIEW LOGIC (Full Screen Overlay)
   ========================================== */
window.previewPDF = function(url, title) {
    const modal = document.getElementById('modal-preview-pdf');
    const iframe = document.getElementById('pdf-viewer');
    const titleHeader = document.getElementById('preview-title');

    if (modal && iframe) {
        titleHeader.innerText = title;
        iframe.src = url;
        
        // Full screen styles para hindi mag-new tab
        modal.style.display = 'flex'; 
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100vw';
        modal.style.height = '100vh';
        modal.style.zIndex = '9999';
        modal.style.backgroundColor = 'rgba(0,0,0,0.85)';
        modal.style.justifyContent = 'center';
        modal.style.alignItems = 'center';
    } else {
        // Fallback kung hindi mahanap yung modal elements
        window.open(url, '_blank');
    }
};

window.closeModal = function(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
        if (id === 'modal-preview-pdf') {
            const iframe = document.getElementById('pdf-viewer');
            if (iframe) iframe.src = ''; 
        }
    }
};

// INITIAL LOAD
document.addEventListener('DOMContentLoaded', () => {
    loadModulesForStudent();
});