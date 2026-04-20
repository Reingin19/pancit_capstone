import React, { useState } from 'react';
import { Lock, Unlock, PlayCircle, FileText, ChevronDown } from 'lucide-react';

// Dagdagan natin ng props: questions, summary, at initialStatus
const ModuleItem = ({ title, preTestQuestions, contentSummary, postTestQuestions }) => {
    const [isOpen, setIsOpen] = useState(false);
    
    // Status can be: 'locked' (Pre-test), 'unlocked' (Content), 'final' (Post-test)
    const [status, setStatus] = useState('locked'); 

    const handleStartPreTest = (e) => {
        e.stopPropagation();
        // Dito lalabas dapat yung Modal na may questions galing sa AI
        alert("Starting Pre-test with AI questions...");
        setStatus('unlocked'); // Temporary bypass para makita mo ang effect
    };

    return (
        <div className="mb-2 border border-slate-100 rounded-lg bg-white overflow-hidden shadow-sm">
            {/* Clickable Header */}
            <div 
                onClick={() => setIsOpen(!isOpen)}
                className="p-4 flex justify-between items-center cursor-pointer hover:bg-slate-50 transition"
            >
                <div className="flex items-center gap-3">
                    <div className={`w-2 h-2 rounded-full ${status !== 'locked' ? 'bg-green-400' : 'bg-slate-300'}`}></div>
                    <span className="text-slate-700 font-medium">{title}</span>
                </div>
                <ChevronDown size={18} className={`text-slate-400 transition-transform ${isOpen ? 'rotate-180' : ''}`} />
            </div>

            {/* Dropdown Content */}
            {isOpen && (
                <div className="px-4 pb-4 bg-slate-50 flex flex-col gap-2">
                    <div className="h-[1px] bg-slate-200 mb-2"></div>
                    
                    {/* STEP 1: PRE-TEST */}
                    <div className="flex items-center justify-between p-3 bg-white rounded-md border border-slate-200">
                        <div className="flex items-center gap-2 text-sm">
                            <PlayCircle size={16} className="text-blue-500" />
                            <div className="flex flex-col">
                                <span className="font-bold text-slate-700">Pre-test</span>
                                <span className="text-[10px] text-slate-400">5 Questions from AI</span>
                            </div>
                        </div>
                        <button 
                            onClick={handleStartPreTest}
                            className={`text-[10px] px-3 py-1 rounded-md uppercase font-bold ${
                                status === 'locked' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-400'
                            }`}
                        >
                            {status === 'locked' ? 'Start' : 'Completed ✅'}
                        </button>
                    </div>

                    {/* STEP 2: CONTENT (Unlocked after Pre-test) */}
                    <div className={`flex items-center justify-between p-3 rounded-md border ${status !== 'locked' ? 'bg-white border-slate-200 shadow-sm' : 'bg-slate-50 opacity-50'}`}>
                        <div className="flex items-center gap-2 text-sm font-medium">
                            {status !== 'locked' ? <Unlock size={16} className="text-green-500"/> : <Lock size={16} className="text-slate-400"/>}
                            <span>Lesson Content</span>
                        </div>
                        {status !== 'locked' && (
                            <button className="text-[10px] border border-blue-600 text-blue-600 px-3 py-1 rounded-md uppercase font-bold hover:bg-blue-50">
                                Open PDF
                            </button>
                        )}
                    </div>

                    {/* STEP 3: POST-TEST */}
                    <div className={`flex items-center justify-between p-3 rounded-md border ${status !== 'locked' ? 'bg-white border-slate-200 shadow-sm' : 'bg-slate-50 opacity-50'}`}>
                        <div className="flex items-center gap-2 text-sm font-medium">
                            <Lock size={16} className="text-slate-400"/>
                            <span>Post-test</span>
                        </div>
                        {status !== 'locked' && (
                            <button className="text-[10px] bg-slate-800 text-white px-3 py-1 rounded-md uppercase font-bold">
                                Start Final Quiz
                            </button>
                        )}
                    </div>
                </div>
            )}
        </div>
    );
};

export default ModuleItem;