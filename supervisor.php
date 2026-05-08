<?php
session_start();
$userRole = 'supervisor';
$userName = 'Contractor Lead';
$userTitle = 'Project Supervisor';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard D&G Construction Monitor</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/supervisor.css">
</head>
<body>

<div class="app">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-badge">
                <div class="logo-icon">CM</div>
                <div>
                    <div class="logo-text">ConstructMonitor</div>
                </div>
            </div>
            <div class="logo-sub">Supervisor Portal</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Site Operations</div>
            <div class="nav-item active" onclick="navigate('timeline', this)">
                Project Timeline
            </div>
            <div class="nav-item" onclick="navigate('report', this)">
                Submit Report
                <span class="nav-badge">2</span>
            </div>

            <div class="nav-section-label">Workforce & Materials</div>
            <div class="nav-item" onclick="navigate('attendance', this)">
                Attendance Logs
            </div>
            <div class="nav-item" onclick="navigate('materials', this)">
                Material Tracking
            </div>

            <div class="nav-section-label">System</div>
            <div class="nav-item" onclick="goHome()">
                Back to Home
            </div>
            <div class="nav-item" onclick="doLogout()">
                Sign Out
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">CL</div>
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($userName); ?></div>
                    <div class="user-role"><?php echo htmlspecialchars($userTitle); ?></div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="topbar-title" id="pageTitle">Project Timeline</div>
            <div class="topbar-right">
                <span style="font-size:12px;color:var(--muted)">Mon, 28 Apr 2026</span>
                <div class="topbar-notif">
                    <div class="notif-dot"></div>
                </div>
                <button class="topbar-btn primary" id="primaryAction" onclick="primaryAction()" style="display:none;">+ New Report</button>
            </div>
        </div>

        <div class="content">
            <div class="page active" id="pg-timeline">
                <div class="page-header">
                    <h1>Project Timeline</h1>
                    <p>Real-time construction phase status and progress milestones.</p>
                </div>

                <div style="display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap;">
                    <select class="form-select" style="width:240px;">
                        <option>Rizal Residential Complex</option>
                        <option>San Pablo Commercial Hub</option>
                        <option>Batangas Warehouse Facility</option>
                        <option>Lipa City Townhouse Dev.</option>
                    </select>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <span class="tag green">On Track</span>
                        <span class="tag">62% Complete</span>
                        <span class="tag blue">Structural Works Phase</span>
                    </div>
                </div>

                <div style="max-width: 100%;">
                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="card-title">Construction Phases â€” Rizal Residential Complex</div>
                            <div style="font-size:12px; color:var(--muted);">Target: Aug 2026</div>
                        </div>

                        <div class="timeline-wrap">
                            <div class="timeline-phase">
                                <div class="phase-dot done"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 1 â€” Site Preparation & Earthworks</div>
                                    <div class="phase-dates">Jan 15 â€“ Feb 28, 2026 Â· Completed on time</div>
                                </div>
                                <div class="phase-right">
                                    <div class="phase-pct" style="color:var(--green);">100%</div>
                                    <div class="phase-status">Completed</div>
                                </div>
                            </div>

                            <div class="timeline-phase">
                                <div class="phase-dot done"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 2 â€” Foundation Works</div>
                                    <div class="phase-dates">Mar 1 â€“ Apr 10, 2026 Â· Completed 3 days early</div>
                                </div>
                                <div class="phase-right">
                                    <div class="phase-pct" style="color:var(--green);">100%</div>
                                    <div class="phase-status">Completed</div>
                                </div>
                            </div>

                            <div class="timeline-phase">
                                <div class="phase-dot current"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 3 â€” Structural Works â† Current</div>
                                    <div class="phase-dates">Apr 11 â€“ Jun 30, 2026 Â· In progress</div>
                                </div>
                                <div class="phase-right">
                                    <div class="phase-pct" style="color:var(--accent);">67%</div>
                                    <div class="phase-status">On Track</div>
                                </div>
                            </div>

                            <div class="timeline-phase">
                                <div class="phase-dot upcoming"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 4 â€” MEP Installation</div>
                                    <div class="phase-dates">Jul 1 â€“ Jul 31, 2026 Â· Upcoming</div>
                                </div>
                                <div class="phase-right">
                                    <div class="phase-pct" style="color:var(--muted);">0%</div>
                                    <div class="phase-status">Not Started</div>
                                </div>
                            </div>

                            <div class="timeline-phase">
                                <div class="phase-dot upcoming"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 5 â€” Finishing & Turnover</div>
                                    <div class="phase-dates">Aug 1 â€“ Aug 31, 2026 Â· Upcoming</div>
                                </div>
                                <div class="phase-right">
                                    <div class="phase-pct" style="color:var(--muted);">0%</div>
                                    <div class="phase-status">Not Started</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page" id="pg-report">
                <div class="page-header">
                    <h1>Submit Progress Report</h1>
                    <p>Report daily accomplishments and project status for admin review.</p>
                </div>

                <div class="step-indicator" style="margin-bottom:24px;">
                    <div class="step active">
                        <div class="step-num">1</div>
                        <div class="step-label">Project Info</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step">
                        <div class="step-num">2</div>
                        <div class="step-label">Accomplishments</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step">
                        <div class="step-num">3</div>
                        <div class="step-label">Documentation</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step">
                        <div class="step-num">4</div>
                        <div class="step-label">Submit</div>
                    </div>
                </div>

                <div class="two-col" style="align-items: start;">
                    <div class="card mb-0">
                        <div class="card-title" style="margin-bottom:18px;">Report Details</div>
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Project</label>
                                    <select class="form-select">
                                        <option>Rizal Residential Complex</option>
                                        <option>San Pablo Commercial Hub</option>
                                        <option>Batangas Warehouse Facility</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Report Period</label>
                                    <input type="date" class="form-input" value="2026-04-28">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Current Phase</label>
                                <select class="form-select">
                                    <option>Phase 3 â€” Structural Works</option>
                                    <option>Phase 2 â€” Foundation Works</option>
                                    <option>Phase 4 â€” MEP Installation</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Completion Description</label>
                                <textarea class="form-textarea" placeholder="Describe work accomplished this period, milestones reached, and any issues encountered...">Completed column forms on Levels 3-5. Poured concrete for Level 4 slab. Rebar installation ongoing for Level 6. Weather delays of 2 days noted.</textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Completion % (Est.)</label>
                                    <input type="number" class="form-input" value="67" min="0" max="100">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Workers On-Site</label>
                                    <input type="number" class="form-input" value="42">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Issues / Blockers</label>
                                <textarea class="form-textarea" placeholder="Any issues, risks, or blockers..." style="min-height:60px;">Rebar delivery delayed by supplier â€” ETA Apr 30. Awaiting inspector sign-off for Level 4 slab.</textarea>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card">
                            <div class="card-title" style="margin-bottom:14px;">Supporting Documents</div>
                            <div class="upload-zone">
                                <div class="upload-icon">ðŸ“Ž</div>
                                <div class="upload-text">Drop files here or <span>browse</span></div>
                                <div style="font-size:11px; color:var(--muted); margin-top:4px;">Photos, PDFs, inspection reports</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:12px;">
                    <button class="topbar-btn">Save Draft</button>
                    <button class="topbar-btn primary" onclick="showToast('Report submitted for admin review!')">Submit Report â†’</button>
                </div>
            </div>

            <div class="page" id="pg-attendance">
                <div class="page-header">
                    <h1>Group Photo Attendance</h1>
                    <p>Upload one site photo and the system will match every visible face against the worker profiles saved by admin.</p>
                </div>

                <div class="attendance-grid">
                    <div class="attendance-stack">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Today's Attendance — <span id="attendanceDateLabel">Apr 28, 2026</span></div>
                                <select class="form-select attendance-select" id="attendanceProjectSelect">
                                    <option value="Rizal Residential Complex">Rizal Residential Complex</option>
                                    <option value="San Pablo Commercial Hub">San Pablo Commercial Hub</option>
                                </select>
                            </div>

                            <div class="attendance-summary">
                                <div class="attendance-stat">
                                    <div class="attendance-stat-label">Detected faces</div>
                                    <div class="attendance-stat-value" id="attendanceDetectedCount">0</div>
                                    <div class="attendance-stat-hint">Faces found in the upload</div>
                                </div>
                                <div class="attendance-stat">
                                    <div class="attendance-stat-label">Matched workers</div>
                                    <div class="attendance-stat-value" id="attendanceMatchedCount">0</div>
                                    <div class="attendance-stat-hint">Recognized from profiles</div>
                                </div>
                                <div class="attendance-stat">
                                    <div class="attendance-stat-label">Enrolled profiles</div>
                                    <div class="attendance-stat-value" id="attendanceEnrolledCount">0</div>
                                    <div class="attendance-stat-hint">Saved by admin</div>
                                </div>
                            </div>

                            <table class="data-table attendance-table">
                                <thead>
                                    <tr><th>Worker</th><th>ID</th><th>Role</th><th>Time In</th><th>Status</th></tr>
                                </thead>
                                <tbody id="attendanceLogBody"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="attendance-stack">
                        <div class="card">
                            <div class="card-title" style="margin-bottom:16px;">Upload Group Photo</div>
                            <div class="face-panel">
                                <div class="face-stage">
                                    <img id="groupPhotoPreview" alt="Uploaded group photo" style="display:none;">
                                    <canvas id="groupPhotoOverlay"></canvas>
                                    <div class="face-empty" id="groupPhotoEmpty">Upload the supervisor group photo to match every face against enrolled profiles.</div>
                                </div>
                                <div class="face-info">
                                    <div class="face-status" id="attendanceStatus">Upload a group photo and run the FaceNet matcher to mark attendance.</div>
                                    <div class="face-actions">
                                        <button class="topbar-btn primary" id="processGroupBtn" type="button">Run Attendance Match</button>
                                        <button class="topbar-btn" id="clearGroupBtn" type="button">Clear Photo</button>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Group Photo</label>
                                        <input type="file" class="form-input" id="groupPhotoInput" accept="image/*">
                                    </div>
                                    <div class="face-meta" id="faceMeta">The supervisor scan compares every detected face with the worker profiles stored by admin.</div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-0">
                            <div class="card-title" style="margin-bottom:10px;">Enrolled Workers</div>
                            <div class="worker-roster" id="workerRoster"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page" id="pg-materials">
                <div class="page-header">
                    <h1>Material Tracking</h1>
                    <p>Monitor material deliveries and inventory usage on-site.</p>
                </div>

                <div class="stat-grid" style="grid-template-columns: repeat(3,1fr);">
                    <div class="stat-card" style="--accent-color: var(--blue);">
                        <div class="stat-label">Active Deliveries</div>
                        <div class="stat-value">12</div>
                        <div class="stat-change">This week</div>
                        <div class="stat-icon">Deliveries</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--red);">
                        <div class="stat-label">Low Stock Alerts</div>
                        <div class="stat-value">3</div>
                        <div class="stat-change down">Immediate reorder needed</div>
                        <div class="stat-icon">Alerts</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--green);">
                        <div class="stat-label">Inventory Value</div>
                        <div id="total-inventory-value" class="stat-value">â‚±1.2M</div>
                        <div class="stat-change up">This site</div>
                        <div class="stat-icon">Inventory</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Inventory Status</div>
                    </div>

                    <div id="inventory-list">
                        <div class="mat-item">
                            <div class="mat-icon">ðŸª¨</div>
                            <div class="mat-info">
                                <div class="mat-name">Ready-Mix Concrete</div>
                                <div class="mat-detail">Delivered: 480 mÂ³ Â· Used: 320 mÂ³</div>
                            </div>
                            <div class="mat-bar-wrap">
                                <div class="mat-pct">66% remaining</div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill green" style="width:66%"></div></div>
                            </div>
                        </div>

                        <div class="mat-item">
                            <div class="mat-icon">ðŸ”©</div>
                            <div class="mat-info">
                                <div class="mat-name">Rebar (16mm) <span class="alert-flag">âš ï¸</span></div>
                                <div class="mat-detail">Delivered: 12 tons Â· Used: 10.8 tons</div>
                            </div>
                            <div class="mat-bar-wrap">
                                <div class="mat-pct" style="color:var(--red);">10% left</div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill red" style="width:10%"></div></div>
                            </div>
                        </div>

                        <div class="mat-item">
                            <div class="mat-icon">ðŸªµ</div>
                            <div class="mat-info">
                                <div class="mat-name">Lumber (Formwork) <span class="alert-flag">âš ï¸</span></div>
                                <div class="mat-detail">Delivered: 800 pcs Â· Used: 760 pcs</div>
                            </div>
                            <div class="mat-bar-wrap">
                                <div class="mat-pct" style="color:var(--yellow);">5% left</div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:5%; background:var(--red);"></div></div>
                            </div>
                        </div>

                        <div class="mat-item">
                            <div class="mat-icon">ðŸª£</div>
                            <div class="mat-info">
                                <div class="mat-name">Portland Cement (40kg)</div>
                                <div class="mat-detail">Delivered: 1,200 bags Â· Used: 680 bags</div>
                            </div>
                            <div class="mat-bar-wrap">
                                <div class="mat-pct">43% remaining</div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:43%"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-title" style="margin-bottom:14px;">Log Material Delivery</div>
                    <div class="form-grid" style="max-width: 500px;">
                        <div class="form-group">
                            <label class="form-label">Material</label>
                            <select class="form-select">
                                <option>Rebar (16mm)</option>
                                <option>Portland Cement</option>
                                <option>Sand & Gravel</option>
                                <option>Lumber (Formwork)</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-input" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Unit</label>
                                <select class="form-select">
                                    <option>tons</option>
                                    <option>bags</option>
                                    <option>mÂ³</option>
                                    <option>pcs</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Supplier</label>
                            <input type="text" class="form-input" placeholder="Supplier name...">
                        </div>
                        <button class="topbar-btn primary" onclick="showToast('Delivery logged successfully!')">Log Delivery</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toast">Action completed</div>

<script>
let currentPage = 'timeline';

const pageTitles = {
    timeline: 'Project Timeline',
    report: 'Submit Progress Report',
    attendance: 'Group Photo Attendance',
    materials: 'Material Tracking',
};

const primaryActions = {
    timeline: '',
    report: '+ New Report',
    attendance: '+ Upload Photo',
    materials: '',
};

const FACE_MODELS_URL = 'https://justadudewhohacks.github.io/face-api.js/models';
const FACE_STORAGE_KEYS = {
    workers: 'dg-face-workers-v1',
    logs: 'dg-face-logs-v1',
};

const DEFAULT_WORKERS = [
    { id: 'W-0012', name: 'Jose Reyes', role: 'Carpenter', project: 'Rizal Residential Complex', descriptor: null, photoName: '' },
    { id: 'W-0018', name: 'Maria Lim', role: 'Foreman', project: 'Rizal Residential Complex', descriptor: null, photoName: '' },
    { id: 'W-0024', name: 'Roberto Dizon', role: 'Mason', project: 'San Pablo Commercial Hub', descriptor: null, photoName: '' },
    { id: 'W-0031', name: 'Ana Cruz', role: 'Steel Worker', project: 'Rizal Residential Complex', descriptor: null, photoName: '' },
    { id: 'W-0037', name: 'Bong Pascual', role: 'Electrician', project: 'San Pablo Commercial Hub', descriptor: null, photoName: '' },
];

const attendanceState = {
    initialized: false,
    modelsReady: false,
    workers: [],
    logs: [],
    currentProject: 'Rizal Residential Complex',
    loadingModels: null,
    lastScan: {
        detected: 0,
        matched: 0,
        unknown: 0,
    },
};

function readJson(key, fallback) {
    try {
        const raw = localStorage.getItem(key);
        return raw ? JSON.parse(raw) : fallback;
    } catch (error) {
        return fallback;
    }
}

function writeJson(key, value) {
    localStorage.setItem(key, JSON.stringify(value));
}

async function sendAttendanceApi(action, payload = {}) {
    const response = await fetch('attendance_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ action, ...payload }),
    });

    if (!response.ok) {
        throw new Error('Attendance API request failed.');
    }

    return response.json();
}

async function bootstrapAttendanceData() {
    try {
        const response = await fetch('attendance_api.php?action=bootstrap', { credentials: 'same-origin' });
        if (!response.ok) {
            throw new Error('Bootstrap request failed.');
        }

        const data = await response.json();
        if (!data.success) {
            throw new Error(data.message || 'Bootstrap failed.');
        }

        attendanceState.workers = Array.isArray(data.workers) ? data.workers : [];
        attendanceState.logs = Array.isArray(data.logs) ? data.logs : [];
        writeJson(FACE_STORAGE_KEYS.workers, attendanceState.workers);
        writeJson(FACE_STORAGE_KEYS.logs, attendanceState.logs);
    } catch (error) {
        seedAttendanceData();
        attendanceState.workers = readJson(FACE_STORAGE_KEYS.workers, DEFAULT_WORKERS);
        attendanceState.logs = readJson(FACE_STORAGE_KEYS.logs, []);
    }
}

function seedAttendanceData() {
    const todayKey = new Date().toISOString().slice(0, 10);

    if (!readJson(FACE_STORAGE_KEYS.workers, []).length) {
        writeJson(FACE_STORAGE_KEYS.workers, DEFAULT_WORKERS);
    }

    if (!readJson(FACE_STORAGE_KEYS.logs, []).length) {
        writeJson(FACE_STORAGE_KEYS.logs, [
            { workerId: 'W-0012', workerName: 'Jose Reyes', workerRole: 'Carpenter', project: 'Rizal Residential Complex', dateKey: todayKey, timeIn: '07:02', status: 'Present', score: 0.18 },
            { workerId: 'W-0018', workerName: 'Maria Lim', workerRole: 'Foreman', project: 'Rizal Residential Complex', dateKey: todayKey, timeIn: '07:45', status: 'Late', score: 0.22 },
            { workerId: 'W-0031', workerName: 'Ana Cruz', workerRole: 'Steel Worker', project: 'Rizal Residential Complex', dateKey: todayKey, timeIn: '06:58', status: 'Present', score: 0.16 },
        ]);
    }
}

function formatClock(clockValue) {
    if (!clockValue) return '—';
    const [hoursPart, minutesPart] = String(clockValue).split(':');
    let hours = Number(hoursPart);
    const period = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    return `${String(hours).padStart(2, '0')}:${String(minutesPart).padStart(2, '0')} ${period}`;
}

function getInitials(name) {
    return String(name || '')
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(part => part[0].toUpperCase())
        .join('') || 'W';
}

function showAttendanceStatus(message) {
    const status = document.getElementById('attendanceStatus');
    if (status) status.textContent = message;
}

function showFaceMeta(message) {
    const meta = document.getElementById('faceMeta');
    if (meta) meta.textContent = message;
}

function showToast(message) {
    const toast = document.getElementById('toast');
    if (!toast) return;

    toast.textContent = message;
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';

    clearTimeout(window.__attendanceToastTimer);
    window.__attendanceToastTimer = setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
    }, 2800);
}

function persistWorkers() {
    writeJson(FACE_STORAGE_KEYS.workers, attendanceState.workers);
}

function persistLogs() {
    writeJson(FACE_STORAGE_KEYS.logs, attendanceState.logs);
}

function renderAttendanceModule() {
    const todayKey = new Date().toISOString().slice(0, 10);
    const currentProject = document.getElementById('attendanceProjectSelect')?.value || attendanceState.currentProject;
    attendanceState.currentProject = currentProject;

    const workers = attendanceState.workers.filter(worker => worker.project === currentProject);
    const logs = attendanceState.logs.filter(log => log.project === currentProject && log.dateKey === todayKey);
    const enrolledCount = attendanceState.workers.filter(worker => Array.isArray(worker.descriptor) && worker.descriptor.length).length;

    const detectedEl = document.getElementById('attendanceDetectedCount');
    if (detectedEl) detectedEl.textContent = String(attendanceState.lastScan.detected);
    const matchedEl = document.getElementById('attendanceMatchedCount');
    if (matchedEl) matchedEl.textContent = String(attendanceState.lastScan.matched);
    const enrolledEl = document.getElementById('attendanceEnrolledCount');
    if (enrolledEl) enrolledEl.textContent = String(enrolledCount);

    const roster = document.getElementById('workerRoster');
    if (roster) {
        roster.innerHTML = workers.length
            ? workers.map(worker => {
                const enrolled = Array.isArray(worker.descriptor) && worker.descriptor.length;
                return `
                    <div class="worker-roster-item">
                        <div>
                            <div class="worker-roster-name">${worker.name}</div>
                            <div class="worker-roster-meta">${worker.id} · ${worker.role}${worker.photoName ? ` · ${worker.photoName}` : ''}</div>
                        </div>
                        <span class="roster-pill ${enrolled ? 'ready' : 'pending'}">${enrolled ? 'Enrolled' : 'Needs photo'}</span>
                    </div>`;
            }).join('')
            : '<div class="worker-roster-empty">No workers are available for this project yet.</div>';
    }

    const tbody = document.getElementById('attendanceLogBody');
    if (tbody) {
        tbody.innerHTML = logs.length
            ? logs.slice().reverse().map(log => `
                <tr>
                    <td>
                        <div class="worker-row">
                            <div class="worker-avatar">${getInitials(log.workerName)}</div>
                            ${log.workerName}
                        </div>
                    </td>
                    <td style="color:var(--muted);">${log.workerId}</td>
                    <td style="color:var(--muted);">${log.workerRole}</td>
                    <td>${formatClock(log.timeIn)}</td>
                    <td><span class="att-badge ${log.status.toLowerCase()}">${log.status}</span></td>
                </tr>`).join('')
            : '<tr><td colspan="5" style="color:var(--muted); text-align:center; padding:24px;">No attendance logs recorded for this project yet.</td></tr>';
    }

    const dateLabel = document.getElementById('attendanceDateLabel');
    if (dateLabel) dateLabel.textContent = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

async function ensureFaceApiLoaded() {
    if (window.faceapi) return window.faceapi;

    if (!window.__faceApiLoadPromise) {
        window.__faceApiLoadPromise = new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js';
            script.onload = () => resolve(window.faceapi);
            script.onerror = () => reject(new Error('Face API script failed to load.'));
            document.head.appendChild(script);
        });
    }

    return window.__faceApiLoadPromise;
}

async function loadFaceModels() {
    if (attendanceState.modelsReady) return;
    if (attendanceState.loadingModels) return attendanceState.loadingModels;

    attendanceState.loadingModels = (async () => {
        showAttendanceStatus('Loading FaceNet model weights...');
        await ensureFaceApiLoaded();

        await Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri(FACE_MODELS_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(FACE_MODELS_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(FACE_MODELS_URL),
        ]);

        attendanceState.modelsReady = true;
        showAttendanceStatus('FaceNet ready. Upload a group photo to begin matching.');
        showFaceMeta('The matcher compares every detected face in the upload with worker profiles saved by admin.');
    })();

    return attendanceState.loadingModels;
}

function readFileAsDataUrl(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(String(reader.result || ''));
        reader.onerror = () => reject(new Error('Unable to read the selected file.'));
        reader.readAsDataURL(file);
    });
}

function loadImageFromDataUrl(dataUrl) {
    return new Promise((resolve, reject) => {
        const image = new Image();
        image.onload = () => resolve(image);
        image.onerror = () => reject(new Error('Unable to decode the selected image.'));
        image.src = dataUrl;
    });
}

async function updateGroupPhotoPreview(file) {
    const preview = document.getElementById('groupPhotoPreview');
    const empty = document.getElementById('groupPhotoEmpty');
    const overlay = document.getElementById('groupPhotoOverlay');

    if (!preview || !empty || !overlay) return;

    if (!file) {
        preview.removeAttribute('src');
        preview.style.display = 'none';
        empty.style.display = 'flex';
        overlay.getContext('2d')?.clearRect(0, 0, overlay.width, overlay.height);
        return;
    }

    const dataUrl = await readFileAsDataUrl(file);
    preview.src = dataUrl;
    preview.style.display = 'block';
    empty.style.display = 'none';
}

function clearGroupPhoto() {
    const input = document.getElementById('groupPhotoInput');
    if (input) input.value = '';
    attendanceState.lastScan = { detected: 0, matched: 0, unknown: 0 };
    updateGroupPhotoPreview(null);
    renderAttendanceModule();
    showAttendanceStatus('Upload a new group photo to run attendance again.');
    showFaceMeta('The current scan is cleared. Saved attendance logs remain in the browser.');
}

function readStoredDescriptor(worker) {
    return Array.isArray(worker.descriptor) && worker.descriptor.length ? worker.descriptor : null;
}

function euclideanDistance(left, right) {
    let total = 0;
    for (let index = 0; index < left.length; index += 1) {
        const delta = left[index] - right[index];
        total += delta * delta;
    }
    return Math.sqrt(total);
}

function findBestMatch(descriptor) {
    let bestWorker = null;
    let bestScore = Number.POSITIVE_INFINITY;

    attendanceState.workers.forEach(worker => {
        const storedDescriptor = readStoredDescriptor(worker);
        if (!storedDescriptor || storedDescriptor.length !== descriptor.length) return;
        const score = euclideanDistance(descriptor, storedDescriptor);
        if (score < bestScore) {
            bestScore = score;
            bestWorker = worker;
        }
    });

    return bestWorker && bestScore <= 0.55 ? { worker: bestWorker, score: bestScore } : null;
}

function recordAttendance(worker, score) {
    const now = new Date();
    const timeIn = now.toTimeString().slice(0, 5);
    const dateKey = now.toISOString().slice(0, 10);
    const project = attendanceState.currentProject;
    const existing = attendanceState.logs.find(log => log.workerId === worker.id && log.project === project && log.dateKey === dateKey);
    const status = now.getHours() >= 8 ? 'Late' : 'Present';

    const savedLog = existing || {
        workerId: worker.id,
        workerName: worker.name,
        workerRole: worker.role,
        project,
        dateKey,
        timeIn,
        status,
        score: Number(score.toFixed(3)),
        scanSource: 'group_photo',
    };

    savedLog.workerName = worker.name;
    savedLog.workerRole = worker.role;
    savedLog.project = project;
    savedLog.dateKey = dateKey;
    savedLog.timeIn = timeIn;
    savedLog.status = existing ? 'Present' : status;
    savedLog.score = Number(score.toFixed(3));
    savedLog.scanSource = 'group_photo';

    if (existing) {
        existing.timeIn = savedLog.timeIn;
        existing.status = savedLog.status;
        existing.score = savedLog.score;
        existing.scanSource = savedLog.scanSource;
    } else {
        attendanceState.logs.push(savedLog);
    }

    persistLogs();
    void sendAttendanceApi('save-attendance', { log: savedLog });
}

async function processGroupPhoto() {
    const file = document.getElementById('groupPhotoInput')?.files?.[0] || null;
    if (!file) {
        showToast('Upload a group photo before running the matcher.');
        return;
    }

    try {
        await loadFaceModels();
        await updateGroupPhotoPreview(file);
        showAttendanceStatus('Analyzing the uploaded group photo...');

        const dataUrl = await readFileAsDataUrl(file);
        const image = await loadImageFromDataUrl(dataUrl);
        const detections = await faceapi
            .detectAllFaces(image, new faceapi.TinyFaceDetectorOptions({ inputSize: 416, scoreThreshold: 0.42 }))
            .withFaceLandmarks()
            .withFaceDescriptors();

        if (!detections.length) {
            attendanceState.lastScan = { detected: 0, matched: 0, unknown: 0 };
            renderAttendanceModule();
            showAttendanceStatus('No faces were detected in the uploaded photo. Try a clearer group image.');
            showFaceMeta('Nothing matched because no faces were found in the upload.');
            showToast('No faces detected.');
            return;
        }

        let matchedCount = 0;
        let unknownCount = 0;
        const loggedWorkerIds = new Set();

        detections.forEach(detection => {
            const match = findBestMatch(Array.from(detection.descriptor));
            if (!match || loggedWorkerIds.has(match.worker.id)) {
                unknownCount += 1;
                return;
            }

            loggedWorkerIds.add(match.worker.id);
            recordAttendance(match.worker, match.score);
            matchedCount += 1;
        });

        attendanceState.lastScan = {
            detected: detections.length,
            matched: matchedCount,
            unknown: Math.max(detections.length - matchedCount, 0),
        };

        renderAttendanceModule();
        showAttendanceStatus(`Matched ${matchedCount} of ${detections.length} detected face(s) from the uploaded group photo.`);
        showFaceMeta(`Unknown faces in the scan: ${attendanceState.lastScan.unknown}. Scores above 0.55 are treated as a safe match.`);
        showToast(`Attendance match complete: ${matchedCount} worker(s) identified.`);
    } catch (error) {
        attendanceState.lastScan = { detected: 0, matched: 0, unknown: 0 };
        renderAttendanceModule();
        showAttendanceStatus('Group photo analysis failed. Upload a clearer image and try again.');
        showToast('Face matching failed.');
    }
}

async function initAttendanceModule() {
    if (attendanceState.initialized) {
        renderAttendanceModule();
        return;
    }

    await bootstrapAttendanceData();
    attendanceState.currentProject = document.getElementById('attendanceProjectSelect')?.value || attendanceState.currentProject;

    const projectSelect = document.getElementById('attendanceProjectSelect');
    if (projectSelect) {
        projectSelect.value = attendanceState.currentProject;
        projectSelect.addEventListener('change', function() {
            attendanceState.currentProject = this.value;
            attendanceState.lastScan = { detected: 0, matched: 0, unknown: 0 };
            renderAttendanceModule();
        });
    }

    document.getElementById('groupPhotoInput')?.addEventListener('change', function() {
        updateGroupPhotoPreview(this.files?.[0]).catch(() => {
            showAttendanceStatus('Unable to preview the selected photo.');
        });
    });
    document.getElementById('processGroupBtn')?.addEventListener('click', processGroupPhoto);
    document.getElementById('clearGroupBtn')?.addEventListener('click', clearGroupPhoto);

    attendanceState.initialized = true;
    renderAttendanceModule();
}

function navigate(page, el) {
    currentPage = page;
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

    const pg = document.getElementById('pg-' + page);
    if (pg) pg.classList.add('active');
    if (el) el.classList.add('active');

    const pageTitle = document.getElementById('pageTitle');
    if (pageTitle) pageTitle.textContent = pageTitles[page] || page;

    const btn = document.getElementById('primaryAction');
    const label = primaryActions[page] || '';
    if (btn) {
        btn.textContent = label;
        btn.style.display = label ? 'block' : 'none';
    }

    if (page === 'attendance') {
        initAttendanceModule();
    }
}

function primaryAction() {
    if (currentPage === 'attendance') {
        processGroupPhoto();
        return;
    }

    alert('Feature coming soon!');
}

function doLogout() {
    if (confirm('Are you sure you want to sign out?')) {
        window.location.href = 'landing.html';
    }
}

function goHome() {
    window.location.href = 'landing.html';
}

document.addEventListener('DOMContentLoaded', () => {
    initAttendanceModule();
});
</script>

</body>
</html>

