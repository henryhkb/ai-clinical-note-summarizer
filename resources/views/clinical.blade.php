<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New summary · Clinical Notes</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com/3.4.5"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                    colors: {
                        canvas: '#F3F5F8',
                        line: '#E4E8EE',
                        ink: '#101828',
                        sub: '#475467',
                        hint: '#98A2B3',
                        accent: { 50: '#EEF4FF', 100: '#DCE7FE', 500: '#3B82F6', 600: '#2563EB', 700: '#1D4ED8' },
                    },
                    boxShadow: { card: '0 1px 2px rgba(16,24,40,.04)' },
                },
            },
        };
    </script>

    <style>
        html { color-scheme: light; }
        body { font-feature-settings: "cv11"; }
        textarea { resize: none; }

        /* Summary body */
        #result { font-size: 14px; line-height: 1.6; color: #101828; }
        #result h1, #result h2, #result h3 {
            display: flex; align-items: center; gap: .5rem;
            font-size: 13px; font-weight: 600; color: #101828;
            margin: 1.5rem 0 .6rem;
        }
        #result h2:first-child, #result h1:first-child, #result h3:first-child { margin-top: 0; }
        #result h2 .sec-dot { width: 6px; height: 6px; border-radius: 9999px; }
        #result p { margin: .4rem 0; color: #344054; }
        #result ul { margin: 0; padding: 0; list-style: none; }
        #result ul > li {
            position: relative; padding: .55rem .75rem .55rem 1.6rem; margin: 0;
            border-bottom: 1px solid #F0F2F5; color: #344054;
        }
        #result ul > li:last-child { border-bottom: 0; }
        #result ul > li::before {
            content: ""; position: absolute; left: .75rem; top: 1.15em;
            width: 4px; height: 4px; border-radius: 9999px; background: #98A2B3;
        }
        #result ol { margin: 0; padding: 0; list-style: none; counter-reset: step; }
        #result ol > li {
            counter-increment: step; position: relative;
            padding: .5rem .25rem .5rem 2.25rem; color: #344054;
        }
        #result ol > li::before {
            content: counter(step); position: absolute; left: 0; top: .5rem;
            width: 1.4rem; height: 1.4rem; border-radius: 9999px;
            display: grid; place-items: center;
            font-size: 11px; font-weight: 600; color: #475467; background: #F2F4F7;
        }
        #result strong { font-weight: 600; color: #101828; }
        #result .sec { border: 1px solid #E4E8EE; border-radius: 12px; background: #fff; }
        #result .sec + .sec, #result h2 + .sec { margin-top: 0; }
        #result table { width: 100%; border-collapse: collapse; font-size: 13px; margin: .5rem 0; }
        #result th, #result td { border-bottom: 1px solid #F0F2F5; padding: .45rem .5rem; text-align: left; }
        #result code { font-size: 12px; background: #F2F4F7; padding: .1rem .3rem; border-radius: 4px; }

        /* Section heading icons */
        #result .sec-icon { width: 22px; height: 22px; border-radius: 6px; display: grid; place-items: center; flex-shrink: 0; }
        #result .sec-icon svg { width: 13px; height: 13px; }

        /* Icon rows (findings + follow-up) */
        #result ol.sec > li { border-bottom: 1px solid #F0F2F5; }
        #result ol.sec > li:last-child { border-bottom: 0; }
        #result li.ico { display: flex; align-items: flex-start; gap: .7rem; padding: .6rem .75rem; }
        #result li.ico::before { content: none; }
        #result .ico-tile { width: 28px; height: 28px; border-radius: 8px; display: grid; place-items: center; flex-shrink: 0; }
        #result .ico-tile svg { width: 15px; height: 15px; }
        #result .ico-num { width: .9rem; flex-shrink: 0; padding-top: .3rem; text-align: right; font-size: 11px; font-weight: 600; color: #98A2B3; font-variant-numeric: tabular-nums; }
        #result .ico-body { flex: 1; min-width: 0; padding-top: .2rem; }
        #result .ico-tag { flex-shrink: 0; margin-top: .3rem; padding: .05rem .45rem; border-radius: 9999px; font-size: 11px; font-weight: 500; white-space: nowrap; }
        @media (max-width: 640px) { #result .ico-tag { display: none; } }

        .shimmer { background: linear-gradient(90deg, #EEF1F5 0%, #F7F8FA 50%, #EEF1F5 100%); background-size: 200% 100%; animation: sh 1.4s linear infinite; }
        @keyframes sh { to { background-position: -200% 0; } }
        @media (prefers-reduced-motion: reduce) { .shimmer { animation: none; } }

        @media print {
            body { background: #fff !important; }
            .no-print { display: none !important; }
            #shell { display: block !important; }
            #workspace { display: block !important; padding: 0 !important; }
            #outputPanel { border: 0 !important; box-shadow: none !important; }
        }
    </style>
</head>

<body class="bg-canvas font-sans text-[14px] text-ink antialiased">

<div id="shell" class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="no-print hidden w-60 shrink-0 flex-col border-r border-line bg-white md:flex">
        <div class="flex h-14 items-center gap-2.5 border-b border-line px-4">
            <div class="grid h-7 w-7 place-items-center rounded-lg bg-accent-600 text-white">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l2-5 4 10 2-5h6"/></svg>
            </div>
            <span class="text-[14px] font-semibold">Clinical Notes</span>
        </div>

        <nav class="px-3 pt-3">
            <button type="button" id="navNew"
                    class="flex w-full items-center gap-2.5 rounded-lg bg-canvas px-2.5 py-2 text-left text-[13px] font-medium text-ink">
                <svg class="h-4 w-4 text-sub" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8z"/><path d="M14 3v5h5M12 12v6M9 15h6"/></svg>
                New summary
            </button>
        </nav>

        <div class="mt-5 flex items-center justify-between px-5 text-[12px] text-hint">
            <span>Recent</span>
            <span id="recentCount" class="tabular-nums"></span>
        </div>
        <p id="recentEmpty" class="mt-1.5 px-5 text-[12px] leading-relaxed text-hint">Summaries you create appear here.</p>
        <ul id="recentList" class="mt-1.5 flex-1 space-y-0.5 overflow-y-auto px-3 pb-3"></ul>

        <div class="border-t border-line px-4 py-3 text-[12px] leading-relaxed text-sub">
            <div class="flex items-center gap-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                <span class="font-medium text-ink">{{ config('services.groq.model') }}</span>
            </div>
            <p class="mt-0.5 text-hint">via Groq · nothing is sent elsewhere</p>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex min-w-0 flex-1 flex-col">

        <!-- Top bar -->
        <header class="no-print flex h-14 items-center justify-between border-b border-line bg-white px-4 sm:px-6">
            <div class="flex items-center gap-1.5 text-[13px]">
                <span class="text-hint">Summaries</span>
                <svg class="h-3.5 w-3.5 text-hint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 6l6 6-6 6"/></svg>
                <span id="crumb" class="font-medium">New summary</span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" id="sampleBtn"
                        class="rounded-lg border border-line bg-white px-3 py-1.5 text-[13px] font-medium text-sub shadow-card hover:bg-canvas">
                    Load sample note
                </button>
            </div>
        </header>

        <main id="workspace" class="grid flex-1 gap-4 p-4 sm:p-6 xl:grid-cols-[minmax(0,5fr)_minmax(0,6fr)]">

            <!-- Source note -->
            <section class="no-print flex min-h-[34rem] flex-col rounded-2xl xl:sticky xl:top-6 xl:h-[calc(100vh-6.5rem)] xl:self-start border border-line bg-white shadow-card">
                <div class="flex items-center gap-3 border-b border-line px-5 py-4">
                    <div class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-[#FDF0F4] text-[#C4456B]">
                        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 10h6M9 14h6M9 18h3"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-[14px] font-semibold">Source note</h2>
                        <p id="sourceMeta" class="truncate text-[12px] text-hint">Paste text or upload a file</p>
                    </div>
                    <button type="button" id="clearBtn" class="rounded-md px-2 py-1 text-[12px] font-medium text-sub hover:bg-canvas">Clear</button>
                </div>

                <!-- Upload -->
                <div class="px-5 pt-4">
                    <div id="dropzone" class="flex items-center gap-3 rounded-xl border border-dashed border-[#D0D5DD] px-4 py-3 transition-colors">
                        <input type="file" id="fileInput" class="sr-only"
                               accept=".txt,.md,.pdf,.docx,text/plain,text/markdown,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <div id="dropIdle" class="flex min-w-0 flex-1 items-center gap-3">
                            <div class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-accent-50 text-accent-600">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15V4M8 8l4-4 4 4M5 15v3a2 2 0 002 2h10a2 2 0 002-2v-3"/></svg>
                            </div>
                            <div class="min-w-0 text-[13px]">
                                <p class="text-ink"><span class="font-medium">Drop a file</span> <span class="text-sub">or</span>
                                    <label for="fileInput" class="cursor-pointer font-medium text-accent-600 hover:text-accent-700">browse</label></p>
                                <p class="text-[12px] text-hint">PDF, DOCX, TXT or MD · up to 5 MB</p>
                            </div>
                        </div>
                        <div id="dropBusy" class="hidden flex-1 items-center gap-2 text-[13px] text-sub">
                            <svg class="h-4 w-4 animate-spin text-accent-600" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" class="opacity-20"/><path d="M21 12a9 9 0 00-9-9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            Extracting text…
                        </div>
                    </div>

                    <div id="fileChip" class="mt-2 hidden items-center gap-3 rounded-xl border border-line px-3 py-2">
                        <div class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-canvas text-[10px] font-semibold uppercase text-sub" id="fileExt">TXT</div>
                        <div class="min-w-0 flex-1">
                            <p id="fileName" class="truncate text-[13px] font-medium"></p>
                            <p id="fileMeta" class="text-[12px] text-hint"></p>
                        </div>
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-medium text-emerald-700">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12l5 5L20 7"/></svg>Text extracted
                        </span>
                        <button type="button" id="fileRemove" title="Remove file" class="rounded-md p-1 text-hint hover:bg-canvas hover:text-ink">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex flex-1 flex-col px-5 pb-4 pt-3">
                    <textarea id="note" maxlength="20000"
                              class="min-h-[16rem] w-full flex-1 rounded-xl border border-line bg-[#FAFBFC] px-3.5 py-3 text-[13px] leading-relaxed text-ink placeholder:text-hint focus:border-accent-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-accent-500/10"
                              placeholder="Paste the clinical note…"></textarea>
                    <div class="mt-2 flex items-center justify-between text-[12px] text-hint">
                        <span>Remove names, MRNs and dates of birth first.</span>
                        <span id="counter" class="tabular-nums">0 / 20,000</span>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 border-t border-line px-5 py-3.5">
                    <span class="hidden text-[12px] text-hint sm:inline">
                        <kbd class="rounded border border-line bg-canvas px-1.5 py-0.5 font-sans text-[11px] text-sub">⌘</kbd>
                        <kbd class="rounded border border-line bg-canvas px-1.5 py-0.5 font-sans text-[11px] text-sub">Enter</kbd>
                        to summarize
                    </span>
                    <button type="button" id="submitBtn"
                            class="ml-auto inline-flex items-center gap-2 rounded-lg bg-accent-600 px-4 py-2 text-[13px] font-medium text-white shadow-[0_1px_2px_rgba(16,24,40,.1),inset_0_1px_0_rgba(255,255,255,.12)] hover:bg-accent-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-accent-500/25 disabled:cursor-not-allowed disabled:opacity-60">
                        <svg id="spinner" class="hidden h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" class="opacity-25"/><path d="M21 12a9 9 0 00-9-9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        <span id="submitLabel">Summarize</span>
                    </button>
                </div>
            </section>

            <!-- Summary -->
            <section id="outputPanel" class="flex min-h-[34rem] flex-col rounded-2xl border border-line bg-white shadow-card">
                <div class="flex items-center gap-3 border-b border-line px-5 py-4">
                    <div class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-accent-50 text-accent-600">
                        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h10M4 18h7"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <h2 class="text-[14px] font-semibold">Summary</h2>
                            <span id="statusPill" class="hidden items-center gap-1.5 rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-medium text-amber-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>Draft · needs review
                            </span>
                        </div>
                        <p id="meta" class="truncate text-[12px] text-hint">Not generated yet</p>
                    </div>
                    <div id="actions" class="no-print hidden items-center gap-1.5">
                        <button type="button" id="copyBtn" class="inline-flex items-center gap-1.5 rounded-lg border border-line px-2.5 py-1.5 text-[12px] font-medium text-sub hover:bg-canvas">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V5a2 2 0 012-2h10"/></svg>
                            <span id="copyLabel">Copy</span>
                        </button>
                        <button type="button" id="printBtn" class="inline-flex items-center gap-1.5 rounded-lg border border-line px-2.5 py-1.5 text-[12px] font-medium text-sub hover:bg-canvas">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V3h12v6M6 18H4v-7a2 2 0 012-2h12a2 2 0 012 2v7h-2M7 14h10v7H7z"/></svg>
                            PDF
                        </button>
                    </div>
                </div>

                <div class="flex flex-1 flex-col px-5 py-5">
                    <!-- Empty -->
                    <div id="empty" class="grid flex-1 place-items-center">
                        <div class="max-w-xs text-center">
                            <div class="mx-auto grid h-10 w-10 place-items-center rounded-xl border border-line text-hint">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><path d="M4 6h16M4 12h10M4 18h7"/></svg>
                            </div>
                            <p class="mt-3 text-[14px] font-medium">No summary yet</p>
                            <p class="mt-1 text-[13px] leading-relaxed text-sub">Add a note on the left and select Summarize. You'll get a summary, key findings and numbered follow-up.</p>
                        </div>
                    </div>

                    <!-- Loading -->
                    <div id="skeleton" class="hidden flex-1 space-y-6" aria-live="polite">
                        <p id="loadingText" class="text-[13px] text-sub">Reading note…</p>
                        <div class="space-y-2.5">
                            <div class="shimmer h-3 w-24 rounded"></div>
                            <div class="shimmer h-3 rounded"></div>
                            <div class="shimmer h-3 w-11/12 rounded"></div>
                        </div>
                        <div class="space-y-2.5">
                            <div class="shimmer h-3 w-28 rounded"></div>
                            <div class="shimmer h-3 w-10/12 rounded"></div>
                            <div class="shimmer h-3 w-9/12 rounded"></div>
                            <div class="shimmer h-3 w-8/12 rounded"></div>
                        </div>
                        <div class="space-y-2.5">
                            <div class="shimmer h-3 w-32 rounded"></div>
                            <div class="shimmer h-3 w-7/12 rounded"></div>
                            <div class="shimmer h-3 w-6/12 rounded"></div>
                        </div>
                    </div>

                    <!-- Result -->
                    <article id="result" class="hidden flex-1"></article>

                    <!-- Error -->
                    <div id="error" role="alert" class="mt-4 hidden items-start gap-2.5 rounded-xl border border-red-200 bg-red-50 px-3.5 py-3 text-[13px] text-red-700">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg>
                        <span id="errorText"></span>
                    </div>
                </div>

                <div class="flex items-start gap-2 rounded-b-2xl border-t border-line bg-[#FCFCFD] px-5 py-3 text-[12px] leading-relaxed text-sub">
                    <svg class="mt-0.5 h-3.5 w-3.5 shrink-0 text-hint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 3l8 4v5c0 4.5-3.4 8.3-8 9-4.6-.7-8-4.5-8-9V7z"/></svg>
                    <span>Generated from the source note only. Check each line against the note before it informs care.</span>
                </div>
            </section>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked@12.0.2/marked.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dompurify@3.1.6/dist/purify.min.js"></script>
<script>
(() => {
    const $ = (id) => document.getElementById(id);
    const els = {
        note: $('note'), counter: $('counter'), error: $('error'), errorText: $('errorText'),
        submit: $('submitBtn'), spinner: $('spinner'), submitLabel: $('submitLabel'),
        empty: $('empty'), skeleton: $('skeleton'), result: $('result'), loadingText: $('loadingText'),
        actions: $('actions'), meta: $('meta'), copyLabel: $('copyLabel'), statusPill: $('statusPill'),
        sourceMeta: $('sourceMeta'), crumb: $('crumb'),
    };
    const MAX = 20000;
    const MODEL = @json(config('services.groq.model'));
    const fmt = new Intl.NumberFormat();
    let lastSummary = '';
    let currentFile = null;

    const SAMPLE = `68-year-old male presenting to ED with 3 days of progressive shortness of breath, orthopnea (3 pillows) and bilateral ankle swelling. PMH: HTN, T2DM (on metformin), CAD s/p PCI 2019, CKD stage 3a. Reports running out of furosemide 2 weeks ago. Denies chest pain, fever.

Vitals: BP 162/94, HR 104 irregular, RR 24, SpO2 89% RA -> 95% on 2L NC, T 36.8.
Exam: JVP elevated to angle of jaw, bibasal crackles to mid-zones, pitting edema to knees bilaterally. Irregularly irregular rhythm, no murmurs.

Labs: Na 134, K 5.1, Cr 1.9 (baseline 1.4), BNP 2,340, troponin 0.04 (ULN 0.03), Hb 11.2, HbA1c 8.4%.
ECG: atrial fibrillation, rate 108, no acute ST changes (new compared to 2023 ECG).
CXR: cardiomegaly, bilateral pleural effusions, upper lobe diversion.

Impression: acute decompensated heart failure, likely precipitated by diuretic non-adherence and new-onset AF with RVR. AKI on CKD.
Plan: IV furosemide 40mg BID, strict I/O, daily weights, fluid restriction 1.5L. Rate control with metoprolol. Start anticoagulation pending CHA2DS2-VASc and bleeding risk. Hold metformin given AKI. Repeat troponin in 3h. Echo. Cardiology consult.`;

    // ---------- Source panel ----------
    function updateCounter() {
        const n = els.note.value.length;
        els.counter.textContent = `${fmt.format(n)} / ${fmt.format(MAX)}`;
        els.counter.classList.toggle('text-amber-600', n > MAX * 0.9);
        if (!currentFile) {
            els.sourceMeta.textContent = n ? `Pasted text · ${fmt.format(n)} characters` : 'Paste text or upload a file';
        }
    }

    function showError(msg) {
        els.errorText.textContent = msg || '';
        els.error.classList.toggle('hidden', !msg);
        els.error.classList.toggle('flex', !!msg);
    }

    // ---------- Summary panel ----------
    function show(state) {
        els.empty.classList.toggle('hidden', state !== 'empty');
        els.skeleton.classList.toggle('hidden', state !== 'loading');
        els.result.classList.toggle('hidden', state !== 'result');
        els.actions.classList.toggle('hidden', state !== 'result');
        els.actions.classList.toggle('flex', state === 'result');
        els.statusPill.classList.toggle('hidden', state !== 'result');
        els.statusPill.classList.toggle('inline-flex', state === 'result');
    }

    let loadTimer = null;
    function setLoading(on, chars) {
        els.submit.disabled = on;
        els.spinner.classList.toggle('hidden', !on);
        els.submitLabel.textContent = on ? 'Summarizing…' : 'Summarize';
        clearTimeout(loadTimer);
        if (on) {
            els.loadingText.textContent = `Reading ${fmt.format(chars)} characters…`;
            loadTimer = setTimeout(() => (els.loadingText.textContent = 'Writing summary and follow-up…'), 2200);
        }
    }

    // ---------- Clinical icons (Lucide-style strokes, 24×24) ----------
    const ICON_PATHS = {
        heartPulse: ['M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z', 'M3.22 12H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27'],
        gauge: ['m12 14 4-4', 'M3.34 19a10 10 0 1 1 17.32 0'],
        thermometer: ['M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z'],
        lungs: ['M12 4v9', 'M12 13c-1.5-1-3-1.5-3-4', 'M12 13c1.5-1 3-1.5 3-4', 'M9 7.5C6 7.5 3 11 3 16c0 2 1 3 2.5 3S9 18 9 15V7.5Z', 'M15 7.5c3 0 6 3.5 6 8.5 0 2-1 3-2.5 3S15 18 15 15V7.5Z'],
        microbe: ['M12 20c-3.3 0-6-2.7-6-6v-3a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v3c0 3.3-2.7 6-6 6', 'M9 7.13v-1a3 3 0 1 1 6 0v1', 'M12 20v-9', 'M6 13H2', 'M22 13h-4', 'M6.53 9C4.6 8.8 3 7.1 3 5', 'M20.97 5c0 2.1-1.6 3.8-3.5 4', 'M3 21c0-2.1 1.7-3.9 3.8-4', 'M17.2 17c2.1.1 3.8 1.9 3.8 4'],
        droplets: ['M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 6.75 7 5.3c-.29 1.45-1.14 2.84-2.29 3.76S3 11.1 3 12.25c0 2.22 1.8 4.05 4 4.05z', 'M12.56 6.6A10.97 10.97 0 0 0 14 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 0 1-11.91 4.97'],
        droplet: ['M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z'],
        activity: ['M22 12h-4l-3 9L9 3l-3 9H2'],
        scan: ['M3 7V5a2 2 0 0 1 2-2h2', 'M17 3h2a2 2 0 0 1 2 2v2', 'M21 17v2a2 2 0 0 1-2 2h-2', 'M7 21H5a2 2 0 0 1-2-2v-2', 'M7 12h10'],
        brain: ['M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z', 'M12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18Z', 'M12 5v13'],
        flask: ['M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2', 'M8.5 2h7', 'M7 16h10'],
        clipboard: ['M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2', 'M9 2h6a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1z'],
        clipboardCheck: ['M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2', 'M9 2h6a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1z', 'm9 14 2 2 4-4'],
        pill: ['m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z', 'm8.5 8.5 7 7'],
        syringe: ['m18 2 4 4', 'm17 7 3-3', 'M19 9 8.7 19.3c-1 1-2.5 1-3.4 0l-.6-.6c-1-1-1-2.5 0-3.4L15 5', 'm9 11 4 4', 'm5 19-3 3', 'm14 4 6 6'],
        stethoscope: ['M11 2v2', 'M5 2v2', 'M5 3H4a2 2 0 0 0-2 2v4a6 6 0 0 0 12 0V5a2 2 0 0 0-2-2h-1', 'M8 15a6 6 0 0 0 12 0v-3', 'M22 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0z'],
        calendar: ['M8 2v4', 'M16 2v4', 'M3 10h18', 'M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z'],
        eye: ['M2.06 12.35a1 1 0 0 1 0-.7 10.75 10.75 0 0 1 19.88 0 1 1 0 0 1 0 .7 10.75 10.75 0 0 1-19.88 0', 'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'],
        message: ['M7.9 20A9 9 0 1 0 4 16.1L2 22Z'],
        alert: ['m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3', 'M12 9v4', 'M12 17h.01'],
        user: ['M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2', 'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z'],
    };

    function svgIcon(name) {
        const ns = 'http://www.w3.org/2000/svg';
        const svg = document.createElementNS(ns, 'svg');
        svg.setAttribute('viewBox', '0 0 24 24');
        svg.setAttribute('fill', 'none');
        svg.setAttribute('stroke', 'currentColor');
        svg.setAttribute('stroke-width', '1.9');
        svg.setAttribute('stroke-linecap', 'round');
        svg.setAttribute('stroke-linejoin', 'round');
        svg.setAttribute('aria-hidden', 'true');
        (ICON_PATHS[name] || ICON_PATHS.clipboard).forEach((d) => {
            const p = document.createElementNS(ns, 'path');
            p.setAttribute('d', d);
            svg.append(p);
        });
        return svg;
    }

    // Tones: [background, foreground]
    const TONE = {
        rose: ['#FFF1F3', '#E11D48'], orange: ['#FFF4EB', '#EA580C'], sky: ['#EEF8FF', '#0284C7'],
        violet: ['#F4F1FF', '#7C3AED'], teal: ['#ECFBFB', '#0E7490'], amber: ['#FFF8EB', '#D97706'],
        indigo: ['#EEF1FF', '#4F46E5'], slate: ['#F2F4F7', '#475467'], fuchsia: ['#FDF2FD', '#A21CAF'],
        emerald: ['#ECFDF5', '#059669'], red: ['#FEF2F2', '#DC2626'], blue: ['#EEF4FF', '#2563EB'],
    };

    // Order matters: first match wins.
    const FINDING_RULES = [
        [/allerg|anaphyla|red flag/, 'alert', 'red', 'Alert'],
        [/x-?ray|\bcxr\b|\bct\b|\bmri\b|ultrasound|\becho|imaging|radiograph|\bscan\b/, 'scan', 'slate', 'Imaging'],
        [/\becg\b|\bekg\b|atrial fib|\baf\b|rhythm|arrhythm|st[- ]elev/, 'activity', 'rose', 'ECG'],
        [/temp|febrile|fever|pyrexi|°\s?c\b/, 'thermometer', 'orange', 'Vitals'],
        [/blood pressure|\bbp\b|hypotens|hypertens|\bmap\b|mmhg/, 'gauge', 'rose', 'Vitals'],
        [/heart rate|\bhr\b|pulse|tachycard|bradycard|bpm|troponin|\bbnp\b|\bjvp\b|murmur|cardiac/, 'heartPulse', 'rose', 'Cardiac'],
        [/resp|spo|oxygen|\bo2\b|saturation|hypox|crackle|breath|lung|pleural|consolidat|pneumon|wheez/, 'lungs', 'sky', 'Respiratory'],
        [/wbc|white cell|leuko|leuco|neutrophil|\bcrp\b|procalcitonin|culture|sepsis|septic|infect|lactate/, 'microbe', 'violet', 'Infection'],
        [/glucose|hba1c|\ba1c\b|diabet|insulin|hyperglyc|hypoglyc|ketone/, 'droplet', 'amber', 'Metabolic'],
        [/creatinine|urea|egfr|kidney|renal|\baki\b|\bckd\b|urine|potassium|sodium|\bna\b|\bk\b|hyponat|hypernat|hyperkal|hypokal|electrolyte/, 'droplets', 'teal', 'Renal'],
        [/confus|\bgcs\b|neuro|orient|drows|seizure|stroke|weakness|delirium/, 'brain', 'fuchsia', 'Neuro'],
        [/\bhb\b|haemoglobin|hemoglobin|platelet|\binr\b|anaemi|anemi|bleed/, 'droplet', 'red', 'Blood'],
        [/\bph\b|hco3|bicarb|acidosis|alkalosis|blood gas/, 'flask', 'indigo', 'Blood gas'],
        [/curb|score|chads|wells|\bnews\b|qsofa/, 'clipboard', 'slate', 'Score'],
        [/medication|\bdose\b|\bmg\b|drug|tablet/, 'pill', 'emerald', 'Medication'],
    ];
    // Follow-up: these win outright when present…
    const FOLLOWUP_PRIORITY = [
        [/x-?ray|\bcxr\b|\bct\b|\bmri\b|ultrasound|\becho|imaging|\bscan\b/, 'scan', 'slate'],
        [/consult|refer|\bicu\b|specialist|cardiology|nephrology|escalat|outreach/, 'stethoscope', 'rose'],
    ];
    // …otherwise the earliest match in the sentence (usually the leading verb) decides.
    const FOLLOWUP_RULES = [
        [/oxygen|\bspo|\bo2\b|nebuli/, 'lungs', 'sky'],
        [/\biv\b|infusion|bolus|crystalloid|vaccin|inject|insulin|heparin|enoxaparin|transfus/, 'syringe', 'violet'],
        [/arrange|schedule|appointment|clinic|discharge|follow-up with|in \d+\s*(weeks?|months?)/, 'calendar', 'blue'],
        [/monitor|strict|daily weight|observe|catheter|urine output|fluid balance|\bi\/o\b|telemetry/, 'eye', 'teal'],
        [/\bstart|\bstop|\bhold|\bcontinue|antibiotic|medicat|tablet|metformin|diuretic|statin/, 'pill', 'emerald'],
        [/repeat|recheck|\bcheck|\blabs?\b|blood test|u&e|culture|panel|\blevels?\b/, 'flask', 'indigo'],
        [/educat|counsel|update|family|daughter|\bson\b|\bcall\b|inform|discuss/, 'message', 'amber'],
    ];
    function classifyEarliest(text, rules, fallback) {
        let best = null, bestAt = Infinity;
        for (const rule of rules) {
            const m = rule[0].exec(text);
            if (m && m.index < bestAt) { best = rule; bestAt = m.index; }
        }
        return best || fallback;
    }
    const SECTIONS = {
        'summary': ['user', 'blue'],
        'key findings': ['activity', 'rose'],
        'suggested follow-up': ['clipboardCheck', 'emerald'],
    };

    // Models often emit non-breaking hyphens/spaces ("X‑ray", "CKD 3a"); fold them before matching.
    const norm = (s) => s.toLowerCase().replace(/[‐-―−]/g, '-').replace(/[   ]/g, ' ');

    function classify(text, rules, fallback) {
        const t = norm(text);
        return rules.find(([re]) => re.test(t)) || fallback;
    }

    function tile(name, tone, cls = 'ico-tile') {
        const [bg, fg] = TONE[tone] || TONE.slate;
        const el = document.createElement('span');
        el.className = cls;
        el.style.background = bg;
        el.style.color = fg;
        el.append(svgIcon(name));
        return el;
    }

    function decorateItem(li, rule, { num = null, tag = null } = {}) {
        const [, icon, tone] = rule;
        const body = document.createElement('div');
        body.className = 'ico-body';
        while (li.firstChild) body.append(li.firstChild);
        li.classList.add('ico');
        if (num !== null) {
            const n = document.createElement('span');
            n.className = 'ico-num';
            n.textContent = num;
            li.append(n);
        }
        li.append(tile(icon, tone), body);
        if (tag) {
            const [bg, fg] = TONE[tone] || TONE.slate;
            const t = document.createElement('span');
            t.className = 'ico-tag';
            t.style.background = bg;
            t.style.color = fg;
            t.textContent = tag;
            li.append(t);
        }
    }

    function sectionAfter(h) {
        let el = h.nextElementSibling;
        while (el && !/^(UL|OL)$/.test(el.tagName) && !/^H[1-3]$/.test(el.tagName)) el = el.nextElementSibling;
        return el && /^(UL|OL)$/.test(el.tagName) ? el : null;
    }

    function render(markdown) {
        els.result.innerHTML = DOMPurify.sanitize(marked.parse(markdown, { breaks: true, gfm: true }));

        els.result.querySelectorAll('ul, ol').forEach((list) => list.classList.add('sec'));

        els.result.querySelectorAll('h1, h2, h3').forEach((h) => {
            const key = h.textContent.trim().toLowerCase().replace(/[:#]/g, '').trim();
            const sec = SECTIONS[key];
            if (sec) h.prepend(tile(sec[0], sec[1], 'sec-icon'));

            const list = sectionAfter(h);
            if (!list) return;

            if (key === 'key findings') {
                list.querySelectorAll(':scope > li').forEach((li) => {
                    const lead = li.querySelector('strong')?.textContent || '';
                    const rule = (lead && classify(lead, FINDING_RULES, null))
                        || classify(li.textContent, FINDING_RULES, [null, 'flask', 'indigo', 'Finding']);
                    decorateItem(li, rule, { tag: rule[3] });
                });
            } else if (key === 'suggested follow-up') {
                list.querySelectorAll(':scope > li').forEach((li, i) => {
                    const text = norm(li.textContent);
                    const rule = classify(text, FOLLOWUP_PRIORITY, null)
                        || classifyEarliest(text, FOLLOWUP_RULES, [null, 'clipboard', 'slate']);
                    decorateItem(li, rule, { num: list.tagName === 'OL' ? i + 1 : null });
                });
            }
        });
    }

    function setMeta({ id, time, secs }) {
        const parts = [MODEL, `generated ${time}`];
        if (secs) parts.push(`${secs}s`);
        if (id) parts.push(`saved as #${id}`);
        els.meta.textContent = parts.join(' · ');
    }

    async function summarize() {
        const note = els.note.value.trim();
        showError('');
        if (!note) { showError('Add a note first — paste it in or upload a file.'); els.note.focus(); return; }

        setLoading(true, note.length);
        show('loading');
        const started = performance.now();

        try {
            const res = await fetch('/api/summarize', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ note }),
            });
            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                const fieldError = data.errors && Object.values(data.errors)[0]?.[0];
                throw new Error(fieldError || data.message || `Request failed (${res.status}).`);
            }
            if (!data.summary) throw new Error('The model returned an empty summary. Try again.');

            lastSummary = data.summary;
            render(lastSummary);
            const entry = {
                id: data.record?.id ?? null,
                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                secs: ((performance.now() - started) / 1000).toFixed(1),
                note, summary: lastSummary,
                title: titleFrom(note, currentFile?.name),
                created: Date.now(),
            };
            setMeta(entry);
            els.crumb.textContent = entry.title;
            show('result');
            addRecent(entry);
        } catch (err) {
            show(lastSummary ? 'result' : 'empty');
            showError(err.message || 'Something went wrong. Try again.');
        } finally {
            setLoading(false);
        }
    }

    async function copySummary() {
        try { await navigator.clipboard.writeText(lastSummary); els.copyLabel.textContent = 'Copied'; }
        catch { els.copyLabel.textContent = 'Copy failed'; }
        setTimeout(() => (els.copyLabel.textContent = 'Copy'), 1500);
    }

    // ---------- Recent (this browser only) ----------
    const RECENT_KEY = 'clinical-notes:recent';
    function loadRecent() { try { return JSON.parse(localStorage.getItem(RECENT_KEY)) || []; } catch { return []; } }
    function saveRecent(list) { try { localStorage.setItem(RECENT_KEY, JSON.stringify(list)); } catch {} }

    function titleFrom(note, fileName) {
        if (fileName) return fileName.replace(/\.[^.]+$/, '');
        const line = note.split('\n').find((l) => l.trim()) || 'Untitled note';
        return line.trim().replace(/\s+/g, ' ').slice(0, 48) + (line.trim().length > 48 ? '…' : '');
    }

    function relTime(ts) {
        const m = Math.round((Date.now() - ts) / 60000);
        if (m < 1) return 'just now';
        if (m < 60) return `${m} min ago`;
        const h = Math.round(m / 60);
        if (h < 24) return `${h} h ago`;
        return new Date(ts).toLocaleDateString([], { day: 'numeric', month: 'short' });
    }

    function renderRecent(activeCreated) {
        const list = loadRecent();
        const ul = $('recentList');
        ul.innerHTML = '';
        $('recentEmpty').classList.toggle('hidden', list.length > 0);
        $('recentCount').textContent = list.length || '';
        list.forEach((item) => {
            const li = document.createElement('li');
            const btn = document.createElement('button');
            btn.type = 'button';
            const active = item.created === activeCreated;
            btn.className = `w-full rounded-lg px-2.5 py-2 text-left hover:bg-canvas ${active ? 'bg-canvas' : ''}`;
            const t = document.createElement('p');
            t.className = 'truncate text-[13px] font-medium text-ink';
            t.textContent = item.title;
            const s = document.createElement('p');
            s.className = 'text-[12px] text-hint';
            s.textContent = relTime(item.created) + (item.id ? ` · #${item.id}` : '');
            btn.append(t, s);
            btn.addEventListener('click', () => openRecent(item));
            li.append(btn);
            ul.append(li);
        });
    }

    function addRecent(entry) {
        const list = [entry, ...loadRecent()].slice(0, 12);
        saveRecent(list);
        renderRecent(entry.created);
    }

    function openRecent(item) {
        clearFile();
        els.note.value = item.note;
        updateCounter();
        lastSummary = item.summary;
        render(item.summary);
        setMeta(item);
        els.crumb.textContent = item.title;
        showError('');
        show('result');
        renderRecent(item.created);
    }

    // ---------- File upload ----------
    const MAX_FILE_BYTES = 5 * 1024 * 1024;
    const PDFJS = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
    const PDFJS_WORKER = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    const MAMMOTH = 'https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js';
    const scriptCache = {};
    const dropzone = $('dropzone'), fileInput = $('fileInput'), fileChip = $('fileChip');

    function loadScript(src) {
        return scriptCache[src] ??= new Promise((resolve, reject) => {
            const s = document.createElement('script');
            s.src = src;
            s.onload = resolve;
            s.onerror = () => { delete scriptCache[src]; reject(new Error('Could not load the file reader. Check your internet connection.')); };
            document.head.appendChild(s);
        });
    }

    async function readPdf(file) {
        await loadScript(PDFJS);
        pdfjsLib.GlobalWorkerOptions.workerSrc = PDFJS_WORKER;
        const pdf = await pdfjsLib.getDocument({ data: await file.arrayBuffer() }).promise;
        const pages = [];
        for (let i = 1; i <= pdf.numPages; i++) {
            const content = await (await pdf.getPage(i)).getTextContent();
            pages.push(content.items.map((it) => it.str + (it.hasEOL ? '\n' : '')).join(''));
        }
        return pages.join('\n\n');
    }

    async function readDocx(file) {
        await loadScript(MAMMOTH);
        const { value } = await mammoth.extractRawText({ arrayBuffer: await file.arrayBuffer() });
        return value;
    }

    function extOf(file) { return file.name.split('.').pop().toLowerCase(); }

    async function extractText(file) {
        const ext = extOf(file);
        if (ext === 'txt' || ext === 'md') return file.text();
        if (ext === 'pdf') return readPdf(file);
        if (ext === 'docx') return readDocx(file);
        if (ext === 'doc') throw new Error('Older .doc files aren’t supported. Save it as .docx or PDF and try again.');
        throw new Error('That file type isn’t supported. Use PDF, DOCX, TXT or MD.');
    }

    function setFileBusy(on) {
        $('dropIdle').classList.toggle('hidden', on);
        $('dropIdle').classList.toggle('flex', !on);
        $('dropBusy').classList.toggle('hidden', !on);
        $('dropBusy').classList.toggle('flex', on);
    }

    function showFileChip(file, chars) {
        currentFile = file;
        $('fileExt').textContent = extOf(file);
        $('fileName').textContent = file.name;
        const kb = `${(file.size / 1024).toFixed(file.size < 10240 ? 1 : 0)} KB`;
        $('fileMeta').textContent = `${kb} · ${fmt.format(chars)} characters`;
        els.sourceMeta.textContent = `Uploaded · ${file.name}`;
        fileChip.classList.remove('hidden');
        fileChip.classList.add('flex');
    }

    function clearFile() {
        currentFile = null;
        fileInput.value = '';
        fileChip.classList.add('hidden');
        fileChip.classList.remove('flex');
    }

    async function handleFile(file) {
        if (!file) return;
        showError('');
        if (file.size > MAX_FILE_BYTES) { showError('That file is larger than 5 MB.'); return; }

        setFileBusy(true);
        try {
            const text = (await extractText(file)).replace(/\r\n/g, '\n').replace(/\n{3,}/g, '\n\n').trim();
            if (!text) throw new Error('No readable text in that file. A scanned PDF needs OCR first.');
            if (text.length > MAX) {
                throw new Error(`That file has ${fmt.format(text.length)} characters; the limit is ${fmt.format(MAX)}.`);
            }
            els.note.value = text;
            showFileChip(file, text.length);
            updateCounter();
            els.note.scrollTop = 0;
        } catch (err) {
            clearFile();
            updateCounter();
            showError(err.message || 'Could not read that file.');
        } finally {
            setFileBusy(false);
            fileInput.value = '';
        }
    }

    fileInput.addEventListener('change', () => handleFile(fileInput.files[0]));
    $('fileRemove').addEventListener('click', () => { clearFile(); els.note.value = ''; updateCounter(); els.note.focus(); });

    const highlight = (on) => {
        dropzone.classList.toggle('border-accent-500', on);
        dropzone.classList.toggle('bg-accent-50', on);
    };
    [dropzone, els.note].forEach((el) => {
        el.addEventListener('dragover', (e) => { e.preventDefault(); highlight(true); });
        el.addEventListener('dragleave', () => highlight(false));
        el.addEventListener('drop', (e) => { e.preventDefault(); highlight(false); handleFile(e.dataTransfer.files[0]); });
    });
    window.addEventListener('dragover', (e) => e.preventDefault());
    window.addEventListener('drop', (e) => e.preventDefault());

    // ---------- Wiring ----------
    function reset() {
        clearFile();
        els.note.value = '';
        lastSummary = '';
        els.meta.textContent = 'Not generated yet';
        els.crumb.textContent = 'New summary';
        els.result.innerHTML = '';
        showError('');
        updateCounter();
        show('empty');
        renderRecent();
        els.note.focus();
    }

    els.note.addEventListener('input', () => { if (currentFile) { currentFile = null; fileChip.classList.add('hidden'); fileChip.classList.remove('flex'); } updateCounter(); });
    els.note.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && (e.metaKey || e.ctrlKey)) { e.preventDefault(); summarize(); }
    });
    els.submit.addEventListener('click', summarize);
    $('sampleBtn').addEventListener('click', () => { clearFile(); els.note.value = SAMPLE; updateCounter(); els.note.focus(); });
    $('clearBtn').addEventListener('click', () => { clearFile(); els.note.value = ''; updateCounter(); els.note.focus(); });
    $('copyBtn').addEventListener('click', copySummary);
    $('printBtn').addEventListener('click', () => window.print());
    $('navNew').addEventListener('click', reset);

    updateCounter();
    show('empty');
    renderRecent();
})();
</script>
</body>
</html>
