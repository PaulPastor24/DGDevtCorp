<?php
session_start();
$userRole = 'admin';
$userName = 'Engr. Admin';
$userTitle = 'Project Engineer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard D&G Construction Monitor</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUarbnLLtQbOV5JnXwyIEo56nNmslbdkrMjW03fNvqrviJkur" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="app">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-badge">
                <div class="logo-icon"><img src="images/logo.jpg" alt="D&G"></div>
                <div>
                    <div class="logo-text">D&G Devt Corp</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Overview</div>
            <div class="nav-item active" onclick="navigate('dashboard', this)">
                <i class="bi bi-speedometer2"></i>
                Management Dashboard
            </div>

            <div class="nav-section-label">Monitoring & Progress</div>
            <div class="nav-item" onclick="navigate('timeline', this)">
                <i class="bi bi-calendar-event"></i>
                Project Timeline
            </div>
            <div class="nav-item" onclick="navigate('report', this)">
                <i class="bi bi-file-earmark-bar-graph"></i>
                Progress Report
                <span class="nav-badge">3</span>
            </div>
            <div class="nav-item" onclick="navigate('phase', this)">
                <i class="bi bi-diagram-3"></i>
                Phase Management
            </div>

            <div class="nav-section-label">Materials & Attendance</div>
            <div class="nav-item" onclick="navigate('attendance', this)">
                <i class="bi bi-person-check"></i>
                Worker Attendance
            </div>
            <div class="nav-item" onclick="navigate('materials', this)">
                <i class="bi bi-boxes"></i>
                Materials & Inventory
                <span class="nav-badge red">!</span>
            </div>

        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">EA</div>
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($userName); ?></div>
                </div>
                <div class="logout-icon-btn" onclick="doLogout()">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="topbar-right">
                <span id="liveDate" style="font-size:13px;color:var(--muted);min-width:140px;">Mon, 28 Apr 2026</span>
                <div class="topbar-notif" onclick="navigate('attendance', document.querySelector('[onclick*=attendance]'))" style="cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--accent);">
                    <i class="bi bi-bell-fill" style="font-size: 18px;"></i>
                    <div class="notif-dot"></div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="page active" id="pg-dashboard">
                <div class="page-header">
                    <h1>Management Dashboard</h1>
                    <p>Real-time overview of all active construction projects â€” D&G Dev't Corp.</p>
                </div>

                <div class="stat-grid">
                    <div class="stat-card" style="--accent-color: var(--accent);">
                        <div class="stat-label">Active Projects</div>
                        <div class="stat-value">7</div>
                        <div class="stat-change up">↑ 2 from last quarter</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--green);">
                        <div class="stat-label">On-Track Projects</div>
                        <div class="stat-value">5</div>
                        <div class="stat-change up">↑ 71.4% completion rate</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--blue);">
                        <div class="stat-label">Total Workforce</div>
                        <div class="stat-value">184</div>
                        <div class="stat-change">Across all project sites</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--red);">
                        <div class="stat-label">Pending Reports</div>
                        <div class="stat-value">3</div>
                        <div class="stat-change down">Requires admin review</div>
                    </div>
                </div>

                <div class="col-7-5">
                    <div>
                        <div class="section-header">
                            <div class="section-title">Active Projects</div>
                            <a class="section-link" onclick="navigate('timeline', document.querySelector('[onclick*=timeline]'))">View All</a>
                        </div>
                        <div style="display:grid; gap:14px;">
                            <div class="proj-card" onclick="navigate('timeline', document.querySelector('[onclick*=timeline]'))">
                                <div class="proj-card-top">
                                    <div>
                                        <div class="proj-name">Rizal Residential Complex</div>
                                        <div class="proj-location">Calamba, Laguna</div>
                                    </div>
                                    <div class="status-badge on-track">On Track</div>
                                </div>
                                <div class="proj-phase">Current Phase: <span class="phase-tag">Structural Works</span></div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:62%"></div></div>
                                <div class="proj-meta"><span>62% complete</span><span>Due: Aug 2026</span></div>
                            </div>

                            <div class="proj-card">
                                <div class="proj-card-top">
                                    <div>
                                        <div class="proj-name">San Pablo Commercial Hub</div>
                                        <div class="proj-location">San Pablo City</div>
                                    </div>
                                    <div class="status-badge delayed">Delayed</div>
                                </div>
                                <div class="proj-phase">Current Phase: <span class="phase-tag">Foundation</span></div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill red" style="width:28%"></div></div>
                                <div class="proj-meta"><span>28% complete</span><span>Due: Nov 2026</span></div>
                            </div>

                            <div class="proj-card">
                                <div class="proj-card-top">
                                    <div>
                                        <div class="proj-name">Batangas Warehouse Facility</div>
                                        <div class="proj-location">Batangas City</div>
                                    </div>
                                    <div class="status-badge ahead">Ahead</div>
                                </div>
                                <div class="proj-phase">Current Phase: <span class="phase-tag">Finishing Works</span></div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill blue" style="width:88%"></div></div>
                                <div class="proj-meta"><span>88% complete</span><span>Due: May 2026</span></div>
                            </div>

                            <div class="proj-card">
                                <div class="proj-card-top">
                                    <div>
                                        <div class="proj-name">Lipa City Townhouse Dev.</div>
                                        <div class="proj-location">Lipa City, Batangas</div>
                                    </div>
                                    <div class="status-badge on-track">On Track</div>
                                </div>
                                <div class="proj-phase">Current Phase: <span class="phase-tag">MEP Installation</span></div>
                                <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:45%"></div></div>
                                <div class="proj-meta"><span>45% complete</span><span>Due: Feb 2027</span></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card mb-0" style="margin-bottom:16px;">
                            <div class="card-header">
                                <div class="card-title">Project Burn Rate</div>
                                <div style="font-size:12px;color:var(--muted)">Monthly</div>
                            </div>
                            <div class="mini-chart" style="height:60px; margin-bottom: 8px;">
                                <div class="mini-bar" style="height:40%"></div>
                                <div class="mini-bar" style="height:55%"></div>
                                <div class="mini-bar" style="height:70%"></div>
                                <div class="mini-bar" style="height:60%"></div>
                                <div class="mini-bar active" style="height:85%"></div>
                                <div class="mini-bar" style="height:72%"></div>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:11px; color:var(--muted); margin-bottom: 14px;">
                                <span>Nov</span><span>Dec</span><span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span>
                            </div>
                            <div style="font-family:var(--heading); font-size:22px; font-weight:800; margin-bottom:4px;">₱4.2M</div>
                            <div style="font-size:12px; color:var(--muted);">Total cost this month <span style="color:var(--red)">↑ 12%</span></div>
                        </div>

                        <div class="card mb-0">
                            <div class="card-header">
                                <div class="card-title">Workforce Summary</div>
                                <a class="section-link" onclick="navigate('attendance', document.querySelector('[onclick*=attendance]'))">Details</a>
                            </div>

                            <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                                <div style="flex:1; background: rgba(34,197,94,0.08); border-radius:8px; padding:12px; text-align:center;">
                                    <div style="font-family:var(--heading); font-size:20px; font-weight:800; color:var(--green);">156</div>
                                    <div style="font-size:11px; color:var(--muted);">Present</div>
                                </div>
                                <div style="flex:1; background: rgba(239,68,68,0.08); border-radius:8px; padding:12px; text-align:center;">
                                    <div style="font-family:var(--heading); font-size:20px; font-weight:800; color:var(--red);">18</div>
                                    <div style="font-size:11px; color:var(--muted);">Absent</div>
                                </div>
                                <div style="flex:1; background: rgba(245,166,35,0.08); border-radius:8px; padding:12px; text-align:center;">
                                    <div style="font-family:var(--heading); font-size:20px; font-weight:800; color:var(--yellow);">10</div>
                                    <div style="font-size:11px; color:var(--muted);">Late</div>
                                </div>
                            </div>

                            <div class="progress-bar-wrap">
                                <div class="progress-bar-fill green" style="width:84.8%"></div>
                            </div>
                            <div style="font-size:11px; color:var(--muted); margin-top:4px;">84.8% attendance rate today</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page" id="pg-timeline">
                <div class="page-header">
                    <h1>Project Timeline</h1>
                    <p>Real-time construction phase milestones and progress visualization.</p>
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

                <div class="col-7-5">
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
                                    <div class="phase-pct" style="color:var(--green);">100%</div>
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
                                    <div class="phase-pct" style="color:var(--green);">100%</div>
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

                    <div>
                        <div class="card" style="margin-bottom:16px;">
                            <div class="card-title" style="margin-bottom:14px;">Phase Progress</div>
                            <svg width="100%" height="160" viewBox="0 0 200 160" class="donut">
                                <circle cx="80" cy="80" r="55" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="20"/>
                                <circle cx="80" cy="80" r="55" fill="none" stroke="#22c55e" stroke-width="20"
                                  stroke-dasharray="138 207" stroke-dashoffset="52" stroke-linecap="round"/>
                                <circle cx="80" cy="80" r="55" fill="none" stroke="#f5a623" stroke-width="20"
                                  stroke-dasharray="90 207" stroke-dashoffset="-86" stroke-linecap="round"/>
                                <text x="80" y="75" text-anchor="middle" font-size="18" font-weight="800" fill="#e8eaf0" font-family="Syne,sans-serif">62%</text>
                                <text x="80" y="93" text-anchor="middle" font-size="9" fill="#7a8299">Overall</text>
                                <circle cx="158" cy="45" r="6" fill="#22c55e"/>
                                <text x="168" y="49" font-size="9" fill="#7a8299">Done (2)</text>
                                <circle cx="158" cy="65" r="6" fill="#f5a623"/>
                                <text x="168" y="69" font-size="9" fill="#7a8299">In Progress (1)</text>
                                <circle cx="158" cy="85" r="6" fill="rgba(255,255,255,0.12)"/>
                                <text x="168" y="89" font-size="9" fill="#7a8299">Upcoming (2)</text>
                            </svg>
                        </div>

                        <div class="card mb-0">
                            <div class="card-title" style="margin-bottom:14px;">Milestone Flags</div>
                            <div class="alert-bar warning">
                                <div class="alert-icon">Warning</div>
                                <div class="alert-text">
                                    <strong>Rebar delivery 2 days late</strong>
                                    May impact structural phase end date
                                    <div class="alert-time">Flagged Apr 26</div>
                                </div>
                            </div>
                            <div class="alert-bar info">
                                <div class="alert-icon">Info</div>
                                <div class="alert-text">
                                    <strong>MEP contractor confirmed</strong>
                                    Ready to mobilize Jul 1 as planned
                                    <div class="alert-time">Apr 24</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page" id="pg-report">
                <div class="page-header">
                    <h1>Progress Report Review</h1>
                    <p>Review supervisor-submitted reports, validate evidence, and approve or request revisions.</p>
                </div>

                <div class="stat-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom:20px;">
                    <div class="stat-card" style="--accent-color: var(--yellow);">
                        <div class="stat-label">Awaiting Review</div>
                        <div class="stat-value">5</div>
                        <div class="stat-change">Submitted by supervisors today</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--blue);">
                        <div class="stat-label">In Review</div>
                        <div class="stat-value">2</div>
                        <div class="stat-change">Assigned to admin reviewers</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--green);">
                        <div class="stat-label">Approved</div>
                        <div class="stat-value">12</div>
                        <div class="stat-change up">This week</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--red);">
                        <div class="stat-label">Needs Revision</div>
                        <div class="stat-value">3</div>
                        <div class="stat-change down">Returned to supervisor</div>
                    </div>
                </div>

                <div class="card" style="margin-bottom: 32px;">
                    <div class="card-header">
                        <div class="card-title">Supervisor Submissions Queue</div>
                        <span class="tag yellow">5 Pending</span>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Supervisor</th>
                                <th>Submitted</th>
                                <th>Phase</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-project="Rizal Residential" data-supervisor="R. Santos Construction" data-period="Apr 22 - Apr 28, 2026" data-phase="Phase 3 — Structural Works" data-completion="67" data-description="Completed column forms on Levels 3-5. Poured concrete for Level 4 slab. Rebar installation ongoing for Level 6.">
                                <td><strong>Rizal Residential</strong></td>
                                <td>R. Santos</td>
                                <td style="color:var(--muted);">Apr 28, 08:12 AM</td>
                                <td><span class="phase-tag">Structural Works</span></td>
                                <td><span class="att-badge late">Awaiting Review</span></td>
                                <td><button class="topbar-btn" style="font-size:11px; padding:5px 10px;" onclick="loadReportDetails(this)">Open</button></td>
                            </tr>
                            <tr data-project="San Pablo Hub" data-supervisor="M. Dela Cruz & Team" data-period="Apr 20 - Apr 28, 2026" data-phase="Phase 2 — Foundation" data-completion="54" data-description="Foundation inspection completed. Concrete footings poured for all zones. Waterproofing treatment applied. Awaiting structural approval before moving to next phase.">
                                <td><strong>San Pablo Hub</strong></td>
                                <td>M. Dela Cruz</td>
                                <td style="color:var(--muted);">Apr 28, 07:44 AM</td>
                                <td><span class="phase-tag">Foundation</span></td>
                                <td><span class="att-badge late">Awaiting Review</span></td>
                                <td><button class="topbar-btn" style="font-size:11px; padding:5px 10px;" onclick="loadReportDetails(this)">Open</button></td>
                            </tr>
                            <tr data-project="Batangas Warehouse" data-supervisor="P. Mendoza Builders" data-period="Apr 18 - Apr 27, 2026" data-phase="Phase 4 — Finishing Works" data-completion="82" data-description="Interior wall finishing 85% complete. Electricals and plumbing installation in progress. Paint and fixtures scheduled for next week. Final inspections starting on priority areas.">
                                <td><strong>Batangas Warehouse</strong></td>
                                <td>P. Mendoza</td>
                                <td style="color:var(--muted);">Apr 27, 05:16 PM</td>
                                <td><span class="phase-tag">Finishing Works</span></td>
                                <td><span class="att-badge late">In Review</span></td>
                                <td><button class="topbar-btn" style="font-size:11px; padding:5px 10px;" onclick="loadReportDetails(this)">Open</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="two-col">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Selected Report Details</div>
                            <span class="tag" id="reportProjectTag">Rizal Residential</span>
                        </div>
                        <div style="display:grid; gap:16px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; color:var(--muted);"><span>Supervisor</span><span style="color:var(--text);" id="reportSupervisor">R. Santos Construction</span></div>
                            <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; color:var(--muted);"><span>Report Period</span><span style="color:var(--text);" id="reportPeriod">Apr 22 - Apr 28, 2026</span></div>
                            <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; color:var(--muted);"><span>Current Phase</span><span style="color:var(--text);" id="reportPhase">Phase 3 — Structural Works</span></div>
                            <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; color:var(--muted);"><span>Completion</span><span style="color:var(--accent); font-weight:700%;" id="reportCompletion">67%</span></div>
                            <div style="padding:14px; min-height:120px; margin-top:2px; border:1px solid var(--border); border-radius:10px; background:rgba(0,0,0,0.01); font-size:12px; line-height:1.6; cursor:default; user-select:none;" id="reportDescription">
                                Completed column forms on Levels 3-5. Poured concrete for Level 4 slab. Rebar installation ongoing for Level 6.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-title" style="margin-bottom:14px;">Evidence & Review Decision</div>
                        <div style="display:grid; gap:8px; margin-bottom:14px;">
                            <div style="display:flex; align-items:center; gap:8px; padding:8px 0; border-bottom:1px solid var(--border); font-size:12px;"><span>📷</span> site_photo_apr28_01.jpg <span style="margin-left:auto; color:var(--muted);">2.1 MB</span></div>
                            <div style="display:flex; align-items:center; gap:8px; padding:8px 0; border-bottom:1px solid var(--border); font-size:12px;"><span>📷</span> level4_slab_progress.jpg <span style="margin-left:auto; color:var(--muted);">1.7 MB</span></div>
                            <div style="display:flex; align-items:center; gap:8px; padding:8px 0; font-size:12px;"><span>📄</span> inspection_form_level4.pdf <span style="margin-left:auto; color:var(--muted);">0.8 MB</span></div>
                        </div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label class="form-label">Reviewer Notes</label>
                            <textarea class="form-textarea" style="min-height:80px;" placeholder="Add findings, required revisions, or approval notes..."></textarea>
                        </div>
                        <div style="display:flex; justify-content:flex-end; gap:10px;">
                            <button class="topbar-btn" onclick="showToast('Revision request sent to supervisor')">Request Revision</button>
                            <button class="topbar-btn primary" onclick="showToast('Report approved and forwarded to phase management')">Approve Report</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page" id="pg-phase">
                <div class="page-header">
                    <h1>Admin Phase Management</h1>
                    <p>Review contractor reports and assign/approve construction phases.</p>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pending Contractor Reports</div>
                        <span class="tag yellow">3 Awaiting Review</span>
                    </div>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Contractor</th>
                                <th>Period</th>
                                <th>Est. Completion</th>
                                <th>Phase Recommendation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Rizal Residential</strong></td>
                                <td>R. Santos Construction</td>
                                <td style="color:var(--muted);">Apr 21, 2026</td>
                                <td><strong>67%</strong></td>
                                <td><span class="phase-tag">Structural Works</span></td>
                                <td>
                                    <button class="topbar-btn" style="font-size:11px; padding:5px 10px; color:var(--green); border-color:rgba(34,197,94,0.3); margin-right:4px;" onclick="showToast('Phase approved and logged!')">✓ Approve</button>
                                    <button class="topbar-btn" style="font-size:11px; padding:5px 10px;">Revise</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>San Pablo Hub</strong></td>
                                <td>Metro Builders Inc.</td>
                                <td style="color:var(--muted);">Apr 18, 2026</td>
                                <td><strong>28%</strong></td>
                                <td><span class="phase-tag">Foundation</span></td>
                                <td>
                                    <button class="topbar-btn" style="font-size:11px; padding:5px 10px; color:var(--green); border-color:rgba(34,197,94,0.3); margin-right:4px;" onclick="showToast('Phase approved and logged!')">✓ Approve</button>
                                    <button class="topbar-btn" style="font-size:11px; padding:5px 10px;">Revise</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Batangas Warehouse</strong></td>
                                <td>Southern Build Corp.</td>
                                <td style="color:var(--muted);">Apr 26, 2026</td>
                                <td><strong>88%</strong></td>
                                <td><span class="phase-tag">Finishing Works</span></td>
                                <td>
                                    <button class="topbar-btn" style="font-size:11px; padding:5px 10px; color:var(--green); border-color:rgba(34,197,94,0.3); margin-right:4px;" onclick="showToast('Phase approved and logged!')">✓ Approve</button>
                                    <button class="topbar-btn" style="font-size:11px; padding:5px 10px;">Revise</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card mb-0">
                    <div class="card-title" style="margin-bottom:14px;">Audit Log — Recent Phase Assignments</div>
                    <table class="data-table">
                        <thead>
                            <tr><th>Timestamp</th><th>Project</th><th>Action</th><th>Assigned By</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="color:var(--muted); font-size:11px;">Apr 25, 2026 · 14:32</td>
                                <td>Lipa Townhouse</td>
                                <td><span class="tag green">Phase Approved to MEP Installation</span></td>
                                <td>Engr. Admin</td>
                            </tr>
                            <tr>
                                <td style="color:var(--muted); font-size:11px;">Apr 22, 2026 · 09:15</td>
                                <td>Batangas Warehouse</td>
                                <td><span class="tag yellow">Phase Revision Requested</span></td>
                                <td>Engr. Admin</td>
                            </tr>
                            <tr>
                                <td style="color:var(--muted); font-size:11px;">Apr 19, 2026 · 16:50</td>
                                <td>Rizal Complex</td>
                                <td><span class="tag green">Phase Approved to Structural Works</span></td>
                                <td>Engr. Admin</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="page" id="pg-attendance">
                <div class="page-header">
                    <h1>Worker Face Profiles</h1>
                    <p>Upload one reference photo per worker so the supervisor can match a group photo against saved FaceNet descriptors.</p>
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
                                    <div class="attendance-stat-label">Present</div>
                                    <div class="attendance-stat-value" id="attendancePresentCount">0</div>
                                    <div class="attendance-stat-hint">Verified today</div>
                                </div>
                                <div class="attendance-stat">
                                    <div class="attendance-stat-label">Awaiting scan</div>
                                    <div class="attendance-stat-value" id="attendancePendingCount">0</div>
                                    <div class="attendance-stat-hint">No time-in yet</div>
                                </div>
                                <div class="attendance-stat">
                                    <div class="attendance-stat-label">Enrolled faces</div>
                                    <div class="attendance-stat-value" id="attendanceEnrolledCount">0</div>
                                    <div class="attendance-stat-hint">Stored locally</div>
                                </div>
                            </div>

                            <table class="data-table attendance-table">
                                <thead>
                                    <tr><th>Worker</th><th>ID</th><th>Role</th><th>Time In</th><th>Status</th></tr>
                                </thead>
                                <tbody id="attendanceLogBody"></tbody>
                            </table>
                        </div>

                        <div class="card mb-0">
                            <div class="card-title" style="margin-bottom:10px;">Enrolled Workers</div>
                            <div class="worker-roster" id="workerRoster"></div>
                        </div>

                        <div class="card mb-0">
                            <div class="card-header">
                                <div class="card-title">Recent Attendance</div>
                                <div class="attendance-filter">
                                    <button class="topbar-btn icon-btn" type="button" id="recentAttendanceFilterBtn" title="Filter"><i class="bi bi-funnel"></i></button>
                                    <button class="topbar-btn icon-btn" type="button" id="recentAttendanceClearBtn" title="Clear"><i class="bi bi-x-circle"></i></button>
                                    <input type="date" id="recentAttendanceDate" class="attendance-date-input">
                                </div>
                            </div>
                            <table class="data-table recent-attendance-table">
                                <thead>
                                    <tr><th>Time</th><th>Worker</th><th>ID</th><th>Role</th><th>Status</th></tr>
                                </thead>
                                <tbody id="recentAttendanceList"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="enrollment-section">
                        <div class="card">
                            <div class="card-title" style="margin-bottom:16px;">Worker Profile Enrollment</div>
                            <div class="face-panel enrollment-panel">
                                <div class="enrollment-photo-wrapper">
                                    <div class="face-stage enrollment-photo-area" id="workerPhotoStage">
                                        <img id="workerPhotoPreview" alt="Worker reference preview" style="display:none;">
                                        <div class="face-empty" id="workerPhotoEmpty">
                                            <div style="text-align: center;">
                                                <i class="bi bi-cloud-arrow-up" style="font-size: 32px; color: var(--accent); margin-bottom: 8px; display: block;"></i>
                                                Upload a clear worker portrait
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="face-info">
                                    <div class="form-grid" style="gap:12px; margin-bottom:12px;">
                                        <div class="form-group">
                                            <label class="form-label">Worker Name</label>
                                            <input type="text" class="form-input" id="workerNameInput" placeholder="e.g., Juan Santos">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Worker ID</label>
                                            <input type="text" class="form-input" id="workerIdInput" placeholder="e.g., W-0042">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Position / Role</label>
                                            <input type="text" class="form-input" id="workerRoleInput" placeholder="e.g., Carpenter, Mason">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Reference Photo</label>
                                        <label class="btn-choose-photo" for="workerPhotoInput">
                                            <i class="bi bi-image"></i>
                                            Choose Photo
                                        </label>
                                        <input type="file" id="workerPhotoInput" accept="image/*" class="file-input-hidden">
                                    </div>
                                    <div class="face-status" id="attendanceStatus">Load FaceNet models, then upload one clear reference photo for each worker profile.</div>
                                    <div class="face-actions">
                                        <div class="btn-group-left">
                                            <button class="btn btn-secondary" id="resetWorkerBtn" type="button"><i class="bi bi-arrow-counterclockwise"></i> Clear Form</button>
                                        </div>
                                        <div class="btn-group-right">
                                            <button class="btn btn-primary" id="saveWorkerBtn" type="button"><i class="bi bi-check-circle"></i> Save Profile</button>
                                        </div>
                                    </div>
                                    <div class="face-meta" id="faceMeta">Profiles are stored locally and reused by the supervisor group-photo scan.</div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-title" style="margin-bottom:16px;">Group Photo Attendance Scan</div>
                            <div class="face-panel group-photo-panel">
                                <div class="group-photo-wrapper">
                                    <div class="face-stage group-photo-area" id="groupPhotoStage">
                                        <img id="groupPhotoPreview" alt="Group photo preview" style="display:none;">
                                        <div class="face-empty" id="groupPhotoEmpty">Upload a group photo to match against enrolled worker profiles.</div>
                                    </div>
                                </div>
                                <div class="face-info">
                                    <div class="form-group">
                                        <label class="form-label">Group Photo</label>
                                        <label class="btn-choose-photo" for="groupPhotoInput">
                                            <i class="bi bi-images"></i>
                                            Choose Group Photo
                                        </label>
                                        <input type="file" id="groupPhotoInput" accept="image/*" class="file-input-hidden">
                                    </div>
                                    <div class="face-status" id="groupPhotoStatus">Upload a group photo containing multiple workers to scan and record attendance.</div>
                                    <div class="face-actions">
                                        <div class="btn-group-left">
                                            <button class="btn btn-secondary" id="resetGroupPhotoBtn" type="button"><i class="bi bi-trash"></i> Clear Photo</button>
                                        </div>
                                        <div class="btn-group-right">
                                            <button class="btn btn-primary" id="runGroupPhotoBtn" type="button"><i class="bi bi-play-circle"></i> Run Attendance Match</button>
                                        </div>
                                    </div>
                                    <div id="groupPhotoResults" style="margin-top:14px; display:none;">
                                        <div style="font-size:12px; font-weight:600; margin-bottom:8px; color:var(--accent);">Matched Workers</div>
                                        <div id="groupPhotoResultsBody" style="font-size:11px; color:var(--muted);"></div>
                                    </div>
                                    <div class="face-meta" id="groupPhotoMeta">Detected faces will be matched and attendance logged to the database.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page" id="pg-materials">
                <div class="page-header">
                    <h1>Materials & Inventory</h1>
                    <p>Track material deliveries, usage, logistics, and low-stock alerts.</p>
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
                        <div class="stat-label">Total Inventory Value</div>
                        <div id="total-inventory-value" class="stat-value">₱4.93M</div>
                        <div class="stat-change up">Overall</div>
                        <div class="stat-icon">Inventory</div>
                    </div>
                </div>

                <div class="two-col" style="align-items:start;">
                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="card-title">Inventory Status — 
                                <select id="inventory-location" class="location-select" onchange="handleInventoryLocationChange(this)">
                                    <option value="Overall" selected>Overall</option>
                                    <option value="Rizal Residential">Rizal Residential</option>
                                    <option value="San Pablo Commercial Hub">San Pablo Commercial Hub</option>
                                    <option value="Batangas Warehouse Facility">Batangas Warehouse Facility</option>
                                    <option value="Lipa City Townhouse Dev.">Lipa City Townhouse Dev.</option>
                                </select>
                            </div>
                        </div>

                        <div id="inventory-list">
                            <div class="mat-item">
                                <div class="mat-icon">🪨</div>
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
                                <div class="mat-icon">🔩</div>
                                <div class="mat-info">
                                    <div class="mat-name">Rebar (16mm) <span class="alert-flag">Low stock</span></div>
                                    <div class="mat-detail">Delivered: 12 tons · Used: 10.8 tons</div>
                                </div>
                                <div class="mat-bar-wrap">
                                    <div class="mat-pct" style="color:var(--red);">10% left</div>
                                    <div class="progress-bar-wrap"><div class="progress-bar-fill red" style="width:10%"></div></div>
                                </div>
                            </div>

                            <div class="mat-item">
                                <div class="mat-icon">🪵</div>
                                <div class="mat-info">
                                    <div class="mat-name">Lumber (Formwork) <span class="alert-flag">Low stock</span></div>
                                    <div class="mat-detail">Delivered: 800 pcs · Used: 760 pcs</div>
                                </div>
                                <div class="mat-bar-wrap">
                                    <div class="mat-pct" style="color:var(--yellow);">5% left</div>
                                    <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:5%; background:var(--red);"></div></div>
                                </div>
                            </div>

                            <div class="mat-item">
                                <div class="mat-icon">🪣</div>
                                <div class="mat-info">
                                    <div class="mat-name">Portland Cement (40kg)</div>
                                    <div class="mat-detail">Delivered: 1,200 bags · Used: 680 bags</div>
                                </div>
                                <div class="mat-bar-wrap">
                                    <div class="mat-pct">43% remaining</div>
                                    <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:43%"></div></div>
                                </div>
                            </div>

                            <div class="mat-item">
                                <div class="mat-icon">🏖️</div>
                                <div class="mat-info">
                                    <div class="mat-name">Sand & Gravel</div>
                                    <div class="mat-detail">Delivered: 200 m³ · Used: 120 m³</div>
                                </div>
                                <div class="mat-bar-wrap">
                                    <div class="mat-pct">40% remaining</div>
                                    <div class="progress-bar-wrap"><div class="progress-bar-fill blue" style="width:40%"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card">
                            <div class="card-title" style="margin-bottom:14px;">Log Material Delivery</div>
                            <div class="form-grid">
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

                        <div class="card mb-0">
                            <div class="card-title" style="margin-bottom:14px;">Hauling & Logistics</div>
                            <table class="data-table">
                                <thead>
                                    <tr><th>Trip</th><th>Material</th><th>Truck</th><th>Status</th></tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-size:11px; color:var(--muted);">T-204</td>
                                        <td>Rebar delivery</td>
                                        <td style="font-size:11px;">ABC-234</td>
                                        <td><span class="tag yellow">In Transit</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:11px; color:var(--muted);">T-203</td>
                                        <td>Cement (200 bags)</td>
                                        <td style="font-size:11px;">XYZ-891</td>
                                        <td><span class="tag green">Delivered</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page" id="pg-alerts">
                <div class="page-header">
                    <h1>Alerts & Notifications</h1>
                    <p>System-generated flags for materials, schedules, and attendance anomalies.</p>
                </div>

                <div class="two-col" style="align-items:start;">
                    <div>
                        <div class="section-header"><div class="section-title">Critical Alerts</div></div>

                        <div class="alert-bar danger">
                            <div class="alert-icon">Danger</div>
                            <div class="alert-text">
                                <strong>CRITICAL — Rebar stock below threshold</strong>
                                Rizal Residential: Only 10% of rebar remaining. Next pour scheduled Apr 30.
                                <div class="alert-time">Apr 28, 2026 · 06:00 AM · Auto-generated</div>
                            </div>
                        </div>

                        <div class="alert-bar danger">
                            <div class="alert-icon">Danger</div>
                            <div class="alert-text">
                                <strong>CRITICAL — Lumber (Formwork) below threshold</strong>
                                Rizal Residential: Only 5% left. Reorder required immediately.
                                <div class="alert-time">Apr 27, 2026 · Auto-generated</div>
                            </div>
                        </div>

                        <div class="alert-bar warning">
                            <div class="alert-icon">Warning</div>
                            <div class="alert-text">
                                <strong>Milestone deviation flagged</strong>
                                San Pablo Hub: Foundation phase now 6 days behind planned schedule.
                                <div class="alert-time">Apr 26, 2026 · 08:30 AM</div>
                            </div>
                        </div>

                        <div class="alert-bar warning">
                            <div class="alert-icon">Warning</div>
                            <div class="alert-text">
                                <strong>3 unreviewed progress reports</strong>
                                Pending admin phase assignment for Rizal, San Pablo, Batangas projects.
                                <div class="alert-time">Apr 25, 2026</div>
                            </div>
                        </div>

                        <div class="alert-bar info">
                            <div class="alert-icon">Info</div>
                            <div class="alert-text">
                                <strong>Batangas Warehouse: 88% complete</strong>
                                Project ahead of schedule. Projected handover May 20, 2026.
                                <div class="alert-time">Apr 24, 2026</div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-title" style="margin-bottom:14px;">Alert Summary</div>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px; background:rgba(239,68,68,0.07); border-radius:8px;">
                                <span style="font-size:13px;">Critical</span>
                                <span style="font-family:var(--heading); font-size:20px; font-weight:800; color:var(--red);">2</span>
                            </div>
                            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px; background:rgba(245,166,35,0.07); border-radius:8px;">
                                <span style="font-size:13px;">Warning</span>
                                <span style="font-family:var(--heading); font-size:20px; font-weight:800; color:var(--yellow);">2</span>
                            </div>
                            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px; background:rgba(59,130,246,0.07); border-radius:8px;">
                                <span style="font-size:13px;">Info</span>
                                <span style="font-family:var(--heading); font-size:20px; font-weight:800; color:var(--blue);">1</span>
                            </div>
                        </div>

                        <div style="margin-top:20px;">
                            <div class="card-title" style="margin-bottom:12px; font-size:13px;">Notification Settings</div>
                            <div style="display:flex; flex-direction:column; gap:10px;">
                                <label style="display:flex; align-items:center; gap:10px; font-size:13px; cursor:pointer;">
                                    <input type="checkbox" checked style="accent-color:var(--accent);"> Low stock alerts (email)
                                </label>
                                <label style="display:flex; align-items:center; gap:10px; font-size:13px; cursor:pointer;">
                                    <input type="checkbox" checked style="accent-color:var(--accent);"> Milestone deviation flags
                                </label>
                                <label style="display:flex; align-items:center; gap:10px; font-size:13px; cursor:pointer;">
                                    <input type="checkbox" checked style="accent-color:var(--accent);"> Pending report reminders
                                </label>
                                <label style="display:flex; align-items:center; gap:10px; font-size:13px; cursor:pointer;">
                                    <input type="checkbox" style="accent-color:var(--accent);"> Daily attendance summary
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toast">Action completed</div>

<script>
let currentPage = 'dashboard';

const pageTitles = {
    dashboard: 'Management Dashboard',
    timeline: 'Project Timeline',
    report: 'Progress Report Submission',
    phase: 'Admin Phase Management',
    attendance: 'Worker Face Profiles',
    materials: 'Materials & Inventory',
    alerts: 'Alerts & Notifications',
};

const primaryActions = {
    dashboard: '+ New Project',
    timeline: '+ Add Phase',
    report: '+ New Report',
    phase: '',
    attendance: '+ Register Worker',
    materials: '+ Log Delivery',
    alerts: 'Mark All Read',
};

const FACE_MODELS_URL = 'https://justadudewhohacks.github.io/face-api.js/models';
const FACE_STORAGE_KEYS = {
    workers: 'dg-face-workers-v1',
    logs: 'dg-face-logs-v1',
};

const DEFAULT_WORKERS = [
    { id: 'W-0024', name: 'Roberto Dizon', role: 'Mason', project: 'San Pablo Commercial Hub', descriptor: null, photoName: '' },
    { id: 'W-0037', name: 'Bong Pascual', role: 'Electrician', project: 'San Pablo Commercial Hub', descriptor: null, photoName: '' },
];

const attendanceState = {
    initialized: false,
    modelsReady: false,
    workers: [],
    logs: [],
    currentProject: 'Rizal Residential Complex',
    recentAttendanceDate: '',
    loadingModels: null,
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

function dedupeWorkersById(workers) {
    const map = new Map();
    for (const w of (workers || [])) {
        if (!w || !w.id) continue;
        if (!map.has(w.id)) map.set(w.id, w);
    }
    return Array.from(map.values());
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

        const localWorkers = readJson(FACE_STORAGE_KEYS.workers, []);
        const filteredWorkers = localWorkers.filter(w => w.project !== 'Rizal Residential Complex');
        const merged = [...attendanceState.workers, ...filteredWorkers];
        const deduped = dedupeWorkersById(merged);
        attendanceState.workers = deduped;
        writeJson(FACE_STORAGE_KEYS.workers, deduped);

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
        writeJson(FACE_STORAGE_KEYS.logs, []);
    }
}

function navigate(page, el) {
    currentPage = page;
    localStorage.setItem('dg-admin-current-page', page);
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
        registerWorker();
        return;
    }

    alert('Feature coming soon!');
}

function doLogout() {
    if (confirm('Are you sure you want to sign out?')) {
        window.location.href = 'logout.php';
    }
}

function handleInventoryLocationChange(sel) {
    const totalEl = document.getElementById('total-inventory-value');
    if (!sel || !totalEl) return;

    const totalsByLocation = {
        'Overall': '₱4.93M',
        'Rizal Residential': '₱1.62M',
        'San Pablo Commercial Hub': '₱1.28M',
        'Batangas Warehouse Facility': '₱1.10M',
        'Lipa City Townhouse Dev.': '₱0.93M',
    };

    totalEl.textContent = totalsByLocation[sel.value] || totalsByLocation.Overall;
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

function attachFilePickerScrollFix(fileInputId) {
    const fileInput = document.getElementById(fileInputId);
    if (!fileInput) return;

    fileInput.addEventListener('click', (e) => {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const scrollLeft = window.scrollX || document.documentElement.scrollLeft;
        
        setTimeout(() => {
            window.scrollTo(scrollLeft, scrollTop);
        }, 0);
    });
}

function loadReportDetails(button) {
    const row = button.closest('tr');
    if (!row) return;

    const project = row.dataset.project;
    const supervisor = row.dataset.supervisor;
    const period = row.dataset.period;
    const phase = row.dataset.phase;
    const completion = row.dataset.completion;
    const description = row.dataset.description;

    document.getElementById('reportProjectTag').textContent = project;
    document.getElementById('reportSupervisor').textContent = supervisor;
    document.getElementById('reportPeriod').textContent = period;
    document.getElementById('reportPhase').textContent = phase;
    document.getElementById('reportCompletion').textContent = completion + '%';
    document.getElementById('reportDescription').textContent = description;

    showToast('Report loaded for review');
}

function formatAttendanceDate(dateKey) {
    if (!dateKey) return '';
    const [year, month, day] = String(dateKey).split('-').map(Number);
    if (!year || !month || !day) return dateKey;
    const date = new Date(year, month - 1, day);
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function renderRecentAttendanceLogs() {
    const list = document.getElementById('recentAttendanceList');
    if (!list) return;

    const currentProject = attendanceState.currentProject;
    const selectedDate = attendanceState.recentAttendanceDate;
    const logs = attendanceState.logs
        .filter(log => log.project === currentProject)
        .filter(log => !selectedDate || log.dateKey === selectedDate)
        .slice()
        .sort((a, b) => {
            if (a.dateKey === b.dateKey) return String(b.timeIn).localeCompare(String(a.timeIn));
            return String(b.dateKey).localeCompare(String(a.dateKey));
        })
        .slice(0, 6);

    if (!logs.length) {
        list.innerHTML = '<div class="worker-roster-empty">No attendance logs found for the selected date.</div>';
        return;
    }

    list.innerHTML = logs.map(log => `
        <tr>
            <td style="color:var(--muted); font-size:12px;">
                <div style="font-weight:600;">${formatClock(log.timeIn)}</div>
                <div style="font-size:11px;">${formatAttendanceDate(log.dateKey)}</div>
            </td>
            <td style="font-weight:500;">${log.workerName}</td>
            <td style="color:var(--muted); font-size:12px;">${log.workerId}</td>
            <td style="color:var(--muted); font-size:12px;">${log.workerRole}</td>
            <td><span class="att-badge ${String(log.status || '').toLowerCase()}">${log.status === 'Present' ? '✓ Present' : log.status}</span></td>
        </tr>
    `).join('');
}

async function applyRecentAttendanceFilter() {
    const input = document.getElementById('recentAttendanceDate');
    attendanceState.recentAttendanceDate = input?.value || '';

    try {
        await bootstrapAttendanceData();
    } catch (error) {
        console.error('Failed to refresh attendance logs:', error);
    }

    renderAttendanceModule();
}

function clearRecentAttendanceFilter() {
    attendanceState.recentAttendanceDate = '';
    const input = document.getElementById('recentAttendanceDate');
    if (input) input.value = '';
    renderAttendanceModule();
}

function persistWorkers() {
    const deduped = dedupeWorkersById(attendanceState.workers);
    attendanceState.workers = deduped;
    writeJson(FACE_STORAGE_KEYS.workers, deduped);
}

function persistLogs() {
    writeJson(FACE_STORAGE_KEYS.logs, attendanceState.logs);
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
            renderAttendanceModule();
        });
    }

    document.getElementById('workerPhotoInput')?.addEventListener('change', function() {
        updateWorkerPhotoPreview(this.files?.[0]).catch(() => {
            showAttendanceStatus('Unable to preview the selected photo.');
        });
    });
    attachFilePickerScrollFix('workerPhotoInput');
    document.getElementById('saveWorkerBtn')?.addEventListener('click', registerWorker);
    document.getElementById('resetWorkerBtn')?.addEventListener('click', resetWorkerForm);

    document.getElementById('recentAttendanceFilterBtn')?.addEventListener('click', applyRecentAttendanceFilter);
    document.getElementById('recentAttendanceClearBtn')?.addEventListener('click', clearRecentAttendanceFilter);
    document.getElementById('recentAttendanceDate')?.addEventListener('change', applyRecentAttendanceFilter);

    document.getElementById('groupPhotoInput')?.addEventListener('change', function() {
        updateGroupPhotoPreview(this.files?.[0]).catch(() => {
            document.getElementById('groupPhotoStatus').textContent = 'Unable to preview the selected photo.';
        });
    });
    attachFilePickerScrollFix('groupPhotoInput');
    document.getElementById('runGroupPhotoBtn')?.addEventListener('click', processGroupPhoto);
    document.getElementById('resetGroupPhotoBtn')?.addEventListener('click', resetGroupPhotoForm);

    attendanceState.initialized = true;
    renderAttendanceModule();
}

function renderAttendanceModule() {
    const todayKey = new Date().toISOString().slice(0, 10);
    const currentProject = document.getElementById('attendanceProjectSelect')?.value || attendanceState.currentProject;
    attendanceState.currentProject = currentProject;

    const workers = attendanceState.workers.filter(worker => worker.project === currentProject);
    const logs = attendanceState.logs.filter(log => log.project === currentProject && log.dateKey === todayKey);
    const enrolledCount = attendanceState.workers.filter(worker => Array.isArray(worker.descriptor) && worker.descriptor.length).length;
    const presentCount = logs.filter(log => log.status !== 'Absent').length;
    const pendingCount = Math.max(workers.length - presentCount, 0);

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
            : '<div class="worker-roster-empty">No workers registered for this site yet.</div>';
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

    const presentEl = document.getElementById('attendancePresentCount');
    if (presentEl) presentEl.textContent = String(presentCount);
    const pendingEl = document.getElementById('attendancePendingCount');
    if (pendingEl) pendingEl.textContent = String(pendingCount);
    const enrolledEl = document.getElementById('attendanceEnrolledCount');
    if (enrolledEl) enrolledEl.textContent = String(enrolledCount);
    const dateLabel = document.getElementById('attendanceDateLabel');
    if (dateLabel) dateLabel.textContent = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

    const recentDateInput = document.getElementById('recentAttendanceDate');
    if (recentDateInput && !recentDateInput.value && attendanceState.recentAttendanceDate) {
        recentDateInput.value = attendanceState.recentAttendanceDate;
    }

    renderRecentAttendanceLogs();
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
        showAttendanceStatus('FaceNet ready. Upload a worker portrait to save a reference profile.');
        showFaceMeta('Models loaded successfully. Each saved profile becomes the reference for group-photo attendance.');
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

async function updateWorkerPhotoPreview(file) {
    const preview = document.getElementById('workerPhotoPreview');
    const empty = document.getElementById('workerPhotoEmpty');

    if (!preview || !empty) return;

    if (!file) {
        preview.removeAttribute('src');
        preview.style.display = 'none';
        empty.style.display = 'flex';
        return;
    }

    const dataUrl = await readFileAsDataUrl(file);
    preview.src = dataUrl;
    preview.style.display = 'block';
    empty.style.display = 'none';
}

function resetWorkerForm() {
    const nameInput = document.getElementById('workerNameInput');
    const idInput = document.getElementById('workerIdInput');
    const roleInput = document.getElementById('workerRoleInput');
    const photoInput = document.getElementById('workerPhotoInput');

    if (nameInput) nameInput.value = '';
    if (idInput) idInput.value = '';
    if (roleInput) roleInput.value = '';
    if (photoInput) photoInput.value = '';

    updateWorkerPhotoPreview(null);
    showAttendanceStatus('Upload one clear reference photo for the next worker profile.');
    showFaceMeta('Profiles are matched later against the supervisor group photo.');
}

async function extractDescriptorFromFile(file) {
    await loadFaceModels();
    const dataUrl = await readFileAsDataUrl(file);
    const image = await loadImageFromDataUrl(dataUrl);
    const detection = await faceapi
        .detectSingleFace(image, new faceapi.TinyFaceDetectorOptions({ inputSize: 320, scoreThreshold: 0.45 }))
        .withFaceLandmarks()
        .withFaceDescriptor();

    return { detection, dataUrl };
}

async function registerWorker() {
    const name = document.getElementById('workerNameInput')?.value.trim();
    const id = document.getElementById('workerIdInput')?.value.trim();
    const role = document.getElementById('workerRoleInput')?.value.trim();
    const photoInput = document.getElementById('workerPhotoInput');
    const photoFile = photoInput?.files?.[0] || null;
    const project = attendanceState.currentProject;

    if (!name || !id || !role) {
        showToast('Enter the worker name, ID, and role before saving.');
        return;
    }

    if (!photoFile) {
        showToast('Upload a reference photo for the worker profile.');
        return;
    }

    try {
        showAttendanceStatus('Reading the uploaded worker portrait...');
        const { detection } = await extractDescriptorFromFile(photoFile);

        if (!detection) {
            showAttendanceStatus('No face was detected in that upload. Use a clearer portrait with one visible face.');
            return;
        }

        const descriptor = Array.from(detection.descriptor);
        const existingIndex = attendanceState.workers.findIndex(worker => worker.id === id);
        let workerRecord;

        if (existingIndex >= 0) {
            const existing = attendanceState.workers[existingIndex];
            let refs = [];
            if (existing.descriptor && Array.isArray(existing.descriptor)) {
                if (Array.isArray(existing.descriptor[0])) refs = existing.descriptor.slice();
                else refs = [existing.descriptor];
            }

            let isDuplicate = false;
            for (const r of refs) {
                const d = Math.sqrt(r.reduce((sum, val, idx) => sum + Math.pow(val - descriptor[idx], 2), 0));
                if (d <= 0.5) { 
                    isDuplicate = true;
                    break;
                }
            }

            if (!isDuplicate) refs.push(descriptor);

            workerRecord = { id, name, role, project, descriptor: refs, photoName: photoFile.name };
            attendanceState.workers[existingIndex] = workerRecord;
        } else {
            workerRecord = { id, name, role, project, descriptor, photoName: photoFile.name };
            attendanceState.workers.push(workerRecord);
        }

        persistWorkers();
        console.log('Saving worker to API:', workerRecord);
        const apiResponse = await sendAttendanceApi('save-worker', { worker: workerRecord });
        
        if (!apiResponse.success) {
            showAttendanceStatus('Failed to save to database: ' + (apiResponse.message || 'Unknown error'));
            showToast('Database save failed: ' + (apiResponse.message || 'Unknown error'));
            return;
        }
        
        renderAttendanceModule();
        resetWorkerForm();
        showAttendanceStatus(`${name} is enrolled for ${project}.`);
        showFaceMeta('FaceNet descriptor stored in MySQL and ready for the supervisor group-photo scan.');
        showToast(`Profile saved for ${name}.`);
    } catch (error) {
        console.error('Worker registration error:', error);
        showAttendanceStatus('Enrollment failed: ' + (error.message || 'Unknown error'));
        showToast('Enrollment failed: ' + (error.message || 'Unknown error'));
    }
}

async function updateGroupPhotoPreview(file) {
    const preview = document.getElementById('groupPhotoPreview');
    const empty = document.getElementById('groupPhotoEmpty');
    const statusEl = document.getElementById('groupPhotoStatus');

    if (!preview || !empty) return;

    if (!file) {
        preview.removeAttribute('src');
        preview.style.display = 'none';
        empty.style.display = 'flex';
        if (statusEl) statusEl.textContent = 'Upload a group photo containing multiple workers to scan and record attendance.';
        return;
    }

    const dataUrl = await readFileAsDataUrl(file);
    preview.src = dataUrl;
    preview.style.display = 'block';
    empty.style.display = 'none';
    if (statusEl) statusEl.textContent = 'Photo loaded. Click "Run Attendance Match" to detect and match faces.';
}

function resetGroupPhotoForm() {
    const photoInput = document.getElementById('groupPhotoInput');
    if (photoInput) photoInput.value = '';
    
    updateGroupPhotoPreview(null);
    
    const resultsDiv = document.getElementById('groupPhotoResults');
    if (resultsDiv) resultsDiv.style.display = 'none';
    
    const statusEl = document.getElementById('groupPhotoStatus');
    if (statusEl) statusEl.textContent = 'Upload a group photo containing multiple workers to scan and record attendance.';
}

async function processGroupPhoto() {
    const photoInput = document.getElementById('groupPhotoInput');
    const photoFile = photoInput?.files?.[0] || null;
    const statusEl = document.getElementById('groupPhotoStatus');
    const project = attendanceState.currentProject;

    if (!photoFile) {
        showToast('Please select a group photo first.');
        return;
    }

    if (!attendanceState.workers.some(w => Array.isArray(w.descriptor) && w.descriptor.length)) {
        if (statusEl) statusEl.textContent = 'No enrolled worker profiles found. Please enroll workers first.';
        showToast('Enroll at least one worker before scanning group photos.');
        return;
    }

    try {
        if (statusEl) statusEl.textContent = 'Reading and analyzing group photo...';
        await loadFaceModels();
        
        const dataUrl = await readFileAsDataUrl(photoFile);
        const image = await loadImageFromDataUrl(dataUrl);
        
        console.log('Group photo loaded. Image dimensions:', image.width, 'x', image.height);

        let detections = [];
        try {
            console.log('Attempting TinyFaceDetector detection...');
            detections = await faceapi
                .detectAllFaces(image, new faceapi.TinyFaceDetectorOptions({ inputSize: 800, scoreThreshold: 0.05 }))
                .withFaceLandmarks()
                .withFaceDescriptors();
            console.log('TinyFaceDetector found:', detections.length, 'faces');
        } catch (detectionError) {
            console.error('TinyFaceDetector error:', detectionError);
            try {
                console.log('Trying with default TinyFaceDetector options...');
                detections = await faceapi
                    .detectAllFaces(image)
                    .withFaceLandmarks()
                    .withFaceDescriptors();
                console.log('Default detector found:', detections.length, 'faces');
            } catch (fallbackError) {
                console.error('Fallback detection also failed:', fallbackError);
                throw new Error('Face detection failed: ' + fallbackError.message);
            }
        }

        if (!detections.length) {
            if (statusEl) statusEl.textContent = 'No faces detected. Ensure: 1) Faces are clearly visible, 2) Good lighting, 3) Face takes up at least 20x20 pixels.';
            console.warn('No faces detected after all attempts');
            showToast('No faces detected in the photo.');
            return;
        }

        // Get workers to match against (prioritize current project, fall back to all if none found)
        let workersToMatch = attendanceState.workers.filter(w => w.project === project && Array.isArray(w.descriptor) && w.descriptor.length);
        if (!workersToMatch.length) {
            console.warn(`No enrolled workers found for project '${project}'. Using all enrolled workers.`);
            workersToMatch = attendanceState.workers.filter(w => Array.isArray(w.descriptor) && w.descriptor.length);
        }

        if (statusEl) statusEl.textContent = `Detected ${detections.length} face(s). Matching against ${workersToMatch.length} enrolled workers...`;
        console.log('Starting face matching');
        console.log('Workers available for matching:', workersToMatch.map(w => `${w.name} (${w.project})`));
        
        function getBox(det) {
            const b = (det && det.detection && det.detection.box) || det.box;
            if (!b) return null;
            return { x: b.x, y: b.y, w: b.width, h: b.height };
        }

        function iou(a, b) {
            if (!a || !b) return 0;
            const ax1 = a.x, ay1 = a.y, ax2 = a.x + a.w, ay2 = a.y + a.h;
            const bx1 = b.x, by1 = b.y, bx2 = b.x + b.w, by2 = b.y + b.h;
            const ix1 = Math.max(ax1, bx1), iy1 = Math.max(ay1, by1);
            const ix2 = Math.min(ax2, bx2), iy2 = Math.min(ay2, by2);
            const iw = Math.max(0, ix2 - ix1);
            const ih = Math.max(0, iy2 - iy1);
            const inter = iw * ih;
            const areaA = a.w * a.h;
            const areaB = b.w * b.h;
            const union = areaA + areaB - inter;
            return union <= 0 ? 0 : inter / union;
        }

        function clusterDetections(dets, iouThreshold = 0.35) {
            if (!Array.isArray(dets) || !dets.length) return [];
            const items = dets.map(d => ({ det: d, box: getBox(d), score: (d && d.detection && d.detection.score) || 0 }));
            items.sort((a, b) => b.score - a.score);
            const chosen = [];
            const suppressed = new Array(items.length).fill(false);
            for (let i = 0; i < items.length; i++) {
                if (suppressed[i]) continue;
                const a = items[i];
                chosen.push(a.det);
                for (let j = i + 1; j < items.length; j++) {
                    if (suppressed[j]) continue;
                    const b = items[j];
                    const iouv = iou(a.box, b.box);
                    if (iouv > iouThreshold) suppressed[j] = true;
                }
            }
            return chosen;
        }

        console.log('Detections before clustering:', detections.length);
        const clustered = clusterDetections(detections, 0.35);
        console.log('Detections after clustering:', clustered.length);
        detections = clustered;

        const todayKey = new Date().toISOString().slice(0, 10);
        const matchedWorkers = [];
        const distanceThreshold = 0.6;

        for (const detection of detections) {
            const detectedDescriptor = Array.from(detection.descriptor);
            let bestMatch = null;
            let bestScore = 0;
            const detectionScores = [];

            for (const worker of workersToMatch) {
                if (!worker) continue;

                let referenceDescriptors = [];
                if (Array.isArray(worker.descriptor) && worker.descriptor.length) {
                    if (Array.isArray(worker.descriptor[0])) {
                        referenceDescriptors = worker.descriptor;
                    } else {
                        referenceDescriptors = [worker.descriptor];
                    }
                }

                if (!referenceDescriptors.length) continue;

                let minDist = Infinity;
                for (const ref of referenceDescriptors) {
                    const d = Math.sqrt(ref.reduce((sum, val, idx) => sum + Math.pow(val - detectedDescriptor[idx], 2), 0));
                    if (d < minDist) minDist = d;
                }

                const similarity = 1 / (1 + minDist);
                detectionScores.push({ name: worker.name, distance: minDist.toFixed(4), similarity: similarity.toFixed(3) });

                if (minDist <= distanceThreshold && (1 / (1 + minDist)) > bestScore) {
                    bestScore = 1 / (1 + minDist);
                    bestMatch = { worker, score: bestScore, distance: minDist };
                }
            }
            
            console.log('Face detection scores:', detectionScores);
            if (bestMatch) {
                console.log('✓ Matched:', bestMatch.worker.name, 'Distance:', bestMatch.distance.toFixed(4), 'Score:', bestMatch.score.toFixed(3));
            } else {
                if (detectionScores.length) {
                    console.warn('✗ No match - closest was:', detectionScores[0].name, 'at distance', detectionScores[0].distance);
                }
            }

            if (bestMatch) {
                matchedWorkers.push({ ...bestMatch.worker, matchScore: bestMatch.score });
            }
        }

        const uniqueMatchesMap = new Map();
        for (const w of matchedWorkers) {
            if (!w || !w.id) continue;
            const existing = uniqueMatchesMap.get(w.id);
            if (!existing || (w.matchScore || 0) > (existing.matchScore || 0)) {
                uniqueMatchesMap.set(w.id, w);
            }
        }
        const uniqueMatchedWorkers = Array.from(uniqueMatchesMap.values());

        matchedWorkers.length = 0; 
        matchedWorkers.push(...uniqueMatchedWorkers);

        const recordedAttendance = [];
        for (const worker of uniqueMatchedWorkers) {
            const existingLogIndex = attendanceState.logs.findIndex(
                log => log.workerId === worker.id && log.project === worker.project && log.dateKey === todayKey
            );

            const timeInStr = new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
            const attendanceLog = {
                workerId: worker.id,
                workerName: worker.name,
                workerRole: worker.role,
                project: worker.project,
                dateKey: todayKey,
                timeIn: timeInStr,
                status: 'Present',
                score: worker.matchScore,
                scanSource: 'admin-group-photo',
            };

            if (existingLogIndex >= 0) {
                attendanceState.logs[existingLogIndex] = attendanceLog;
            } else {
                attendanceState.logs.push(attendanceLog);
            }

            recordedAttendance.push(attendanceLog);
        }

        persistLogs();
        
        for (const log of recordedAttendance) {
            try {
                await sendAttendanceApi('save-attendance', { log });
            } catch (e) {
                console.error('Failed to save attendance log:', e);
            }
        }

        const resultsDiv = document.getElementById('groupPhotoResults');
        const resultsBody = document.getElementById('groupPhotoResultsBody');
        
        if (resultsDiv && resultsBody) {
            if (matchedWorkers.length) {
                resultsBody.innerHTML = matchedWorkers.map(w => 
                    `<div style="padding:6px 0; border-bottom:1px solid var(--border);">
                        <div style="font-weight:600;">${w.name}</div>
                        <div style="color:var(--muted); font-size:10px;">${w.id} · ${w.role} · Match: ${(w.matchScore * 100).toFixed(0)}%</div>
                    </div>`
                ).join('');
                resultsDiv.style.display = 'block';
            } else {
                resultsBody.innerHTML = '<div>No workers matched in the group photo.</div>';
                resultsDiv.style.display = 'block';
            }
        }

        if (statusEl) statusEl.textContent = `Matched ${matchedWorkers.length} worker(s). Attendance recorded.`;
        renderAttendanceModule();
        showToast(`Attendance recorded for ${matchedWorkers.length} worker(s).`);
    } catch (error) {
        console.error('❌ Group photo processing FAILED:', error.message);
        console.error('Full error:', error);
        if (statusEl) statusEl.textContent = `Error: ${error.message}. Check console (F12) for details.`;
        showToast(`Error: ${error.message}`);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Restore the previously viewed page
    const savedPage = localStorage.getItem('dg-admin-current-page');
    if (savedPage && pageTitles[savedPage]) {
        const navItem = document.querySelector(`[onclick*="navigate('${savedPage}'"]`);
        navigate(savedPage, navItem);
    } else {
        // Default to dashboard if no saved page
        navigate('dashboard', document.querySelector("[onclick*=\"navigate('dashboard'\""));
    }

    initAttendanceModule();

    const sel = document.getElementById('inventory-location');
    if (sel) handleInventoryLocationChange(sel);
    const primary = document.getElementById('primaryAction');
    if (primary) primary.style.display = 'block';
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWbSxccPQtF3EpF3fnJHog6LaEVF+z4NhkxqHY4xZe3Z8L0L" crossorigin="anonymous"></script>

</body>
</html
