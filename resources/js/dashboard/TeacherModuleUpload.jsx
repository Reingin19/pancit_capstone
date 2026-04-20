import React, { useState } from 'react';
import { supabase } from './supabaseClient'; // Siguraduhing tama ang path nito
import { Plus, Trash2, Save, RefreshCw, UploadCloud, CheckCircle, XCircle } from 'lucide-react';

const TeacherModuleLogic = () => {
    const [loading, setLoading] = useState(false);
    const [aiData, setAiData] = useState(null);
    const [title, setTitle] = useState("");

    // 1. GENERATE DATA FROM GEMINI AI
    const handleGenerate = async () => {
        if (!title) return alert("Please enter a Module Title first!");
        setLoading(true);
        try {
            const res = await fetch('/api/generate-quiz', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ pdf_url: title }) // O link ng PDF mo
            });
            const data = await res.json();
            setAiData(data); // Pre-test, main_content_summary, post_test
        } catch (err) {
            alert("Connection Error: " + err.message);
        } finally {
            setLoading(false);
        }
    };

    // 2. EDITING LOGIC (Universal for Pre-test and Post-test)
    const updateQuestion = (type, qIdx, field, value) => {
        const newData = { ...aiData };
        newData[type][qIdx][field] = value;
        setAiData(newData);
    };

    const updateOption = (type, qIdx, oIdx, value) => {
        const newData = { ...aiData };
        newData[type][qIdx].options[oIdx] = value;
        setAiData(newData);
    };

    const addQuestion = (type) => {
        const newData = { ...aiData };
        newData[type].push({ 
            question: "New Question Text Here?", 
            options: ["Option A", "Option B", "Option C", "Option D"], 
            correct_answer: "Option A" 
        });
        setAiData(newData);
    };

    const deleteQuestion = (type, idx) => {
        if(window.confirm("Delete this question?")) {
            const newData = { ...aiData };
            newData[type] = newData[type].filter((_, i) => i !== idx);
            setAiData(newData);
        }
    };

    // 3. PUBLISH TO SUPABASE
    const handlePublish = async () => {
        setLoading(true);
        try {
            const { error } = await supabase
                .from('module_assessments')
                .insert([{
                    title: title,
                    pre_test: aiData.pre_test,
                    post_test: aiData.post_test,
                    content_summary: aiData.main_content_summary,
                    status: 'published'
                }]);

            if (error) throw error;
            alert("Successfully Published! Students can now access this module.");
            window.location.reload();
        } catch (error) {
            alert("Database Error: " + error.message);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="w-full max-w-4xl mx-auto p-4 pb-20">
            {/* --- UPLOAD / TITLE INPUT --- */}
            {!aiData && !loading && (
                <div className="bg-white p-12 border-4 border-dashed border-slate-200 rounded-3xl text-center shadow-sm">
                    <h2 className="text-xl font-bold text-slate-700 mb-6">Create New Learning Module</h2>
                    <input 
                        className="w-full max-w-md text-center text-xl p-3 border-b-2 border-indigo-200 focus:border-indigo-600 outline-none mb-8" 
                        placeholder="Enter Module Title (e.g. Arithmetic Sequences)"
                        value={title}
                        onChange={(e) => setTitle(e.target.value)}
                    />
                    <button 
                        onClick={handleGenerate} 
                        className="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-bold flex items-center gap-3 mx-auto hover:scale-105 transition-all shadow-lg"
                    >
                        <UploadCloud size={24}/> Generate AI Assessment
                    </button>
                </div>
            )}

            {/* --- LOADING SPINNER --- */}
            {loading && (
                <div className="text-center p-20 bg-white rounded-3xl border shadow-md animate-pulse">
                    <RefreshCw className="animate-spin mx-auto text-indigo-600 mb-6" size={50} />
                    <p className="text-2xl font-black text-slate-800">Gemini AI is analyzing...</p>
                    <p className="text-slate-500 mt-2">Generating questions and topic summary.</p>
                </div>
            )}

            {/* --- EDITABLE PREVIEW TABLE --- */}
            {aiData && !loading && (
                <div className="space-y-8 animate-in slide-in-from-bottom-5 duration-700">
                    <div className="flex justify-between items-center bg-white p-6 rounded-2xl border sticky top-4 z-[100] shadow-xl">
                        <div>
                            <h3 className="font-black text-slate-800 text-xl">{title}</h3>
                            <p className="text-sm text-green-600 font-bold">● AI Generation Complete</p>
                        </div>
                        <div className="flex gap-3">
                            <button onClick={() => setAiData(null)} className="px-4 py-2 text-slate-400 hover:text-red-500 font-bold">Cancel</button>
                            <button onClick={handlePublish} className="bg-green-600 text-white px-10 py-3 rounded-xl font-black flex items-center gap-2 hover:bg-green-700 transition shadow-lg">
                                <Save size={20}/> Publish to Students
                            </button>
                        </div>
                    </div>

                    {/* SECTION: PRE-TEST */}
                    <div className="space-y-4">
                        <div className="flex items-center gap-2 text-indigo-600 mb-2">
                            <CheckCircle size={20}/>
                            <h4 className="font-black uppercase tracking-widest">Step 1: Pre-test Questions</h4>
                        </div>
                        
                        {aiData.pre_test.map((q, idx) => (
                            <div key={idx} className="bg-white p-8 rounded-3xl border border-slate-200 relative group shadow-sm hover:border-indigo-300 transition">
                                <button onClick={() => deleteQuestion('pre_test', idx)} className="absolute top-6 right-6 text-slate-300 hover:text-red-500"><Trash2 size={20}/></button>
                                
                                <div className="mb-6">
                                    <span className="text-xs font-black text-indigo-400 block mb-2 uppercase">Question #{idx + 1}</span>
                                    <input 
                                        className="w-full text-lg font-bold text-slate-800 bg-slate-50 rounded-xl p-4 focus:ring-4 focus:ring-indigo-100 outline-none border-none"
                                        value={q.question}
                                        onChange={(e) => updateQuestion('pre_test', idx, 'question', e.target.value)}
                                    />
                                </div>

                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {q.options.map((opt, oIdx) => (
                                        <div key={oIdx} className="flex items-center gap-3">
                                            <input 
                                                type="radio" 
                                                className="w-5 h-5 text-indigo-600"
                                                checked={opt === q.correct_answer}
                                                onChange={() => updateQuestion('pre_test', idx, 'correct_answer', opt)}
                                            />
                                            <input 
                                                className={`w-full p-3 rounded-xl border text-sm font-medium transition-all ${opt === q.correct_answer ? 'border-green-500 bg-green-50 ring-2 ring-green-100' : 'border-slate-100 bg-white'}`}
                                                value={opt}
                                                onChange={(e) => updateOption('pre_test', idx, oIdx, e.target.value)}
                                            />
                                        </div>
                                    ))}
                                </div>
                            </div>
                        ))}
                        
                        <button onClick={() => addQuestion('pre_test')} className="w-full py-5 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400 font-black hover:bg-white hover:border-indigo-400 hover:text-indigo-400 transition-all">
                            + ADD NEW QUESTION
                        </button>
                    </div>

                    {/* SECTION: SUMMARY */}
                    <div className="p-8 bg-white rounded-3xl border border-slate-200 shadow-sm">
                        <h4 className="font-black text-slate-700 mb-4 uppercase tracking-widest">Step 2: Topic Summary</h4>
                        <textarea 
                            className="w-full h-40 p-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none text-slate-600 leading-relaxed"
                            value={aiData.main_content_summary}
                            onChange={(e) => {
                                const newData = {...aiData};
                                newData.main_content_summary = e.target.value;
                                setAiData(newData);
                            }}
                        />
                    </div>
                </div>
            )}
        </div>
    );
};

export default TeacherModuleLogic;