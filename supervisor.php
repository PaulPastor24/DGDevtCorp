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
    <link rel="stylesheet" href="css/supervisor.css?v=<?php echo filemtime('css/supervisor.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUarbnLLtQbOV5JnXwyIEo56nNmslbdkrMjW03fNvqrviJkur" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/responsive.css?v=<?php echo filemtime('css/responsive.css'); ?>">
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

            <div class="nav-section-label">System</div>
            <div class="nav-item" onclick="doLogout()">
                <i class="bi bi-box-arrow-right"></i>Sign Out
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
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
                    <select class="form-select" id="timeline-project-select" onchange="handleTimelineProjectChange(this)" style="width:240px;">
                        <option>Rizal Residential Complex</option>
                        <option>San Pablo Commercial Hub</option>
                        <option>Batangas Warehouse Facility</option>
                        <option>Lipa City Townhouse Dev.</option>
                    </select>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <span class="tag green" id="timeline-overall-status">On Track</span>
                        <span class="tag" id="timeline-complete-badge">62% Complete</span>
                        <span class="tag blue" id="timeline-phase-badge">Structural Works Phase</span>
                    </div>
                </div>

                <div style="max-width: 100%;">
                    <div class="card mb-0 timeline-card">
                        <div class="card-header">
                            <div class="card-title" id="timeline-card-title">Construction Phases - Rizal Residential Complex</div>
                            <div style="font-size:12px; color:var(--muted);" id="timeline-target-label">Target: Aug 2026</div>
                        </div>

                        <div class="timeline-summary">
                            <div class="timeline-summary-item">
                                <div class="timeline-summary-label">Completed</div>
                                <div class="timeline-summary-value green" id="timeline-completed-count">2 phases</div>
                            </div>
                            <div class="timeline-summary-item">
                                <div class="timeline-summary-label">In Progress</div>
                                <div class="timeline-summary-value blue" id="timeline-progress-count">1 phase</div>
                            </div>
                            <div class="timeline-summary-item">
                                <div class="timeline-summary-label">Upcoming</div>
                                <div class="timeline-summary-value yellow" id="timeline-upcoming-count">2 phases</div>
                            </div>
                        </div>

                        <div class="timeline-wrap" id="timeline-list"></div>
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
                                    <option>Phase 3 - Structural Works</option>
                                    <option>Phase 2 - Foundation Works</option>
                                    <option>Phase 4 - MEP Installation</option>
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
                                <textarea class="form-textarea" placeholder="Any issues, risks, or blockers..." style="min-height:60px;">Rebar delivery delayed by supplier - ETA Apr 30. Awaiting inspector sign-off for Level 4 slab.</textarea>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:20px;">
                        <div class="card" style="margin-top:35px;">
                            <div class="card-title" style="margin-bottom:14px;">Supporting Documents</div>
                            <div class="upload-zone">
                                <div class="upload-text">Drop files here or browse</div>
                                <div style="font-size:11px; color:var(--muted); margin-top:4px;">Photos, PDFs, inspection reports</div>
                            </div>
                            <div style="margin-top:12px;">
                                <div style="display:flex; align-items:center; gap:8px; padding:8px 0; border-bottom:1px solid var(--border); font-size:12px;">
                                    site_photo_apr28_01.jpg <span style="margin-left:auto; color:var(--muted);">2.1 MB</span>
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
                <div class="page-header">
                    <h1>Group Photo Attendance</h1>
                    <p>Upload one site photo and the system will match every visible face against the worker profiles saved by admin.</p>
                </div>

                <!-- 2-Column Layout: Left (Today's Attendance + Enrolled Workers stacked) | Right (Upload Group Photo) -->
                <div style="display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr); gap: 28px; margin-bottom: 32px; align-items: start;">
                    
                    <!-- LEFT: Today's Attendance + Enrolled Workers (stacked) -->
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <!-- TOP: Today's Attendance Table -->
                        <div>
                            <div class="card" style="margin-bottom: 0;">
                                <div class="card-header" style="margin-bottom: 16px; flex-direction: column; align-items: flex-start; gap: 12px;">
                                    <div style="display: flex; align-items: center; gap: 8px; width: 100%;">
                                        <i class="bi bi-calendar-check" style="color: var(--accent); font-size: 18px;"></i>
                                        <div>
                                            <div class="card-title" style="margin: 0; font-size: 14px;">Today's Attendance</div>
                                            <div style="font-size: 11px; color: var(--muted); margin-top: 2px;"><span id="attendanceDateLabel">May 13, 2026</span></div>
                                        </div>
                                    </div>
                                    <select class="form-select attendance-select" id="attendanceProjectSelect" style="min-width: 160px; font-size: 12px; width: 100%; max-width: 100%;">
                                        <option value="Rizal Residential Complex">Rizal Residential Complex</option>
                                        <option value="San Pablo Commercial Hub">San Pablo Commercial Hub</option>
                                    </select>
                                </div>

                                <!-- Summary Stats -->
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

                                <!-- Attendance Table -->
                                <div style="overflow-x: auto;">
                                    <table class="data-table attendance-table">
                                        <thead>
                                            <tr>
                                                <th>Worker</th>
                                                <th>ID</th>
                                                <th>Role</th>
                                                <th>Time In</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attendanceLogBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- BOTTOM: Enrolled Workers -->
                        <div>
                            <div class="card" style="margin-bottom: 0; display: flex; flex-direction: column; height: 100%;">
                                <div class="card-header" style="margin-bottom: 16px;">
                                    <div class="card-title">
                                        <i class="bi bi-people-fill" style="color: var(--accent); margin-right: 8px;"></i>Enrolled Workers
                                    </div>
                                </div>
                                <div class="worker-roster" id="workerRoster" style="flex: 1; overflow-y: auto; max-height: 600px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Upload Group Photo -->
                    <div>
                        <div class="card" style="margin-bottom: 0;">
                            <div class="card-header" style="margin-bottom: 20px;">
                                <div class="card-title">
                                    <i class="bi bi-camera-fill" style="color: var(--accent); margin-right: 8px;"></i>Upload Group Photo
                                </div>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                <!-- Photo Preview -->
                                <div class="face-stage" style="aspect-ratio: 4/3; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, rgba(34, 197, 94, 0.12) 0%, rgba(34, 197, 94, 0.06) 100%); border: 2px solid rgba(34, 197, 94, 0.2); box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                                    <img id="groupPhotoPreview" alt="Uploaded group photo" style="display:none; width: 100%; height: 100%; object-fit: cover;">
                                    <canvas id="groupPhotoOverlay" style="width: 100%; height: 100%; display: none;"></canvas>
                                    <div class="face-empty" id="groupPhotoEmpty" style="display: flex; align-items: center; justify-content: center; height: 100%; flex-direction: column; text-align: center;">
                                        <i class="bi bi-image" style="font-size: 48px; color: var(--accent); margin-bottom: 12px; opacity: 0.7;"></i>
                                        <div style="font-size: 13px; color: var(--text); font-weight: 500;">Group photo</div>
                                        <div style="font-size: 11px; color: var(--muted); margin-top: 6px;">Portrait or landscape</div>
                                    </div>
                                </div>

                                <!-- File Input -->
                                <div class="form-group" style="margin: 0;">
                                    <label class="form-label" style="margin-bottom: 8px;">
                                        <i class="bi bi-cloud-upload" style="margin-right: 6px;"></i>Select Photo
                                    </label>
                                    <input type="file" class="form-input" id="groupPhotoInput" accept="image/*" style="padding: 10px 12px; border-radius: 8px; cursor: pointer; font-size: 12px;">
                                </div>

                                <!-- Status Message -->
                                <div class="face-status" id="attendanceStatus" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.12) 0%, rgba(34, 197, 94, 0.06) 100%); padding: 11px 13px; border-radius: 8px; border-left: 4px solid var(--accent); font-size: 11px; color: var(--text); line-height: 1.5;">Upload to scan and match faces against enrolled profiles.</div>

                                <!-- Matched Results -->
                                <div id="groupPhotoResults" style="margin: 0; display: none;">
                                    <div style="font-size: 11px; font-weight: 600; margin-bottom: 8px; color: var(--accent); display: flex; align-items: center; gap: 6px;">
                                        <i class="bi bi-check-circle"></i>Matched Workers
                                    </div>
                                    <div id="groupPhotoResultsBody" style="font-size: 10px; color: var(--text); background: linear-gradient(135deg, rgba(34,197,94,0.1) 0%, rgba(16,185,129,0.05) 100%); padding: 11px 13px; border-radius: 8px; max-height: 120px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px;"></div>
                                </div>

                                <!-- Action Buttons -->
                                <div style="display: flex; gap: 10px; justify-content: center;">
                                    <button class="topbar-btn" id="clearGroupBtn" type="button" style="padding: 10px 18px; font-weight: 600; font-size: 12px; min-width: 100px;">
                                        <i class="bi bi-trash" style="margin-right: 4px;"></i>Clear
                                    </button>
                                    <button class="topbar-btn primary" id="processGroupBtn" type="button" style="padding: 10px 18px; font-weight: 600; font-size: 12px; min-width: 100px;">
                                        <i class="bi bi-play-fill" style="margin-right: 4px;"></i>Match Attendance
                                    </button>
                                </div>

                                <div class="face-meta" id="faceMeta" style="padding-top: 12px; border-top: 1px solid var(--border); font-size: 10px; color: var(--muted); text-align: center; line-height: 1.4;">
                                    <i class="bi bi-info-circle" style="margin-right: 3px;"></i>Faces matched against profiles
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
                        <button class="topbar-btn primary" style="margin-top: 20px;" onclick="showToast('Delivery logged successfully!')">Log Delivery</button>
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
    attendance: '',
    materials: '',
};

const timelineProjects = {
    'Rizal Residential Complex': {
        target: 'Aug 2026',
        overallStatus: 'On Track',
        completion: 62,
        phaseBadge: 'Structural Works Phase',
        counts: { completed: 2, progress: 1, upcoming: 2 },
        phases: [
            { name: 'Phase 1 - Site Preparation & Earthworks', dates: 'Jan 15 - Feb 28, 2026 - Completed on time', pct: 100, status: 'Completed', tone: 'done' },
            { name: 'Phase 2 - Foundation Works', dates: 'Mar 1 - Apr 10, 2026 - Completed 3 days early', pct: 100, status: 'Completed', tone: 'done' },
            { name: 'Phase 3 - Structural Works (Current)', dates: 'Apr 11 - Jun 30, 2026 - In progress', pct: 67, status: 'On Track', tone: 'current' },
            { name: 'Phase 4 - MEP Installation', dates: 'Jul 1 - Jul 31, 2026 - Upcoming', pct: 0, status: 'Not Started', tone: 'upcoming' },
            { name: 'Phase 5 - Finishing & Turnover', dates: 'Aug 1 - Aug 31, 2026 - Upcoming', pct: 0, status: 'Not Started', tone: 'upcoming' },
        ],
    },
    'San Pablo Commercial Hub': {
        target: 'Nov 2026',
        overallStatus: 'Delayed',
        completion: 28,
        phaseBadge: 'Foundation Phase',
        counts: { completed: 1, progress: 1, upcoming: 3 },
        phases: [
            { name: 'Phase 1 - Mobilization & Clearing', dates: 'Jan 10 - Feb 2, 2026 - Completed on time', pct: 100, status: 'Completed', tone: 'done' },
            { name: 'Phase 2 - Foundation Works (Current)', dates: 'Feb 3 - Apr 30, 2026 - In progress', pct: 28, status: 'Delayed', tone: 'current' },
            { name: 'Phase 3 - Column & Beam Works', dates: 'May 1 - Jun 30, 2026 - Upcoming', pct: 0, status: 'Not Started', tone: 'upcoming' },
            { name: 'Phase 4 - MEP Installation', dates: 'Jul 1 - Aug 31, 2026 - Upcoming', pct: 0, status: 'Not Started', tone: 'upcoming' },
            { name: 'Phase 5 - Finishing & Turnover', dates: 'Sep 1 - Nov 30, 2026 - Upcoming', pct: 0, status: 'Not Started', tone: 'upcoming' },
        ],
    },
    'Batangas Warehouse Facility': {
        target: 'May 2026',
        overallStatus: 'Ahead',
        completion: 88,
        phaseBadge: 'Finishing Works Phase',
        counts: { completed: 3, progress: 1, upcoming: 1 },
        phases: [
            { name: 'Phase 1 - Site Clearing & Layout', dates: 'Jan 20 - Feb 25, 2026 - Completed', pct: 100, status: 'Completed', tone: 'done' },
            { name: 'Phase 2 - Foundation Works', dates: 'Feb 26 - Mar 20, 2026 - Completed early', pct: 100, status: 'Completed', tone: 'done' },
            { name: 'Phase 3 - Structural Works', dates: 'Mar 21 - Apr 25, 2026 - Completed early', pct: 100, status: 'Completed', tone: 'done' },
            { name: 'Phase 4 - Finishing Works (Current)', dates: 'Apr 26 - May 20, 2026 - In progress', pct: 88, status: 'Ahead', tone: 'current' },
            { name: 'Phase 5 - Turnover', dates: 'May 21 - May 31, 2026 - Upcoming', pct: 0, status: 'Not Started', tone: 'upcoming' },
        ],
    },
    'Lipa City Townhouse Dev.': {
        target: 'Feb 2027',
        overallStatus: 'On Track',
        completion: 45,
        phaseBadge: 'MEP Installation Phase',
        counts: { completed: 2, progress: 1, upcoming: 2 },
        phases: [
            { name: 'Phase 1 - Site Preparation', dates: 'Jan 5 - Feb 10, 2026 - Completed', pct: 100, status: 'Completed', tone: 'done' },
            { name: 'Phase 2 - Foundation Works', dates: 'Feb 11 - Apr 15, 2026 - Completed on time', pct: 100, status: 'Completed', tone: 'done' },
            { name: 'Phase 3 - Structural Works', dates: 'Apr 16 - Jul 10, 2026 - In progress', pct: 45, status: 'On Track', tone: 'current' },
            { name: 'Phase 4 - MEP Installation', dates: 'Jul 11 - Nov 15, 2026 - Upcoming', pct: 0, status: 'Not Started', tone: 'upcoming' },
            { name: 'Phase 5 - Finishing & Turnover', dates: 'Nov 16, 2026 - Feb 28, 2027 - Upcoming', pct: 0, status: 'Not Started', tone: 'upcoming' },
        ],
    },
};

function renderTimelineProject(projectName) {
    const project = timelineProjects[projectName] || timelineProjects['Rizal Residential Complex'];
    const title = document.getElementById('timeline-card-title');
    const target = document.getElementById('timeline-target-label');
    const overallStatus = document.getElementById('timeline-overall-status');
    const completionBadge = document.getElementById('timeline-complete-badge');
    const phaseBadge = document.getElementById('timeline-phase-badge');
    const completedCount = document.getElementById('timeline-completed-count');
    const progressCount = document.getElementById('timeline-progress-count');
    const upcomingCount = document.getElementById('timeline-upcoming-count');
    const list = document.getElementById('timeline-list');

    if (title) title.textContent = `Construction Phases - ${projectName}`;
    if (target) target.textContent = `Target: ${project.target}`;
    if (overallStatus) {
        overallStatus.textContent = project.overallStatus;
        overallStatus.className = 'tag ' + (project.overallStatus === 'On Track' ? 'green' : project.overallStatus === 'Ahead' ? 'blue' : 'red');
    }
    if (completionBadge) completionBadge.textContent = `${project.completion}% Complete`;
    if (phaseBadge) phaseBadge.textContent = project.phaseBadge;
    if (completedCount) completedCount.textContent = `${project.counts.completed} phase${project.counts.completed === 1 ? '' : 's'}`;
    if (progressCount) progressCount.textContent = `${project.counts.progress} phase${project.counts.progress === 1 ? '' : 's'}`;
    if (upcomingCount) upcomingCount.textContent = `${project.counts.upcoming} phase${project.counts.upcoming === 1 ? '' : 's'}`;

    if (list) {
        list.innerHTML = project.phases.map(phase => `
            <div class="timeline-phase">
                <div class="phase-dot ${phase.tone}"></div>
                <div class="phase-info">
                    <div class="phase-name">${phase.name}</div>
                    <div class="phase-dates">${phase.dates}</div>
                </div>
                <div class="phase-right">
                    <div class="phase-pct" style="color:${phase.tone === 'upcoming' ? 'var(--muted)' : 'var(--accent)'};">${phase.pct}%</div>
                    <div class="phase-status">${phase.status}</div>
                </div>
            </div>
        `).join('');
    }
}

function handleTimelineProjectChange(select) {
    const selectedProject = select?.value || 'Rizal Residential Complex';
    renderTimelineProject(selectedProject);
}

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
    if (!clockValue) return '�';
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
                            <div class="worker-roster-meta">${worker.id} | ${worker.role}${worker.photoName ? ` | ${worker.photoName}` : ''}</div>
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
    document.getElementById('groupPhotoResults').style.display = 'none';
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
            document.getElementById('groupPhotoResults').style.display = 'none';
            showToast('No faces detected.');
            return;
        }

        let matchedCount = 0;
        let unknownCount = 0;
        const loggedWorkerIds = new Set();
        const matchedWorkers = [];

        detections.forEach(detection => {
            const match = findBestMatch(Array.from(detection.descriptor));
            if (!match || loggedWorkerIds.has(match.worker.id)) {
                unknownCount += 1;
                return;
            }

            loggedWorkerIds.add(match.worker.id);
            recordAttendance(match.worker, match.score);
            matchedWorkers.push({ ...match.worker, matchScore: match.score });
            matchedCount += 1;
        });

        attendanceState.lastScan = {
            detected: detections.length,
            matched: matchedCount,
            unknown: Math.max(detections.length - matchedCount, 0),
        };

        // Display matched workers in results section
        const resultsDiv = document.getElementById('groupPhotoResults');
        const resultsBody = document.getElementById('groupPhotoResultsBody');
        if (resultsDiv && resultsBody) {
            if (matchedWorkers.length) {
                resultsBody.innerHTML = matchedWorkers.map(w => `
                    <div style="padding:12px; border-radius:10px; background:rgba(245,166,35,0.08); border:1px solid rgba(245,166,35,0.15);">
                        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:4px;">
                            <div style="font-weight:700; font-size:13px; color:var(--text);">${w.name}</div>
                            <div style="font-size:11px; font-weight:700; background:rgba(245,166,35,0.2); padding:4px 6px; border-radius:6px; color:var(--accent);">${(w.matchScore * 100).toFixed(0)}% match</div>
                        </div>
                        <div style="font-size:12px; color:var(--muted); display:flex; gap:8px;">
                            <span>${w.id}</span>
                            <span>�</span>
                            <span>${w.role}</span>
                        </div>
                    </div>`
                ).join('');
                resultsDiv.style.display = 'block';
            } else {
                resultsBody.innerHTML = '<div style="text-align:center; color:var(--muted); font-size:12px; padding:12px;">No workers matched in this upload.</div>';
                resultsDiv.style.display = 'block';
            }
        }

        renderAttendanceModule();
        showAttendanceStatus(`Matched ${matchedCount} of ${detections.length} detected face(s) from the uploaded group photo.`);
        showFaceMeta(`Unknown faces in the scan: ${attendanceState.lastScan.unknown}. Scores above 0.55 are treated as a safe match.`);
        showToast(`Attendance match complete: ${matchedCount} worker(s) identified.`);
    } catch (error) {
        attendanceState.lastScan = { detected: 0, matched: 0, unknown: 0 };
        renderAttendanceModule();
        showAttendanceStatus('Group photo analysis failed. Upload a clearer image and try again.');
        document.getElementById('groupPhotoResults').style.display = 'none';
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
    localStorage.setItem('supervisorCurrentPage', page);
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

document.addEventListener('DOMContentLoaded', () => {
    const savedPage = localStorage.getItem('supervisorCurrentPage') || 'timeline';
    const projectSelect = document.getElementById('timeline-project-select');
    if (projectSelect) {
        renderTimelineProject(projectSelect.value || 'Rizal Residential Complex');
    }
    if (savedPage !== 'timeline') {
        const navItem = document.querySelector(`[onclick="navigate('${savedPage}', this)"]`);
        if (navItem) navigate(savedPage, navItem);
    }
    initAttendanceModule();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWbSxccPQtF3EpF3fnJHog6LaEVF+z4NhkxqHY4xZe3Z8L0L" crossorigin="anonymous"></script>

</body>
</html>





