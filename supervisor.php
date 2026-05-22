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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUarbnLLtQbOV5JnXwyIEo56nNmslbdkrMjW03fNvqrviJkur" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>

<div class="app">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-badge">
                <div class="logo-icon"><img src="images/logo.jpg" alt="D&G"></div>
                <div>
                    <div class="logo-text">ConstructMonitor</div>
                </div>
            </div>
            <div class="logo-sub">Supervisor Portal</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Site Operations</div>
            <div class="nav-item active" onclick="navigate('timeline', this)">
                <i class="bi bi-calendar-event"></i>Project Timeline
            </div>
            <div class="nav-item" onclick="navigate('report', this)">
                <i class="bi bi-file-earmark-bar-graph"></i>Submit Report
                <span class="nav-badge">2</span>
            </div>

            <div class="nav-section-label">Workforce & Materials</div>
            <div class="nav-item" onclick="navigate('attendance', this)">
                <i class="bi bi-people"></i>Group Attendance
            </div>
            <div class="nav-item" onclick="navigate('materials', this)">
                <i class="bi bi-boxes"></i>Material Tracking
            </div>

        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">CL</div>
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($userName); ?></div>
                    <div class="user-role"><?php echo htmlspecialchars($userTitle); ?></div>
                </div>
                <div class="logout-icon-btn" onclick="doLogout()">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="topbar-title" id="pageTitle">Project Timeline</div>
            <div class="topbar-right">
                <span id="liveDate" style="font-size:13px;color:var(--muted);min-width:140px;">Mon, 28 Apr 2026</span>
                <div class="topbar-notif" style="cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--accent);">
                    <i class="bi bi-bell-fill" style="font-size: 18px;"></i>
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
                            <div class="card-title">Construction Phases — Rizal Residential Complex</div>
                            <div style="font-size:12px; color:var(--muted);">Target: Aug 2026</div>
                        </div>

                        <div class="timeline-wrap">
                            <div class="timeline-phase">
                                <div class="phase-dot done"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 1 — Site Preparation & Earthworks</div>
                                    <div class="phase-dates">Jan 15 – Feb 28, 2026 · Completed on time</div>
                                </div>
                                <div class="phase-right">
                                    <div class="phase-pct" style="color:var(--accent);">100%</div>
                                    <div class="phase-status">Completed</div>
                                </div>
                            </div>

                            <div class="timeline-phase">
                                <div class="phase-dot done"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 2 — Foundation Works</div>
                                    <div class="phase-dates">Mar 1 – Apr 10, 2026 · Completed 3 days early</div>
                                </div>
                                <div class="phase-right">
                                    <div class="phase-pct" style="color:var(--accent);">100%</div>
                                    <div class="phase-status">Completed</div>
                                </div>
                            </div>

                            <div class="timeline-phase">
                                <div class="phase-dot current"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 3 — Structural Works ← Current</div>
                                    <div class="phase-dates">Apr 11 – Jun 30, 2026 · In progress</div>
                                </div>
                                <div class="phase-right">
                                    <div class="phase-pct" style="color:var(--accent);">67%</div>
                                    <div class="phase-status">On Track</div>
                                </div>
                            </div>

                            <div class="timeline-phase">
                                <div class="phase-dot upcoming"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 4 — MEP Installation</div>
                                    <div class="phase-dates">Jul 1 – Jul 31, 2026 · Upcoming</div>
                                </div>
                                <div class="phase-right">
                                    <div class="phase-pct" style="color:var(--muted);">0%</div>
                                    <div class="phase-status">Not Started</div>
                                </div>
                            </div>

                            <div class="timeline-phase">
                                <div class="phase-dot upcoming"></div>
                                <div class="phase-info">
                                    <div class="phase-name">Phase 5 — Finishing & Turnover</div>
                                    <div class="phase-dates">Aug 1 – Aug 31, 2026 · Upcoming</div>
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

                <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:14px; margin-bottom:20px;">
                    <div class="stat-card" style="background:linear-gradient(135deg, rgba(245,166,35,0.1), rgba(245,166,35,0.05)); border:1px solid rgba(245,166,35,0.2);">
                        <div style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:0.05em; font-weight:600; margin-bottom:4px;">Reports This Month</div>
                        <div style="font-family:var(--heading); font-size:24px; font-weight:800; margin-bottom:2px;">7</div>
                        <div style="font-size:11px; color:var(--accent);">3 pending review</div>
                    </div>
                    <div class="stat-card" style="background:linear-gradient(135deg, rgba(34,197,94,0.1), rgba(34,197,94,0.05)); border:1px solid rgba(34,197,94,0.2);">
                        <div style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:0.05em; font-weight:600; margin-bottom:4px;">Approved</div>
                        <div style="font-family:var(--heading); font-size:24px; font-weight:800; margin-bottom:2px;">4</div>
                        <div style="font-size:11px; color:#22c55e;">Last 30 days</div>
                    </div>
                    <div class="stat-card" style="background:linear-gradient(135deg, rgba(59,130,246,0.1), rgba(59,130,246,0.05)); border:1px solid rgba(59,130,246,0.2);">
                        <div style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:0.05em; font-weight:600; margin-bottom:4px;">On-Time Submission Rate</div>
                        <div style="font-family:var(--heading); font-size:24px; font-weight:800; margin-bottom:2px;">100%</div>
                        <div style="font-size:11px; color:var(--blue);">Excellent</div>
                    </div>
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
                                    <option>Phase 3 — Structural Works</option>
                                    <option>Phase 2 — Foundation Works</option>
                                    <option>Phase 4 — MEP Installation</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Completion Description</label>
                                <textarea class="form-textarea" placeholder="Describe work accomplished this period, milestones reached, and any issues encountered...">Completed column forms on Levels 3-5.
Poured concrete for Level 4 slab.
Rebar installation ongoing for Level 6.
Weather delays of 2 days noted.</textarea>
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
                                <textarea class="form-textarea" placeholder="Any issues, risks, or blockers..." style="min-height:60px;">Rebar delivery delayed by supplier — ETA Apr 30. Awaiting inspector sign-off for Level 4 slab.</textarea>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:14px;">
                        <div class="card">
                            <div class="card-title" style="margin-bottom:14px;">Supporting Documents</div>
                            <div class="upload-zone">
                                <div class="upload-icon">📎</div>
                                <div class="upload-text">Drop files here or <span>browse</span></div>
                                <div style="font-size:11px; color:var(--muted); margin-top:4px;">Photos, PDFs, inspection reports</div>
                            </div>
                            <div style="margin-top:12px;">
                                <div style="display:flex; align-items:center; gap:8px; padding:8px 0; border-bottom:1px solid var(--border); font-size:12px;">
                                    <span>📷</span> site_photo_apr28_01.jpg <span style="margin-left:auto; color:var(--muted);">2.1 MB</span>
                                </div>
                                <div style="display:flex; align-items:center; gap:8px; padding:8px 0; font-size:12px;">
                                    <span>inspection_form_level4.pdf</span> <span style="margin-left:auto; color:var(--muted);">0.8 MB</span>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-0">
                            <div class="card-title" style="margin-bottom:12px;">Recent Submissions</div>
                            <div style="display:flex; flex-direction:column; gap:10px;">
                                <div style="padding:10px; background:rgba(34,197,94,0.08); border-radius:8px; border-left:3px solid #22c55e;">
                                    <div style="font-size:12px; font-weight:600; color:var(--text);">Rizal Complex - Phase 3</div>
                                    <div style="font-size:11px; color:var(--muted); margin-top:2px;">Apr 25 · <span style="color:#22c55e; font-weight:600;">Approved</span></div>
                                </div>
                                <div style="padding:10px; background:rgba(245,166,35,0.08); border-radius:8px; border-left:3px solid var(--accent);">
                                    <div style="font-size:12px; font-weight:600; color:var(--text);">San Pablo Hub - Phase 2</div>
                                    <div style="font-size:11px; color:var(--muted); margin-top:2px;">Apr 22 · <span style="color:var(--accent); font-weight:600;">Pending</span></div>
                                </div>
                                <div style="padding:10px; background:rgba(59,130,246,0.08); border-radius:8px; border-left:3px solid var(--blue);">
                                    <div style="font-size:12px; font-weight:600; color:var(--text);">Warehouse - Phase 1</div>
                                    <div style="font-size:11px; color:var(--muted); margin-top:2px;">Apr 18 · <span style="color:var(--blue); font-weight:600;">Revisions</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:12px;">
                    <button class="topbar-btn">Save Draft</button>
                    <button class="topbar-btn primary" onclick="showToast('Report submitted for admin review!')">Submit Report →</button>
                </div>
            </div>

            <div class="page" id="pg-attendance">
                <div style="display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 28px; margin-bottom: 32px; align-items: start;">
                    
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        
                        <div id="todaysAttendanceSection">
                            <div class="card-header" style="margin-bottom: 16px; flex-direction: column; align-items: flex-start; gap: 12px; background: transparent; border: none; padding: 0;">
                                <div style="display: flex; align-items: center; gap: 8px; width: 100%; justify-content: space-between;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <i class="bi bi-calendar-check" style="color: var(--accent); font-size: 18px;"></i>
                                        <div>
                                            <div class="card-title" style="margin: 0; font-size: 14px;" id="attendanceViewTitle">Today's Attendance</div>
                                            <div style="font-size: 11px; color: var(--muted); margin-top: 2px;"><span id="attendanceDateLabel">May 13, 2026</span></div>
                                        </div>
                                    </div>
                                    <select class="form-select" id="attendanceViewToggle" style="font-size: 12px; max-width: 200px;">
                                        <option value="today">Today's Attendance</option>
                                        <option value="history">Work Attendance History</option>
                                    </select>
                                </div>
                                <select class="form-select attendance-select" id="attendanceProjectSelect" style="min-width: 160px; font-size: 12px; width: 100%; max-width: 100%;">
                                    <option value="Rizal Residential Complex">Rizal Residential Complex</option>
                                    <option value="San Pablo Commercial Hub">San Pablo Commercial Hub</option>
                                </select>
                            </div>

                            <div class="card" style="margin-bottom: 0;" id="todaysAttendanceCard">
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 14px;">
                                    <div style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.08) 0%, rgba(34, 197, 94, 0.04) 100%); border: 1px solid rgba(34, 197, 94, 0.15); border-radius: 8px; padding: 11px; text-align: center;">
                                        <div style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px; font-weight: 600;">Detected</div>
                                        <div style="font-family: var(--heading); font-size: 18px; font-weight: 800; color: var(--accent);" id="attendanceDetectedCount">0</div>
                                    </div>
                                    <div style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.08) 0%, rgba(34, 197, 94, 0.04) 100%); border: 1px solid rgba(34, 197, 94, 0.15); border-radius: 8px; padding: 11px; text-align: center;">
                                        <div style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px; font-weight: 600;">Matched</div>
                                        <div style="font-family: var(--heading); font-size: 18px; font-weight: 800; color: var(--accent);" id="attendanceMatchedCount">0</div>
                                    </div>
                                    <div style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.08) 0%, rgba(34, 197, 94, 0.04) 100%); border: 1px solid rgba(34, 197, 94, 0.15); border-radius: 8px; padding: 11px; text-align: center;">
                                        <div style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px; font-weight: 600;">Enrolled</div>
                                        <div style="font-family: var(--heading); font-size: 18px; font-weight: 800; color: var(--accent);" id="attendanceEnrolledCount">0</div>
                                    </div>
                                </div>

                                <div style="overflow-x: auto;">
                                    <table class="data-table attendance-table">
                                        <thead>
                                            <tr>
                                                <th>Worker</th>
                                                <th>ID</th>
                                                <th>Role</th>
                                                <th>Time In</th>
                                                <th>Break Out</th>
                                                <th>Break In</th>
                                                <th>Time Out</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attendanceLogBody"></tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="attendanceHistoryTable" style="display: none; margin-top: 24px;">
                                <div class="card-header" style="margin-bottom: 16px; background: transparent; border: none; padding: 0;">
                                    <div class="card-title" style="display: flex; align-items: center; gap: 8px;">
                                        <i class="bi bi-clock-history" style="color: var(--accent); margin-right: 0;"></i>Worker Attendance History
                                    </div>
                                </div>
                                <div class="card" style="margin-bottom: 0; display: flex; flex-direction: column;">
                                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 16px; padding: 14px; background: rgba(34, 197, 94, 0.04); border-radius: 8px; border: 1px solid rgba(34, 197, 94, 0.12);">
                                        
                                        <div>
                                            <label style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600; display: block; margin-bottom: 6px;">Date</label>
                                            <input type="date" id="workerLogsDateFilter" class="form-input" style="font-size: 12px; width: 100%;">
                                        </div>
                                        
                                        <div>
                                            <label style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600; display: block; margin-bottom: 6px;">Status</label>
                                            <select id="workerLogsStatusFilter" class="form-select" style="font-size: 12px; width: 100%;">
                                                <option value="">All Statuses</option>
                                                <option value="Active">Active</option>
                                                <option value="Early Out">Early Out</option>
                                                <option value="Done">Done</option>
                                                <option value="Overtime">Overtime</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600; display: block; margin-bottom: 6px;">Worker</label>
                                            <input type="text" id="workerLogsSearchFilter" class="form-input" placeholder="Search by name or ID..." style="font-size: 12px; width: 100%;">
                                        </div>
                                    </div>

                                    <div style="overflow-x: auto;">
                                        <table class="data-table attendance-table">
                                            <thead>
                                                <tr>
                                                    <th>Worker</th>
                                                    <th>Date</th>
                                                    <th>Time In</th>
                                                    <th>Break Out</th>
                                                    <th>Break In</th>
                                                    <th>Time Out</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="workerLogsBody"></tbody>
                                        </table>
                                    </div>
                                    <div id="workerLogsPlaceholder" style="text-align: center; color: var(--muted); padding: 24px; font-size: 12px;">No attendance records match the selected filters</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="card-header" style="margin-bottom: 16px; background: transparent; border: none; padding: 0;">
                                <div class="card-title" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-people-fill" style="color: var(--accent);"></i>Enrolled Workers
                                </div>
                                <div style="font-size: 11px; color: var(--muted); margin-top: 2px;" id="enrolledCountLabel">0 Workers</div>
                            </div>
                            <div class="card" style="margin-bottom: 0; display: flex; flex-direction: column;">
                                <div id="workerRosterCompact" style="display: flex; flex-direction: column; gap: 8px; overflow-y: auto; max-height: 400px;"></div>
                                <div id="enrolledWorkersEmpty" style="text-align: center; color: var(--muted); padding: 24px; font-size: 12px; display: none;">
                                    <i class="bi bi-inbox" style="font-size: 28px; opacity: 0.5; margin-bottom: 8px; display: block;"></i>
                                    No workers enrolled
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card-header" style="margin-bottom: 16px; background: transparent; border: none; padding: 0;">
                            <div class="card-title">
                                <i class="bi bi-camera-fill" style="color: var(--accent); margin-right: 8px;"></i>Upload Group Photo
                            </div>
                        </div>
                        <div class="card" style="margin-bottom: 0;">

                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                <div class="face-stage" style="position: relative; width: 100%; min-height: 250px; max-height: 500px; padding-bottom: 0; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, rgba(34, 197, 94, 0.12) 0%, rgba(34, 197, 94, 0.06) 100%); border: 2px solid rgba(34, 197, 94, 0.2); box-shadow: 0 4px 12px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center;">
                                    <img id="groupPhotoPreview" alt="Uploaded group photo" style="display:none; max-width: 100%; max-height: 100%; object-fit: contain; width: auto; height: auto; object-position: center;">
                                    <canvas id="groupPhotoOverlay" style="max-width: 100%; max-height: 100%; position: absolute; top: 0; left: 0; display: none;"></canvas>
                                    <div class="face-empty" id="groupPhotoEmpty" style="display: flex; align-items: center; justify-content: center; height: 100%; width: 100%; flex-direction: column; text-align: center;">
                                        <i class="bi bi-image" style="font-size: 48px; color: var(--accent); margin-bottom: 12px; opacity: 0.7;"></i>
                                        <div style="font-size: 13px; color: var(--text); font-weight: 500;">Group photo</div>
                                        <div style="font-size: 11px; color: var(--muted); margin-top: 6px;">Portrait or landscape (aspect ratio preserved)</div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin: 0;">
                                    <label class="form-label" style="margin-bottom: 8px;">
                                        <i class="bi bi-cloud-upload" style="margin-right: 6px;"></i>Select Photo
                                    </label>
                                    <input type="file" class="form-input" id="groupPhotoInput" accept="image/*" style="padding: 10px 12px; border-radius: 8px; cursor: pointer; font-size: 12px;">
                                </div>

                                <div class="face-status" id="attendanceStatus" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.12) 0%, rgba(34, 197, 94, 0.06) 100%); padding: 11px 13px; border-radius: 8px; border-left: 4px solid var(--accent); font-size: 11px; color: var(--text); line-height: 1.5;">Upload to scan and match faces against enrolled profiles.</div>

                                <div id="detectionSummary" class="detection-stats-grid" style="display: none;">
                                    <div class="stat-card stat-card-primary">
                                        <span class="stat-label">Total Faces Detected</span>
                                        <span class="stat-value" id="statDetected">0</span>
                                    </div>
                                    
                                    <div class="stat-card stat-card-success">
                                        <span class="stat-label">Verified Matches</span>
                                        <span class="stat-value" id="statVerified">0</span>
                                        <span class="stat-note">✓ Auto-logged</span>
                                    </div>
                                    
                                    <div class="stat-card stat-card-warning">
                                        <span class="stat-label">Possible Matches</span>
                                        <span class="stat-value" id="statPossible">0</span>
                                        <span class="stat-note">⚠ Needs Review</span>
                                    </div>
                                    
                                    <div class="stat-card stat-card-danger">
                                        <span class="stat-label">Unrecognized</span>
                                        <span class="stat-value" id="statUnrecognized">0</span>
                                    </div>
                                    
                                    <div class="stat-card stat-card-accent">
                                        <span class="stat-label">Match Percentage</span>
                                        <span class="stat-value" id="statMatchPercentage">0%</span>
                                        <span class="stat-note" id="statMatchPercentageNote">—</span>
                                    </div>
                                </div>

                                <div id="groupPhotoResults" style="margin: 0; display: none;">
                                    <div style="font-size: 11px; font-weight: 600; margin-bottom: 8px; color: var(--accent); display: flex; align-items: center; gap: 6px;">
                                        <i class="bi bi-check-circle"></i>Matched Workers
                                    </div>
                                    <div id="groupPhotoResultsBody" style="font-size: 10px; color: var(--text); background: linear-gradient(135deg, rgba(34,197,94,0.1) 0%, rgba(16,185,129,0.05) 100%); padding: 11px 13px; border-radius: 8px; max-height: 150px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px;"></div>
                                </div>

                                <div style="display: flex; gap: 10px; justify-content: center;">
                                    <button class="topbar-btn" id="clearGroupBtn" type="button" style="padding: 10px 18px; font-weight: 600; font-size: 12px; min-width: 100px;">
                                        <i class="bi bi-trash" style="margin-right: 4px;"></i>Clear
                                    </button>
                                    <button class="topbar-btn primary" id="processGroupBtn" type="button" style="padding: 10px 18px; font-weight: 600; font-size: 12px; min-width: 100px;">
                                        <i class="bi bi-play-fill" style="margin-right: 4px;"></i>Match Attendance
                                    </button>
                                </div>

                                <div class="face-meta" id="faceMeta" style="padding-top: 12px; border-top: 1px solid var(--border); font-size: 10px; color: var(--muted); text-align: center; line-height: 1.4;">
                                    <i class="bi bi-info-circle" style="margin-right: 3px;"></i>Advanced FaceNet detection with duplicate suppression & confidence thresholds
                                </div>
                            </div>
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
                    </div>
                    <div class="stat-card" style="--accent-color: var(--red);">
                        <div class="stat-label">Low Stock Alerts</div>
                        <div class="stat-value">3</div>
                        <div class="stat-change down">Immediate reorder needed</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--green);">
                        <div class="stat-label">Inventory Value</div>
                        <div id="total-inventory-value" class="stat-value">₱1.2M</div>
                        <div class="stat-change up">This site</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Inventory Status</div>
                    </div>

                    <div id="inventory-list">
                        <div class="mat-item">
                            <div class="mat-info">
                                <div class="mat-name">Ready-Mix Concrete</div>
                                <div class="mat-detail">Delivered: 480 m³ · Used: 320 m³</div>
                            </div>
                            <div class="mat-bar-wrap">
                                <div class="mat-pct">66% remaining</div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill green" style="width:66%"></div></div>
                            </div>
                        </div>

                        <div class="mat-item">
                            <div class="mat-info">
                                <div class="mat-name">Rebar (16mm)</div>
                                <div class="mat-detail">Delivered: 12 tons · Used: 10.8 tons</div>
                            </div>
                            <div class="mat-bar-wrap">
                                <div class="mat-pct" style="color:var(--red);">10% left</div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill red" style="width:10%"></div></div>
                            </div>
                        </div>

                        <div class="mat-item">
                            <div class="mat-info">
                                <div class="mat-name">Lumber (Formwork)</div>
                                <div class="mat-detail">Delivered: 800 pcs · Used: 760 pcs</div>
                            </div>
                            <div class="mat-bar-wrap">
                                <div class="mat-pct" style="color:var(--yellow);">5% left</div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:5%; background:var(--red);"></div></div>
                            </div>
                        </div>

                        <div class="mat-item">
                            <div class="mat-info">
                                <div class="mat-name">Portland Cement (40kg)</div>
                                <div class="mat-detail">Delivered: 1,200 bags · Used: 680 bags</div>
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
                                    <option>m³</option>
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

            <div class="page" id="pg-attendance">
                <div class="page-header">
                    <h1>Group Photo Attendance</h1>
                    <p>Upload group photos to detect and match workers using face recognition technology.</p>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:24px;">
                    <div>
                        <div class="card">
                            <div class="card-title">Upload Group Photo</div>
                            <div class="form-group">
                                <label class="form-label">Project</label>
                                <select class="form-select" id="attendanceProjectSelect">
                                    <option value="Rizal Residential Complex">Rizal Residential Complex</option>
                                    <option value="San Pablo Commercial Hub">San Pablo Commercial Hub</option>
                                    <option value="Batangas Warehouse Facility">Batangas Warehouse Facility</option>
                                    <option value="Lipa City Townhouse Dev.">Lipa City Townhouse Dev.</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Group Photo</label>
                                <input type="file" class="form-input" id="groupPhotoInput" accept="image/*" onchange="updateGroupPhotoPreview(this.files[0])">
                                <div style="font-size:11px; color:var(--muted); margin-top:8px;">JPEG, PNG or WebP. Max 10MB. Include faces for accurate matching.</div>
                            </div>
                            <div style="position:relative; height:280px; background:var(--surface); border:2px dashed rgba(34,197,94,0.3); border-radius:10px; overflow:hidden; margin-bottom:12px;">
                                <div id="groupPhotoEmpty" style="display:flex; align-items:center; justify-content:center; height:100%; color:var(--muted); font-size:13px;">No photo uploaded yet</div>
                                <img id="groupPhotoPreview" style="display:none; width:100%; height:100%; object-fit:contain;">
                                <canvas id="groupPhotoOverlay" style="position:absolute; top:0; left:0; display:none;"></canvas>
                            </div>
                            <div style="display:flex; gap:10px;">
                                <button class="topbar-btn primary" onclick="initAttendanceModule(); processGroupPhoto();" style="flex:1;">Detect & Match</button>
                                <button class="topbar-btn" onclick="clearGroupPhoto();" style="flex:1;">Clear Photo</button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card">
                            <div class="card-title">FaceNet Detection Results</div>
                            <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:12px; margin-bottom:16px;">
                                <div style="background:rgba(34,197,94,0.08); padding:14px; border-radius:8px; border:1px solid rgba(34,197,94,0.15);">
                                    <div style="font-size:10px; color:var(--muted); text-transform:uppercase; letter-spacing:0.08em; font-weight:600; margin-bottom:6px;">Total Faces Detected</div>
                                    <div style="font-family:var(--heading); font-size:32px; font-weight:800; color:var(--accent); line-height:1;" id="attendanceDetectedCount">0</div>
                                </div>
                                <div style="background:rgba(34,197,94,0.08); padding:14px; border-radius:8px; border:1px solid rgba(34,197,94,0.15);">
                                    <div style="font-size:10px; color:var(--muted); text-transform:uppercase; letter-spacing:0.08em; font-weight:600; margin-bottom:6px;">Verified Matches</div>
                                    <div style="font-family:var(--heading); font-size:32px; font-weight:800; color:#22c55e; line-height:1;" id="attendanceVerifiedCount">0</div>
                                </div>
                                <div style="background:rgba(34,197,94,0.08); padding:14px; border-radius:8px; border:1px solid rgba(34,197,94,0.15);">
                                    <div style="font-size:10px; color:var(--muted); text-transform:uppercase; letter-spacing:0.08em; font-weight:600; margin-bottom:6px;">Unrecognized Faces</div>
                                    <div style="font-family:var(--heading); font-size:32px; font-weight:800; color:#ef4444; line-height:1;" id="attendanceUnrecognizedCount">0</div>
                                </div>
                            </div>
                            <div style="margin-bottom:16px;">
                                <div style="font-size:12px; font-weight:600; color:var(--text); margin-bottom:8px;">Analysis Status</div>
                                <div id="attendanceStatus" style="font-size:13px; color:var(--muted); line-height:1.5;">Loading FaceNet models. Initialize the module to begin matching.</div>
                            </div>
                            <div style="padding:12px; background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.15); border-radius:8px;">
                                <div id="faceMeta" style="font-size:12px; color:var(--accent); font-weight:500;">The matcher compares every detected face with worker profiles saved by admin.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="groupPhotoResults" style="display:none; margin-bottom:24px;">
                    <div class="card">
                        <div class="card-title">Matched Workers</div>
                        <div id="groupPhotoResultsBody"></div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Today's Attendance — <span id="attendanceDateLabel">Today</span></div>
                    </div>
                    <table class="attendance-table">
                        <thead>
                            <tr>
                                <th>Worker</th>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Time In</th>
                                <th>Break Out</th>
                                <th>Break In</th>
                                <th>Time Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceLogBody">
                            <tr><td colspan="8" style="text-align:center; color:var(--muted); padding:24px;">No attendance logs recorded yet.</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="card" style="margin-top:20px; margin-bottom:0;">
                    <div class="card-header">
                        <div class="card-title">Enrolled Workers</div>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <span class="tag">Total: <span id="attendanceEnrolledCount">0</span></span>
                        </div>
                    </div>
                    <div id="workerRoster" style="border-top:1px solid var(--border);"></div>
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
    attendance: '',
    materials: '',
};

const FACE_MODELS_URL = 'https://justadudewhohacks.github.io/face-api.js/models';
const FACE_STORAGE_KEYS = {
    workers: 'dg-face-workers-v1',
    logs: 'dg-face-logs-v1',
};

/**
 * Fixed Work Schedule
 * All times are in 24-hour format (minutes from midnight)
 */
const WORK_SCHEDULE = {
    timeIn: 7 * 60,        // 7:00 AM = 420 minutes
    breakOut: 12 * 60,     // 12:00 PM = 720 minutes
    breakIn: 13 * 60,      // 1:00 PM = 780 minutes
    timeOut: 17 * 60,      // 5:00 PM = 1020 minutes
    breakDuration: 60,     // 1 hour break
    lateThreshold: 15,     // 15 minutes after start time
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

function showAlert(title, message, type = 'success', onConfirm = null) {
    let modal = document.getElementById('dgAlertModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'dgAlertModal';
        modal.style.cssText = 'position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; z-index: 9999;';
        document.body.appendChild(modal);
    }

    const typeClass = type === 'error' ? 'error' : type === 'warning' ? 'warning' : type === 'info' ? 'info' : 'success';
    const iconMap = { success: 'check-circle', error: 'exclamation-circle', warning: 'exclamation-triangle', info: 'info-circle' };
    const icon = iconMap[typeClass];

    modal.className = 'dg-modal';
    modal.innerHTML = `
        <div class="dg-modal-content">
            <div style="display:flex; gap:10px; margin-bottom:14px;">
                <i class="bi bi-${icon}" style="font-size:22px; color:${typeClass === 'error' ? 'var(--red)' : typeClass === 'warning' ? 'var(--accent)' : 'var(--accent)'}; flex-shrink:0;"></i>
                <div>
                    <div class="dg-modal-title">${title}</div>
                    <div class="dg-modal-message">${message}</div>
                </div>
            </div>
            <div class="dg-modal-actions">
                <button class="dg-modal-btn cancel" onclick="document.getElementById('dgAlertModal').style.display='none';">Close</button>
                ${onConfirm ? `<button class="dg-modal-btn confirm" onclick="document.getElementById('dgAlertModal').style.display='none'; (${onConfirm.toString()})();">Confirm</button>` : ''}
            </div>
        </div>
    `;
    modal.style.display = 'flex';
}

function persistWorkers() {
    writeJson(FACE_STORAGE_KEYS.workers, attendanceState.workers);
}

function persistLogs() {
    writeJson(FACE_STORAGE_KEYS.logs, attendanceState.logs);
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
    document.getElementById('groupPhotoResults').style.display = 'none';
    renderAttendanceModule();
    showAttendanceStatus('Upload a new group photo to run attendance again.');
    showFaceMeta('The current scan is cleared. Saved attendance logs remain in the browser.');
}

function readStoredDescriptor(worker) {
    if (!Array.isArray(worker.descriptor) || !worker.descriptor.length) return null;
    
    // Handle nested array format (multiple reference descriptors from admin enrollment)
    if (Array.isArray(worker.descriptor[0])) {
        // Return all reference descriptors for comparison
        return worker.descriptor;
    }
    
    // Single flat descriptor
    return [worker.descriptor];
}

function euclideanDistance(left, right) {
    let total = 0;
    for (let index = 0; index < left.length; index += 1) {
        const delta = left[index] - right[index];
        total += delta * delta;
    }
    return Math.sqrt(total);
}

// Calculate Intersection over Union (IoU) for face bounding boxes
function calculateIoU(box1, box2) {
    const x1_min = box1.x;
    const y1_min = box1.y;
    const x1_max = box1.x + box1.width;
    const y1_max = box1.y + box1.height;
    
    const x2_min = box2.x;
    const y2_min = box2.y;
    const x2_max = box2.x + box2.width;
    const y2_max = box2.y + box2.height;
    
    const intersect_x_min = Math.max(x1_min, x2_min);
    const intersect_y_min = Math.max(y1_min, y2_min);
    const intersect_x_max = Math.min(x1_max, x2_max);
    const intersect_y_max = Math.min(y1_max, y2_max);
    
    if (intersect_x_max < intersect_x_min || intersect_y_max < intersect_y_min) {
        return 0;
    }
    
    const intersection = (intersect_x_max - intersect_x_min) * (intersect_y_max - intersect_y_min);
    const union = (box1.width * box1.height) + (box2.width * box2.height) - intersection;
    
    return union > 0 ? intersection / union : 0;
}

// Cluster overlapping faces using IoU threshold
function clusterOverlappingFaces(detections, iouThreshold = 0.5) {
    if (detections.length <= 1) return detections;
    
    const clusters = [];
    const visited = new Set();
    
    for (let i = 0; i < detections.length; i++) {
        if (visited.has(i)) continue;
        
        const cluster = [i];
        visited.add(i);
        
        for (let j = i + 1; j < detections.length; j++) {
            if (visited.has(j)) continue;
            
            const iou = calculateIoU(detections[i].detection.box, detections[j].detection.box);
            if (iou > iouThreshold) {
                cluster.push(j);
                visited.add(j);
            }
        }
        
        clusters.push(cluster);
    }
    
    // For clustered faces, use the one with highest descriptor quality
    return clusters.map(cluster => {
        if (cluster.length === 1) return detections[cluster[0]];
        
        // Return the detection with highest quality (best box size)
        return cluster.reduce((best, idx) => {
            const area = detections[idx].detection.box.width * detections[idx].detection.box.height;
            const bestArea = best.detection.box.width * best.detection.box.height;
            return area > bestArea ? detections[idx] : best;
        });
    });
}

// Validate face size and quality
function isValidFaceDetection(detection, minSize = 40) {
    const box = detection.detection.box;
    const area = box.width * box.height;
    return box.width >= minSize && box.height >= minSize && area >= (minSize * minSize);
}

function persistLogs() {
    writeJson(FACE_STORAGE_KEYS.logs, attendanceState.logs);
}

/**
 * Get status for a specific attendance action
 * @param {string} actionKey - Action type: 'time_in', 'break_out', 'break_in', 'time_out'
 * @param {Object} workerLog - Worker attendance record with all times
 * @returns {string} Status for that specific action
 */
function getActionStatus(actionKey, workerLog) {
    if (actionKey === 'time_in') {
        if (!workerLog.timeIn) return 'Pending';
        const timeInMinutes = timeToMinutes(workerLog.timeIn);
        if (timeInMinutes <= WORK_SCHEDULE.timeIn) {
            return 'On Time';
        } else {
            return 'Late';
        }
    }
    
    if (actionKey === 'break_out') {
        if (!workerLog.breakOut) return 'Pending';
        const breakOutMinutes = timeToMinutes(workerLog.breakOut);
        if (breakOutMinutes <= WORK_SCHEDULE.breakOut) {
            return 'On Time';
        } else {
            return 'Late Break';
        }
    }
    
    if (actionKey === 'break_in') {
        if (!workerLog.breakIn) return 'Pending';
        if (!workerLog.breakOut) return 'Pending';
        
        const breakOutMinutes = timeToMinutes(workerLog.breakOut);
        const expectedBreakInMinutes = breakOutMinutes + WORK_SCHEDULE.breakDuration;
        const actualBreakInMinutes = timeToMinutes(workerLog.breakIn);
        
        if (actualBreakInMinutes <= expectedBreakInMinutes) {
            return 'On Time';
        } else {
            return 'Over Break';
        }
    }
    
    if (actionKey === 'time_out') {
        if (!workerLog.timeOut) return 'Pending';
        const timeOutMinutes = timeToMinutes(workerLog.timeOut);
        if (timeOutMinutes <= WORK_SCHEDULE.timeOut) {
            return 'On Time';
        } else {
            return 'Overtime';
        }
    }
    
    return 'Pending';
}

/**
 * Determine status based on attendance state and times
 * Uses fixed work schedule: 7:00 AM - 5:00 PM with 1-hour break
 * Statuses: Pending, Present, Late, On Break, Pending Break In, Pending Time Out, Overtime, Over Break
 * @param {Object} workerLog - Worker attendance record with timeIn, breakOut, breakIn, timeOut
 * @returns {string} Status string
 */
function getAttendanceStatus(workerLog) {
    // Parse times to check if they exist
    const hasTimeIn = !!workerLog.timeIn;
    const hasBreakOut = !!workerLog.breakOut;
    const hasBreakIn = !!workerLog.breakIn;
    const hasTimeOut = !!workerLog.timeOut;

    // If no Time In, status is Pending
    if (!hasTimeIn) {
        return 'Pending';
    }

    const timeInMinutes = timeToMinutes(workerLog.timeIn);
    
    // Check if late (after scheduled time + 15 minute threshold)
    // Scheduled: 7:00 AM, Late if > 7:15 AM
    const lateThresholdMinutes = WORK_SCHEDULE.timeIn + WORK_SCHEDULE.lateThreshold;
    const isLate = timeInMinutes > lateThresholdMinutes;

    // Check break duration if both break_out and break_in exist
    let breakDuration = 0;
    if (hasBreakOut && hasBreakIn) {
        const breakOutMinutes = timeToMinutes(workerLog.breakOut);
        const breakInMinutes = timeToMinutes(workerLog.breakIn);
        if (breakOutMinutes && breakInMinutes) {
            breakDuration = breakInMinutes - breakOutMinutes;
        }
    }

    // If time in exists but not timed out yet
    if (!hasTimeOut) {
        // Currently on break (break_out recorded but break_in not yet)
        if (hasBreakOut && !hasBreakIn) {
            return 'On Break';
        }
        // Break in recorded but time out not yet - worker is back to work
        if (hasBreakIn && !hasTimeOut) {
            // If break took longer than 1 hour, show "Over Break", otherwise show "Present"
            if (breakDuration > WORK_SCHEDULE.breakDuration) {
                return 'Over Break';
            }
            return isLate ? 'Late' : 'Present';
        }
        // Still working or incomplete break cycle
        return isLate ? 'Late' : 'Present';
    }

    // Time Out exists - check for overtime and over break
    const timeOutMinutes = timeToMinutes(workerLog.timeOut);
    
    // Check if time out is after scheduled time (overtime)
    // Scheduled: 5:00 PM (1020 minutes)
    const isOvertime = timeOutMinutes > WORK_SCHEDULE.timeOut;

    // Check for over break (break duration > 1 hour)
    const isOverBreak = breakDuration > WORK_SCHEDULE.breakDuration;

    if (isOverBreak) {
        return 'Over Break';
    }

    if (isOvertime) {
        return 'Overtime';
    }

    // Default for completed day
    return isLate ? 'Late' : 'Present';
}

function renderAttendanceModule() {
    const project = attendanceState.currentProject;
    const todayKey = new Date().toISOString().slice(0, 10);
    
    // Get today's logs for current project
    const todaysLogs = attendanceState.logs.filter(log => 
        log.project === project && 
        log.dateKey === todayKey
    );
    
    // Get workers for current project
    const projectWorkers = attendanceState.workers.filter(w => w.project === project);
    
    // Update summary counts with breakdown
    const detectedEl = document.getElementById('attendanceDetectedCount');
    const verifiedEl = document.getElementById('attendanceVerifiedCount');
    const unrecognizedEl = document.getElementById('attendanceUnrecognizedCount');
    const enrolledEl = document.getElementById('attendanceEnrolledCount');
    
    const detected = attendanceState.lastScan.detected || 0;
    const verified = attendanceState.lastScan.verified || 0;
    const possible = attendanceState.lastScan.possible || 0;
    const unrecognized = attendanceState.lastScan.unrecognized || 0;
    
    if (detectedEl) {
        detectedEl.textContent = detected || '0';
    }
    if (verifiedEl) {
        verifiedEl.textContent = verified || '0';
    }
    if (unrecognizedEl) {
        unrecognizedEl.textContent = unrecognized || '0';
    }
    if (enrolledEl) enrolledEl.textContent = projectWorkers.length || '0';
    
    // Update attendance log table - group by worker
    const logBody = document.getElementById('attendanceLogBody');
    if (logBody) {
        if (todaysLogs.length > 0) {
            // Group logs by worker, extracting times from action logs
            const logsByWorker = {};
            todaysLogs.forEach(log => {
                const workerId = log.workerId;
                if (!logsByWorker[workerId]) {
                    logsByWorker[workerId] = {
                        workerName: log.workerName,
                        workerId: workerId,
                        workerRole: log.workerRole,
                        timeIn: null,
                        breakOut: null,
                        breakIn: null,
                        timeOut: null
                    };
                }
                // Determine action from log
                const action = log.action || 'time_in';
                const timeValue = log.timeIn || (log.createdAt ? log.createdAt.substring(11, 16) : null);
                
                if (action === 'time_in') logsByWorker[workerId].timeIn = timeValue;
                if (action === 'break_out') logsByWorker[workerId].breakOut = timeValue;
                if (action === 'break_in') logsByWorker[workerId].breakIn = timeValue;
                if (action === 'time_out') logsByWorker[workerId].timeOut = timeValue;
            });
            
            logBody.innerHTML = Object.values(logsByWorker).map(log => {
                // Get status for each action
                const timeInStatus = getActionStatus('time_in', log);
                const breakOutStatus = getActionStatus('break_out', log);
                const breakInStatus = getActionStatus('break_in', log);
                const timeOutStatus = getActionStatus('time_out', log);
                
                const statusColors = {
                    'Pending': '#9ca3af',
                    'On Time': '#22c55e',
                    'Early': '#10b981',
                    'Late': '#f97316',
                    'Late Break': '#f97316',
                    'Over Break': '#d97706',
                    'Overtime': '#8b5cf6'
                };
                
                // Overall status is determined by the overall workflow status
                const overallStatus = getAttendanceStatus(log);
                const overallStatusColors = {
                    'Pending': '#9ca3af',
                    'Absent': '#ef4444',
                    'Late': '#f97316',
                    'Present': '#22c55e',
                    'On Break': '#3b82f6',
                    'Pending Break In': '#ec4899',
                    'Pending Time Out': '#eab308',
                    'Overtime': '#8b5cf6',
                    'Over Break': '#d97706'
                };
                const overallStatusColor = overallStatusColors[overallStatus] || '#22c55e';
                
                // Determine color for each time cell based on action status
                const getTimeDisplay = (time, status) => {
                    if (!time) return '<span style="color:var(--muted);">—</span>';
                    const color = statusColors[status] || '#22c55e';
                    return `<span style="color:${color}; font-weight:600;">${time}</span>`;
                };
                
                // Calculate Time Out status dynamically if worker has completed time out
                let finalStatus = overallStatus;
                if (log.timeOut) {
                    // Calculate dynamic status based on Time Out value
                    const timeOutMinutes = timeToMinutes(log.timeOut);
                    const fivepmMinutes = 17 * 60;  // 5:00 PM
                    const sixpmMinutes = 18 * 60;   // 6:00 PM
                    
                    if (timeOutMinutes < fivepmMinutes) {
                        finalStatus = 'Early Out';
                    } else if (timeOutMinutes < sixpmMinutes) {
                        finalStatus = 'Done';
                    } else {
                        finalStatus = 'Overtime';
                    }
                }
                
                const finalStatusColors = {
                    'Pending': '#9ca3af',
                    'Absent': '#ef4444',
                    'Late': '#f97316',
                    'Present': '#22c55e',
                    'On Break': '#3b82f6',
                    'Pending Break In': '#ec4899',
                    'Pending Time Out': '#eab308',
                    'Early Out': '#10b981',
                    'Done': '#22c55e',
                    'Overtime': '#8b5cf6',
                    'Over Break': '#d97706'
                };
                const finalStatusColor = finalStatusColors[finalStatus] || '#22c55e';

                return `
                    <tr>
                        <td>
                            <div class="worker-row">
                                <div class="worker-avatar">${getInitials(log.workerName)}</div>
                                <span>${escapeHtml(log.workerName)}</span>
                            </div>
                        </td>
                        <td style="color:var(--muted);">${escapeHtml(log.workerId)}</td>
                        <td style="color:var(--muted);">${escapeHtml(log.workerRole)}</td>
                        <td>${getTimeDisplay(log.timeIn, timeInStatus)}</td>
                        <td>${getTimeDisplay(log.breakOut, breakOutStatus)}</td>
                        <td>${getTimeDisplay(log.breakIn, breakInStatus)}</td>
                        <td>${getTimeDisplay(log.timeOut, timeOutStatus)}</td>
                        <td><span style="background:${finalStatusColor}15; color:${finalStatusColor}; padding:4px 8px; border-radius:6px; font-size:11px; font-weight:600;">${finalStatus}</span></td>
                    </tr>
                `;
            }).join('');
        } else {
            logBody.innerHTML = '<tr><td colspan="8" style="text-align:center; color:var(--muted); padding:24px;">No attendance logs recorded yet.</td></tr>';
        }
    }
    
    // Update worker roster - compact version
    const rosterEl = document.getElementById('workerRosterCompact');
    const emptyRosterEl = document.getElementById('enrolledWorkersEmpty');
    const countLabelEl = document.getElementById('enrolledCountLabel');
    
    if (rosterEl) {
        if (projectWorkers.length === 0) {
            rosterEl.innerHTML = '';
            if (emptyRosterEl) emptyRosterEl.style.display = 'flex';
        } else {
            if (emptyRosterEl) emptyRosterEl.style.display = 'none';
            
            rosterEl.innerHTML = projectWorkers.map(worker => {
                const hasLog = todaysLogs.some(log => log.workerId === worker.id);
                const workerLogs = todaysLogs.filter(log => log.workerId === worker.id);
                const lastAction = workerLogs.length > 0 ? workerLogs[workerLogs.length - 1].action || 'time_in' : null;
                
                return `
                    <div class="worker-card-compact">
                        <div class="worker-card-compact-avatar">${getInitials(worker.name)}</div>
                        <div class="worker-card-compact-info">
                            <div class="worker-card-compact-name">${escapeHtml(worker.name)}</div>
                            <div class="worker-card-compact-meta">${escapeHtml(worker.id)}</div>
                        </div>
                        ${hasLog ? `<button class="worker-action-btn" title="${(lastAction || 'time_in').replace('_', ' ')}">✓</button>` : ''}
                    </div>
                `;
            }).join('');
        }
        
        if (countLabelEl) {
            countLabelEl.textContent = projectWorkers.length + ' Workers';
        }
    }

    // Update worker logs dropdown
    const logsSelect = document.getElementById('workerLogsSelect');
    if (logsSelect) {
        const selectedValue = logsSelect.value;
        logsSelect.innerHTML = '<option value="">-- Choose a worker --</option>' +
            projectWorkers.map(worker => `<option value="${escapeHtml(worker.id)}">${escapeHtml(worker.name)} (${escapeHtml(worker.id)})</option>`).join('');
        if (selectedValue) {
            logsSelect.value = selectedValue;
        }
    }
}

/**
 * Display worker logs with advanced filtering
 * @param {string} selectedDate - Date filter in YYYY-MM-DD format
 * @param {string} selectedStatus - Status filter (empty for all)
 * @param {string} searchTerm - Search term for worker name or ID
 */
function displayFilteredWorkerLogs(selectedDate, selectedStatus, searchTerm) {
    const project = attendanceState.currentProject;
    
    // Filter logs by date, project, and optionally by status and worker search
    let filteredLogs = attendanceState.logs.filter(log => {
        // Filter by project
        if (log.project !== project) return false;
        
        // Filter by date
        if (log.dateKey !== selectedDate) return false;
        
        // Filter by search term (worker name or ID)
        if (searchTerm) {
            const worker = attendanceState.workers.find(w => w.id === log.workerId);
            const matchesSearch = log.workerId.toLowerCase().includes(searchTerm) || 
                                 (worker && worker.name.toLowerCase().includes(searchTerm));
            if (!matchesSearch) return false;
        }
        
        return true;
    });
    
    // Group by worker to calculate overall status
    const logsByWorker = {};
    filteredLogs.forEach(log => {
        const workerId = log.workerId;
        if (!logsByWorker[workerId]) {
            logsByWorker[workerId] = {
                workerName: log.workerName,
                workerId: workerId,
                workerRole: log.workerRole,
                timeIn: null,
                breakOut: null,
                breakIn: null,
                timeOut: null
            };
        }
        const action = log.action || 'time_in';
        const timeValue = log.timeIn || (log.createdAt ? log.createdAt.substring(11, 16) : null);
        
        if (action === 'time_in') logsByWorker[workerId].timeIn = timeValue;
        if (action === 'break_out') logsByWorker[workerId].breakOut = timeValue;
        if (action === 'break_in') logsByWorker[workerId].breakIn = timeValue;
        if (action === 'time_out') logsByWorker[workerId].timeOut = timeValue;
    });
    
    // Apply status filter and render
    const placeholder = document.getElementById('workerLogsPlaceholder');
    const logBody = document.getElementById('workerLogsBody');
    
    if (!logBody) return;
    
    const workerRecords = Object.values(logsByWorker);
    
    // Filter by status if selected
    let displayRecords = workerRecords;
    if (selectedStatus) {
        displayRecords = workerRecords.filter(record => {
            const status = getWorkerDayStatus(record);
            
            if (selectedStatus === 'Active') {
                return status === 'Present' || status === 'Late' || status === 'On Break';
            } else {
                return status === selectedStatus;
            }
        });
    }
    
    if (displayRecords.length === 0) {
        logBody.innerHTML = '';
        if (placeholder) placeholder.style.display = 'block';
        return;
    }
    
    if (placeholder) placeholder.style.display = 'none';
    
    logBody.innerHTML = displayRecords.map(record => {
        const status = getWorkerDayStatus(record);
        
        const statusColors = {
            'Pending': '#9ca3af',
            'Absent': '#ef4444',
            'Late': '#f97316',
            'Present': '#22c55e',
            'On Break': '#3b82f6',
            'Pending Break In': '#ec4899',
            'Pending Time Out': '#eab308',
            'Early Out': '#10b981',
            'Done': '#22c55e',
            'Overtime': '#8b5cf6',
            'Over Break': '#d97706'
        };
        const statusColor = statusColors[status] || '#22c55e';
        
        return `
            <tr>
                <td>
                    <div class="worker-row">
                        <div class="worker-avatar">${getInitials(record.workerName)}</div>
                        <span>${escapeHtml(record.workerName)}</span>
                    </div>
                </td>
                <td style="color:var(--muted);">${selectedDate}</td>
                <td style="color:var(--text);">${record.timeIn ? record.timeIn : '<span style="color:var(--muted);">—</span>'}</td>
                <td style="color:var(--text);">${record.breakOut ? record.breakOut : '<span style="color:var(--muted);">—</span>'}</td>
                <td style="color:var(--text);">${record.breakIn ? record.breakIn : '<span style="color:var(--muted);">—</span>'}</td>
                <td style="color:var(--text);">${record.timeOut ? record.timeOut : '<span style="color:var(--muted);">—</span>'}</td>
                <td><span style="background:${statusColor}15; color:${statusColor}; padding:4px 8px; border-radius:6px; font-size:11px; font-weight:600;">${status}</span></td>
            </tr>
        `;
    }).join('');
}

/**
 * Get worker's overall status for the day
 * @param {Object} workerLog - Worker attendance record with timeIn, breakOut, breakIn, timeOut
 * @returns {string} Status string
 */
function getWorkerDayStatus(workerLog) {
    const hasTimeIn = !!workerLog.timeIn;
    const hasBreakOut = !!workerLog.breakOut;
    const hasBreakIn = !!workerLog.breakIn;
    const hasTimeOut = !!workerLog.timeOut;

    if (!hasTimeIn) {
        return 'Pending';
    }

    const timeInMinutes = timeToMinutes(workerLog.timeIn);
    const lateThresholdMinutes = 7 * 60 + 15;  // 7:15 AM
    const isLate = timeInMinutes > lateThresholdMinutes;

    let breakDuration = 0;
    if (hasBreakOut && hasBreakIn) {
        const breakOutMinutes = timeToMinutes(workerLog.breakOut);
        const breakInMinutes = timeToMinutes(workerLog.breakIn);
        if (breakOutMinutes && breakInMinutes) {
            breakDuration = breakInMinutes - breakOutMinutes;
        }
    }

    if (!hasTimeOut) {
        if (hasBreakOut && !hasBreakIn) {
            return 'On Break';
        }
        // After break in, worker is back to work - show "Present" not "Pending Time Out"
        if (hasBreakIn && !hasTimeOut) {
            return isLate ? 'Late' : 'Present';
        }
        return isLate ? 'Late' : 'Present';
    }

    const timeOutMinutes = timeToMinutes(workerLog.timeOut);
    const fivepmMinutes = 17 * 60;      // 5:00 PM
    const sixpmMinutes = 18 * 60;        // 6:00 PM
    
    const isOverBreak = breakDuration > 60;  // More than 1 hour

    if (isOverBreak) {
        return 'Over Break';
    }

    if (timeOutMinutes < fivepmMinutes) {
        return 'Early Out';
    } else if (timeOutMinutes < sixpmMinutes) {
        return 'Done';
    } else {
        return 'Overtime';
    }
}

function displayWorkerLogs(workerId) {
    const worker = attendanceState.workers.find(w => w.id === workerId);
    const allWorkerLogs = attendanceState.logs.filter(log => log.workerId === workerId);
    const todayKey = new Date().toISOString().slice(0, 10);
    const todaysLogs = allWorkerLogs.filter(log => log.dateKey === todayKey);

    const placeholder = document.getElementById('workerLogsPlaceholder');
    const logBody = document.getElementById('workerLogsBody');
    
    if (!logBody) return;

    if (todaysLogs.length === 0) {
        logBody.innerHTML = '';
        if (placeholder) placeholder.style.display = 'block';
        return;
    }

    if (placeholder) placeholder.style.display = 'none';

    const actions = [
        { key: 'time_in', label: 'Time In', icon: 'clock' },
        { key: 'break_out', label: 'Break Out', icon: 'box-arrow-right' },
        { key: 'break_in', label: 'Break In', icon: 'box-arrow-left' },
        { key: 'time_out', label: 'Time Out', icon: 'clock-history' }
    ];

    // Build a complete worker log object to calculate status
    const workerLog = {
        timeIn: null,
        breakOut: null,
        breakIn: null,
        timeOut: null
    };
    
    todaysLogs.forEach(log => {
        const action = log.action || 'time_in';
        const timeValue = log.timeIn || (log.createdAt ? log.createdAt.substring(11, 16) : null);
        if (action === 'time_in') workerLog.timeIn = timeValue;
        if (action === 'break_out') workerLog.breakOut = timeValue;
        if (action === 'break_in') workerLog.breakIn = timeValue;
        if (action === 'time_out') workerLog.timeOut = timeValue;
    });

    const statusColors = {
        'Pending': '#9ca3af',
        'On Time': '#22c55e',
        'Early': '#10b981',
        'Late': '#f97316',
        'Late Break': '#f97316',
        'Over Break': '#d97706',
        'Overtime': '#8b5cf6'
    };

    logBody.innerHTML = actions.map(action => {
        const log = todaysLogs.find(l => (l.action || 'time_in') === action.key);
        const timeDisplay = log ? (log.timeIn || (log.createdAt ? log.createdAt.substring(11, 16) : '—')) : '—';
        
        // Get status for this specific action
        const actionStatus = getActionStatus(action.key, workerLog);
        const statusColor = statusColors[actionStatus] || '#9ca3af';
        
        // Calculate expected time for break in if break out is recorded
        let expectedTimeDisplay = '';
        if (action.key === 'break_in' && workerLog.breakOut && !workerLog.breakIn) {
            const expectedTime = getExpectedBreakInTime(workerLog.breakOut);
            expectedTimeDisplay = `<div style="font-size:10px; color:var(--muted); margin-top:2px;">Expected: ${expectedTime ? formatClock(expectedTime) : '—'}</div>`;
        }
        
        return `
            <tr>
                <td style="font-weight:600; color:var(--text);">${action.label}${expectedTimeDisplay}</td>
                <td style="color:var(--text);">${timeDisplay}</td>
                <td><span style="background:${statusColor}15; color:${statusColor}; padding:4px 8px; border-radius:6px; font-size:11px; font-weight:600;">${actionStatus}</span></td>
            </tr>
        `;
    }).join('');
}

function toggleEnrolledWorkers() {
    const panel = document.getElementById('enrolledWorkersPanel');
    const icon = document.getElementById('enrolledToggleIcon');
    
    if (panel) {
        const isCollapsed = panel.style.maxHeight === '0px' || panel.style.maxHeight === '';
        if (isCollapsed) {
            panel.style.maxHeight = '300px';
            icon.style.transform = 'rotate(0deg)';
        } else {
            panel.style.maxHeight = '0px';
            icon.style.transform = 'rotate(-90deg)';
        }
    }
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return String(text || '').replace(/[&<>"']/g, m => map[m]);
}

/**
 * Get match status and label based on euclidean distance score
 * Distance-based classification aligned with admin tolerance:
 * - distance 0.0-0.30: Verified (95-100% confidence - perfect match)
 * - distance 0.30-0.45: Verified (90-95% confidence - high match)
 * - distance 0.45-0.60: Possible (80-89% confidence - needs review)
 * - distance >0.60: Rejected (below 80% confidence)
 * 
 * @param {number} distance - Euclidean distance between face descriptors (lower = better)
 * @returns {{status: string, label: string, color: string, badge: string, confidence: number}}
 */
function getMatchStatus(distance) {
    let confidence = 0;
    let status = 'rejected';
    
    if (distance <= 0.30) {
        // Perfect/excellent match
        confidence = Math.round(95 + ((0.30 - distance) / 0.30) * 5);
        status = 'verified';
    } else if (distance <= 0.45) {
        // High-confidence match
        confidence = Math.round(90 + ((0.45 - distance) / 0.15) * 5);
        status = 'verified';
    } else if (distance <= 0.60) {
        // Admin-tolerant possible match
        confidence = Math.round(80 + ((0.60 - distance) / 0.15) * 9);
        status = 'possible';
    } else {
        // Not a match
        confidence = 0;
        status = 'rejected';
    }

    const statusMap = {
        verified: {
            label: 'Verified Match',
            color: '#16a34a',
            badge: '���'
        },
        possible: {
            label: 'Possible Match',
            color: '#f59e0b',
            badge: '⚠'
        },
        rejected: {
            label: 'Unrecognized',
            color: '#ef4444',
            badge: '✗'
        }
    };

    const info = statusMap[status];
    return {
        status,
        label: info.label,
        color: info.color,
        badge: info.badge,
        confidence: Math.max(0, Math.min(100, confidence))
    };
}

/**
 * Suppress duplicate detections, keep highest confidence for each worker
 * @param {Array} matchResults - Array of {detection, worker, score} objects (score = euclidean distance)
 * @returns {{verified: Array, possible: Array, rejected: Array, duplicates: Array}}
 */
function suppressDuplicates(matchResults) {
    const verified = [];
    const possible = [];
    const rejected = [];
    const duplicates = [];
    const seenWorkers = new Map(); // Track workers and their best scores

    // Sort by score ascending (lower distance = better match)
    const sorted = [...matchResults].sort((a, b) => a.score - b.score);

    sorted.forEach(result => {
        const workerId = result.worker.id;
        const distance = result.score;

        // If we've already seen this worker
        if (seenWorkers.has(workerId)) {
            duplicates.push(result);
            return;
        }

        // Mark worker as seen
        seenWorkers.set(workerId, distance);

        // Categorize by distance-based thresholds
        const statusInfo = getMatchStatus(distance);
        if (statusInfo.status === 'verified') {
            verified.push({ ...result, confidence: statusInfo.confidence, matchStatus: 'verified' });
        } else if (statusInfo.status === 'possible') {
            possible.push({ ...result, confidence: statusInfo.confidence, matchStatus: 'possible' });
        } else {
            rejected.push({ ...result, confidence: statusInfo.confidence, matchStatus: 'rejected' });
        }
    });

    return { verified, possible, rejected, duplicates };
}

/**
 * Calculate detection statistics for display
 * @param {Array} clusteredDetections - Detected faces
 * @param {Object} dupResults - Results from suppressDuplicates()
 * @returns {{total: number, verified: number, possible: number, unrecognized: number, matchPercentage: number}}
 */
function calculateDetectionStats(clusteredDetections, dupResults, allMatches) {
    const total = clusteredDetections.length;
    const verified = dupResults.verified.length;
    const possible = dupResults.possible.length;
    const rejected = dupResults.rejected.length;
    const duplicates = dupResults.duplicates.length;
    const unrecognized = total - verified - possible - rejected - duplicates;
    
    // Calculate match percentage: successful matches / total detected faces
    const totalMatches = verified + possible;
    const matchPercentage = total > 0 ? Math.round((totalMatches / total) * 100) : 0;

    return {
        total,
        verified,
        possible,
        unrecognized: Math.max(0, total - verified - possible - duplicates), // Unrecognized count
        duplicates,
        matchPercentage,
        matchPercentageLabel: `${verified + possible}/${total}`
    };
}

function findBestMatch(descriptor, projectFilter = null) {
    let bestWorker = null;
    let bestScore = Number.POSITIVE_INFINITY;
    const DISTANCE_THRESHOLD = 0.60; // Align with admin matcher tolerance

    attendanceState.workers.forEach(worker => {
        // Filter by project if provided
        if (projectFilter && worker.project !== projectFilter) return;
        
        const storedDescriptors = readStoredDescriptor(worker);
        if (!storedDescriptors || !storedDescriptors.length) return;
        
        // Compare against all stored reference descriptors for this worker
        let bestWorkerScore = Number.POSITIVE_INFINITY;
        storedDescriptors.forEach(ref => {
            // Check descriptor array length matches
            if (!Array.isArray(ref) || ref.length !== descriptor.length) return;
            
            const score = euclideanDistance(descriptor, ref);
            if (score < bestWorkerScore) {
                bestWorkerScore = score;
            }
        });
        
        // Keep track of overall best match
        if (bestWorkerScore < bestScore) {
            bestScore = bestWorkerScore;
            bestWorker = worker;
        }
    });
    
    // Return match only if within threshold, otherwise try without project filter as fallback
    if (bestWorker && bestScore <= DISTANCE_THRESHOLD) {
        return { worker: bestWorker, score: bestScore };
    }
    
    // Fallback: try matching without project filter if first attempt failed
    if (projectFilter && !bestWorker) {
        return findBestMatch(descriptor, null);
    }
    
    return null;
}

/**
 * Determine the next valid attendance action based on worker's current state
 * @param {string} workerId - Worker ID
 * @param {string} dateKey - Date key
 * @returns {string} Next action: 'time_in', 'break_out', 'break_in', or 'time_out'
 */
function determineNextAction(workerId, dateKey) {
    // Get today's logs for this worker
    const workerLogs = attendanceState.logs.filter(log => 
        log.workerId === workerId && 
        log.dateKey === dateKey
    );

    if (workerLogs.length === 0) {
        return 'time_in'; // First action must be time_in
    }

    const lastLog = workerLogs[workerLogs.length - 1];
    const lastAction = lastLog.action || 'time_in';

    // Determine next action based on workflow sequence
    if (lastAction === 'time_in') {
        return 'break_out';
    } else if (lastAction === 'break_out') {
        return 'break_in';
    } else if (lastAction === 'break_in') {
        return 'time_out';
    } else if (lastAction === 'time_out') {
        return 'time_in'; // Cycle can restart
    }

    return 'time_in'; // Default fallback
}

/**
 * Record attendance with confidence-based validation
 * @param {Object} worker - Worker object
 * @param {number} distance - Euclidean distance score
 * @param {string} matchStatus - 'verified', 'possible', or 'rejected'
 * @param {number} confidence - Confidence percentage 0-100
 */
function recordAttendance(worker, distance, matchStatus = 'possible', confidence = 0) {
    // Only log verified and possible matches
    if (matchStatus === 'rejected') {
        return;
    }

    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const timeStr = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    const dateKey = now.toISOString().slice(0, 10);
    const project = attendanceState.currentProject;
    
    // Check if worker has already completed all 4 cycles for today
    if (isAttendanceCompleted(worker.id, dateKey, project)) {
        // Silently skip recording - worker has completed all cycles
        console.log('[v0] Attendance complete for', worker.name, '- skipping duplicate');
        return;
    }
    
    // Determine the correct next action based on worker's current state
    const nextAction = determineNextAction(worker.id, dateKey);
    
    // For Time In actions, check for existing records
    if (nextAction === 'time_in') {
        const existingTimeIn = attendanceState.logs.find(log => 
            log.workerId === worker.id && 
            log.project === project && 
            log.dateKey === dateKey &&
            (log.action || 'time_in') === 'time_in'
        );

        if (existingTimeIn) {
            // Update only if new score is better (lower distance = better)
            if (distance < (existingTimeIn.distance || Number.MAX_VALUE)) {
                existingTimeIn.workerName = worker.name;
                existingTimeIn.workerRole = worker.role;
                existingTimeIn.timeIn = timeStr;
                existingTimeIn.score = Math.round(confidence);
                existingTimeIn.distance = distance;
                existingTimeIn.matchStatus = matchStatus;
                existingTimeIn.scanSource = 'group_photo';
                existingTimeIn.createdAt = now.toISOString();
            }
            persistLogs();
            return; // Don't record duplicate
        }
    }

    // Create new action record with the correct action type
    const newLog = {
        id: `${worker.id}_${dateKey}_${nextAction}_${Date.now()}`,
        workerId: worker.id,
        workerName: worker.name,
        workerRole: worker.role,
        project,
        dateKey,
        timeIn: timeStr,
        createdAt: now.toISOString(),
        action: nextAction,  // Use the determined next action
        score: Math.round(confidence),
        distance,
        matchStatus,
        scanSource: 'group_photo',
    };

    // Add new record
    attendanceState.logs.push(newLog);
    persistLogs();
    
    // Update UI in real time
    renderAttendanceModule();
    
    // Update worker logs display if this worker is selected
    const logsSelect = document.getElementById('workerLogsSelect');
    if (logsSelect && logsSelect.value === worker.id) {
        displayWorkerLogs(worker.id);
    }
    
    // Send to API asynchronously (don't block UI)
    sendAttendanceApi('save-attendance', { log: newLog })
        .then(response => {
            if (!response.success && response.message) {
                // Show validation error if attendance is complete
                if (response.message.includes('Attendance already completed') || response.message.includes('Duplicate attendance')) {
                    showAlert('Attendance Complete', response.message, 'warning');
                }
            }
        })
        .catch(() => {
            // Silently handle API errors - local data is persisted
        });
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
            .detectAllFaces(image, new faceapi.TinyFaceDetectorOptions({ inputSize: 800, scoreThreshold: 0.05 }))
            .withFaceLandmarks()
            .withFaceDescriptors();

        // Filter and cluster overlapping faces, validate quality
        const validDetections = detections.filter(isValidFaceDetection);
        const clusteredDetections = clusterOverlappingFaces(validDetections, 0.3);

        if (!clusteredDetections.length) {
            // Reset stats
            const summaryDiv = document.getElementById('detectionSummary');
            if (summaryDiv) {
                document.getElementById('statDetected').textContent = '0';
                document.getElementById('statVerified').textContent = '0';
                document.getElementById('statPossible').textContent = '0';
                document.getElementById('statDuplicates').textContent = '0';
                document.getElementById('statUnrecognized').textContent = '0';
                document.getElementById('statHighest').textContent = '0%';
                document.getElementById('statHighestName').textContent = '—';
            }
            renderAttendanceModule();
            showAttendanceStatus('No valid faces were detected in the uploaded photo. Try a clearer group image.');
            showFaceMeta('Nothing matched because no faces met quality standards.');
            document.getElementById('groupPhotoResults').style.display = 'none';
            document.getElementById('detectionSummary').style.display = 'none';
            showToast('No valid faces detected.');
            return;
        }

        // Find matches for all detections
        const allMatches = [];
        clusteredDetections.forEach((detection, idx) => {
            const detectorArray = Array.from(detection.descriptor);
            const match = findBestMatch(detectorArray, attendanceState.currentProject);
            
            if (match) {
                allMatches.push(match);
            }
        });

        // Suppress duplicates and categorize by confidence
        const dupResults = suppressDuplicates(allMatches);

        // Calculate statistics
        const stats = calculateDetectionStats(clusteredDetections, dupResults, allMatches);

        // Update stat cards
        const summaryDiv = document.getElementById('detectionSummary');
        if (summaryDiv) {
            document.getElementById('statDetected').textContent = stats.total;
            document.getElementById('statVerified').textContent = stats.verified;
            document.getElementById('statPossible').textContent = stats.possible;
            document.getElementById('statUnrecognized').textContent = stats.unrecognized;
            document.getElementById('statMatchPercentage').textContent = stats.matchPercentage + '%';
            document.getElementById('statMatchPercentageNote').textContent = stats.matchPercentageLabel;
            summaryDiv.style.display = 'grid';
        }

        // Log verified matches (auto-log 90%+)
        const verifiedWorkers = [];
        const possibleWorkers = [];
        
        dupResults.verified.forEach(result => {
            recordAttendance(result.worker, result.score, 'verified', result.confidence);
            verifiedWorkers.push({
                ...result.worker,
                confidence: result.confidence,
                matchStatus: 'verified'
            });
        });

        // Log possible matches for manual review
        dupResults.possible.forEach(result => {
            recordAttendance(result.worker, result.score, 'possible', result.confidence);
            possibleWorkers.push({
                ...result.worker,
                confidence: result.confidence,
                matchStatus: 'possible'
            });
        });

        // Display results with badges
        const resultsDiv = document.getElementById('groupPhotoResults');
        const resultsBody = document.getElementById('groupPhotoResultsBody');
        if (resultsDiv && resultsBody) {
            const allResults = [...verifiedWorkers, ...possibleWorkers];
            if (allResults.length) {
                resultsBody.innerHTML = allResults.map(w => {
                    const statusClass = w.matchStatus === 'verified' 
                        ? 'result-badge-verified' 
                        : 'result-badge-possible';
                    const badge = w.matchStatus === 'verified' ? '✓' : '⚠';
                    const statusLabel = w.matchStatus === 'verified' 
                        ? `Verified ${Math.round(w.confidence)}%` 
                        : `Possible ${Math.round(w.confidence)}%`;
                    
                    return `
                        <div class="result-item">
                            <div class="result-worker-info">
                                <div class="result-name">${escapeHtml(w.name)}</div>
                                <div class="result-role">${escapeHtml(w.id)} • ${escapeHtml(w.role)}</div>
                            </div>
                            <div class="result-badge ${statusClass}">
                                ${badge} ${statusLabel}
                            </div>
                        </div>
                    `;
                }).join('');
                resultsDiv.style.display = 'block';
            } else {
                resultsBody.innerHTML = '<div style="text-align:center; color:var(--muted); font-size:12px; padding:12px;">No matches found in this upload.</div>';
                resultsDiv.style.display = 'block';
            }
        }

        // Update last scan stats with detection and match information
        attendanceState.lastScan = {
            detected: stats.total,
            matched: stats.verified + stats.possible,
            verified: stats.verified,
            possible: stats.possible,
            unrecognized: stats.unrecognized,
            duplicate: stats.duplicates,
            matchPercentage: stats.matchPercentage
        };
        
        renderAttendanceModule();
        
        // Show summary message
        const summaryMsg = `Detected: ${stats.total} | Matched: ${stats.verified + stats.possible} (${stats.matchPercentage}%) | Verified: ${stats.verified}✓ | Possible: ${stats.possible}⚠ | Unrecognized: ${stats.unrecognized}✗`;
        showAttendanceStatus(summaryMsg);
        showFaceMeta(`Analysis complete. ${stats.verified} verified matches auto-logged. ${stats.possible > 0 ? stats.possible + ' require review.' : ''}`);
        showToast(`Complete: ${stats.verified} verified, ${stats.possible} possible, ${stats.unrecognized} unrecognized`);
    } catch (error) {
        console.error('[v0] Processing error:', error);
        // Reset stats on error
        const summaryDiv = document.getElementById('detectionSummary');
        if (summaryDiv) {
            document.getElementById('statDetected').textContent = '0';
            document.getElementById('statVerified').textContent = '0';
            document.getElementById('statPossible').textContent = '0';
            document.getElementById('statUnrecognized').textContent = '0';
            document.getElementById('statMatchPercentage').textContent = '0%';
        }
        renderAttendanceModule();
        showAttendanceStatus('Group photo analysis failed. Upload a clearer image and try again.');
        document.getElementById('groupPhotoResults').style.display = 'none';
        document.getElementById('detectionSummary').style.display = 'none';
        showToast('Face matching failed: ' + error.message);
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

    // Toggle between Today's Attendance and Worker Attendance History
    const attendanceViewToggle = document.getElementById('attendanceViewToggle');
    if (attendanceViewToggle) {
        attendanceViewToggle.addEventListener('change', function() {
            const viewType = this.value;
            const attendanceViewTitle = document.getElementById('attendanceViewTitle');
            const todaysAttendanceCard = document.getElementById('todaysAttendanceCard');
            const attendanceHistoryTable = document.getElementById('attendanceHistoryTable');
            
            if (viewType === 'today') {
                // Show Today's Attendance table
                if (attendanceViewTitle) attendanceViewTitle.textContent = "Today's Attendance";
                if (todaysAttendanceCard) todaysAttendanceCard.style.display = 'block';
                if (attendanceHistoryTable) attendanceHistoryTable.style.display = 'none';
            } else {
                // Show Worker Attendance History table
                if (attendanceViewTitle) attendanceViewTitle.textContent = "Work Attendance History";
                if (todaysAttendanceCard) todaysAttendanceCard.style.display = 'none';
                if (attendanceHistoryTable) attendanceHistoryTable.style.display = 'block';
            }
        });
    }

    document.getElementById('groupPhotoInput')?.addEventListener('change', function() {
        updateGroupPhotoPreview(this.files?.[0]).catch(() => {
            showAttendanceStatus('Unable to preview the selected photo.');
        });
    });
    document.getElementById('processGroupBtn')?.addEventListener('click', processGroupPhoto);
    document.getElementById('clearGroupBtn')?.addEventListener('click', clearGroupPhoto);

    // Advanced Worker Logs Filtering
    const dateFilterInput = document.getElementById('workerLogsDateFilter');
    const statusFilterSelect = document.getElementById('workerLogsStatusFilter');
    const searchFilterInput = document.getElementById('workerLogsSearchFilter');
    
    // Set date filter to today by default
    if (dateFilterInput) {
        const today = new Date().toISOString().slice(0, 10);
        dateFilterInput.value = today;
    }
    
    // Update logs when any filter changes
    const updateLogsWithFilters = () => {
        const selectedDate = dateFilterInput?.value || new Date().toISOString().slice(0, 10);
        const selectedStatus = statusFilterSelect?.value || '';
        const searchTerm = searchFilterInput?.value?.toLowerCase().trim() || '';
        
        displayFilteredWorkerLogs(selectedDate, selectedStatus, searchTerm);
    };
    
    if (dateFilterInput) {
        dateFilterInput.addEventListener('change', updateLogsWithFilters);
    }
    if (statusFilterSelect) {
        statusFilterSelect.addEventListener('change', updateLogsWithFilters);
    }
    if (searchFilterInput) {
        searchFilterInput.addEventListener('input', updateLogsWithFilters);
    }
    
    // Initial display
    updateLogsWithFilters();
    
    // Auto-refresh Worker Logs every 3 seconds for real-time updates
    let logsRefreshInterval = setInterval(() => {
        if (attendanceState.initialized) {
            updateLogsWithFilters();
        }
    }, 3000);
    
    // Clean up interval if page unloads
    window.addEventListener('beforeunload', () => {
        if (logsRefreshInterval) clearInterval(logsRefreshInterval);
    });

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
        window.location.href = 'logout.php';
    }
}

/**
 * Check if worker has completed all 4 cycles (Time In, Break Out, Break In, Time Out) for the day
 * @param {string} workerId - Worker ID
 * @param {string} dateKey - Date key (YYYY-MM-DD)
 * @param {string} project - Project name
 * @returns {boolean} True if all cycles completed
 */
function isAttendanceCompleted(workerId, dateKey, project) {
    const workerLogs = attendanceState.logs.filter(log => 
        log.workerId === workerId && 
        log.dateKey === dateKey && 
        log.project === project
    );

    const hasTimeIn = workerLogs.some(log => (log.action || 'time_in') === 'time_in');
    const hasBreakOut = workerLogs.some(log => (log.action || 'time_in') === 'break_out');
    const hasBreakIn = workerLogs.some(log => (log.action || 'time_in') === 'break_in');
    const hasTimeOut = workerLogs.some(log => (log.action || 'time_in') === 'time_out');

    return hasTimeIn && hasBreakOut && hasBreakIn && hasTimeOut;
}

/**
 * Record a specific attendance action (Break Out, Break In, Time Out)
 * @param {string} workerId - Worker ID
 * @param {string} action - Action type: 'break_out', 'break_in', or 'time_out'
 */
function recordAttendanceAction(workerId, action) {
    const now = new Date();
    const timeStr = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
    const dateKey = now.toISOString().slice(0, 10);
    const project = attendanceState.currentProject;
    
    const worker = attendanceState.workers.find(w => w.id === workerId);
    if (!worker) {
        showToast(`Worker not found`);
        return;
    }

    // Check if worker has already completed all cycles for today
    if (isAttendanceCompleted(workerId, dateKey, project)) {
        showAlert('Attendance Complete', 'Attendance already completed for today. Duplicate attendance detected.', 'warning');
        return;
    }

    // Check workflow rules
    const workerTodayLogs = attendanceState.logs.filter(log => 
        log.workerId === workerId && 
        log.dateKey === dateKey && 
        log.project === project
    );

    const lastAction = workerTodayLogs.length > 0 
        ? workerTodayLogs[workerTodayLogs.length - 1].action || 'time_in'
        : null;

    // Validate workflow
    let isValid = true;
    let errorMsg = '';

    if (action === 'break_out') {
        if (lastAction !== 'time_in') {
            isValid = false;
            errorMsg = 'Must Time In before Break Out';
        }
    } else if (action === 'break_in') {
        if (lastAction !== 'break_out') {
            isValid = false;
            errorMsg = 'Must Break Out before Break In';
        }
    } else if (action === 'time_out') {
        if (!lastAction || lastAction === 'time_out') {
            isValid = false;
            errorMsg = 'Must Time In before Time Out';
        }
    }

    if (!isValid) {
        showAlert('Invalid Action', errorMsg, 'error');
        return;
    }

    // Create action log
    const actionLog = {
        id: `${workerId}_${dateKey}_${action}_${Date.now()}`,
        workerId: workerId,
        workerName: worker.name,
        workerRole: worker.role,
        project: project,
        dateKey: dateKey,
        timeIn: timeStr,
        createdAt: now.toISOString(),
        action: action,
        matchStatus: 'manual'
    };

    attendanceState.logs.push(actionLog);
    persistLogs();

    // Send to API
    sendAttendanceApi('save-attendance', { log: actionLog }).catch(() => {
        // Silently handle API errors
    });

    // Update UI with real-time refresh
    renderAttendanceModule();
    
    // Update worker logs display if this worker is selected
    const logsSelect = document.getElementById('workerLogsSelect');
    if (logsSelect && logsSelect.value === workerId) {
        displayWorkerLogs(workerId);
    }

    const actionLabels = {
        'break_out': 'Break Out',
        'break_in': 'Break In',
        'time_out': 'Time Out'
    };
    showToast(`${actionLabels[action]} recorded at ${timeStr}`);
}

function getInitials(name) {
    if (!name) return '?';
    const parts = name.trim().split(/\s+/);
    return (parts[0]?.[0] || '') + (parts[1]?.[0] || '');
}

function formatClock(timeStr) {
    if (!timeStr) return '—';
    const [h, m] = timeStr.split(':');
    const hour = parseInt(h, 10);
    const minute = parseInt(m, 10);
    const period = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
    return `${displayHour}:${String(minute).padStart(2, '0')} ${period}`;
}

/**
 * Convert time string (HH:MM) to minutes from midnight
 * @param {string} timeStr - Time in HH:MM format
 * @returns {number} Minutes from midnight
 */
function timeToMinutes(timeStr) {
    if (!timeStr) return null;
    const [h, m] = timeStr.split(':').map(Number);
    return h * 60 + m;
}

/**
 * Convert minutes from midnight to HH:MM time string
 * @param {number} minutes - Minutes from midnight
 * @returns {string} Time in HH:MM format
 */
function minutesToTime(minutes) {
    if (minutes === null || minutes === undefined) return null;
    const h = Math.floor(minutes / 60);
    const m = minutes % 60;
    return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
}

/**
 * Calculate expected break in time based on break out time
 * Expected break in = break out time + 1 hour
 * @param {string} breakOutTimeStr - Break out time in HH:MM format
 * @returns {string} Expected break in time in HH:MM format
 */
function getExpectedBreakInTime(breakOutTimeStr) {
    if (!breakOutTimeStr) return null;
    const breakOutMinutes = timeToMinutes(breakOutTimeStr);
    if (breakOutMinutes === null) return null;
    const expectedBreakInMinutes = breakOutMinutes + WORK_SCHEDULE.breakDuration;
    return minutesToTime(expectedBreakInMinutes);
}

/**
 * Escape HTML special characters to prevent XSS
 * @param {string} text - Text to escape
 * @returns {string} Escaped text safe for HTML
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Show toast notification (bottom-right toast)
 * @param {string} message - Message to display
 */
function showToast(message) {
    const toast = document.getElementById('toast');
    if (toast) {
        toast.textContent = message;
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
        }, 3000);
    }
}

/**
 * Show modal alert dialog with title, message, and optional type styling
 * @param {string} title - Modal title
 * @param {string} message - Modal message
 * @param {string} type - Type: 'error', 'warning', 'success', 'info' (affects styling)
 */
function showAlert(title, message, type = 'info') {
    // Create modal HTML dynamically
    const modalId = 'alertModal_' + Date.now();
    const colorMap = {
        'error': { bg: 'rgba(220, 38, 38, 0.08)', border: 'rgba(220, 38, 38, 0.2)', text: '#dc2626' },
        'warning': { bg: 'rgba(245, 166, 35, 0.08)', border: 'rgba(245, 166, 35, 0.2)', text: '#f59e0b' },
        'success': { bg: 'rgba(34, 197, 94, 0.08)', border: 'rgba(34, 197, 94, 0.2)', text: '#22c55e' },
        'info': { bg: 'rgba(59, 130, 246, 0.08)', border: 'rgba(59, 130, 246, 0.2)', text: '#3b82f6' }
    };
    const colors = colorMap[type] || colorMap['info'];
    
    const modal = document.createElement('div');
    modal.id = modalId;
    modal.className = 'dg-modal';
    modal.innerHTML = `
        <div class="dg-modal-content">
            <div style="display:flex; align-items:flex-start; gap:12px; margin-bottom:12px;">
                <div style="font-size:24px; color:${colors.text}; flex-shrink:0;">
                    ${type === 'error' ? '⚠' : type === 'warning' ? '⚡' : type === 'success' ? '✓' : 'ℹ'}
                </div>
                <div style="flex:1;">
                    <div class="dg-modal-title" style="color:${colors.text};">${escapeHtml(title)}</div>
                    <div class="dg-modal-message">${escapeHtml(message)}</div>
                </div>
            </div>
            <div class="dg-modal-actions" style="margin-top:16px;">
                <button class="dg-modal-btn confirm" onclick="document.getElementById('${modalId}').remove();" style="background:${colors.text}; border-color:${colors.text}; color:#fff;">OK</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

/**
 * Show status message in attendance status area
 * @param {string} message - Status message
 */
function showAttendanceStatus(message) {
    const statusEl = document.getElementById('attendanceStatus');
    if (statusEl) {
        statusEl.textContent = message;
    }
}

/**
 * Show metadata/info message in face meta area
 * @param {string} message - Meta message
 */
function showFaceMeta(message) {
    const faceMetaEl = document.getElementById('faceMeta');
    if (faceMetaEl) {
        faceMetaEl.textContent = message;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initAttendanceModule();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWbSxccPQtF3EpF3fnJHog6LaEVF+z4NhkxqHY4xZe3Z8L0L" crossorigin="anonymous"></script>
<script src="js/facenet-group-attendance.js"></script>

</body>
</html>
