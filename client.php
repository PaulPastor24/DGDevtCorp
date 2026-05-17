<?php
session_start();
$userRole = 'client';
$userName = 'Client User';
$userTitle = 'Project Manager';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Portal D&G Construction Monitor</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUarbnLLtQbOV5JnXwyIEo56nNmslbdkrMjW03fNvqrviJkur" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/admin.css?v=<?php echo filemtime('css/admin.css'); ?>">
</head>
<body>

<div class="app">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-badge">
                <div>
                    <div class="logo-text">ConstructMonitor</div>
                </div>
            </div>
            <div class="logo-sub">D&G Dev't Corporation</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Overview</div>
            <div class="nav-item active" id="nav-dashboard" onclick="navigate('dashboard', this)">
                Project Status
            </div>
            <div class="nav-item" id="nav-timeline" onclick="navigate('timeline', this)">
                Timeline & Phases
            </div>

            <div class="nav-section-label">Updates</div>
            <div class="nav-item" id="nav-updates" onclick="navigate('updates', this)">
                Site Updates
            </div>

            <div class="nav-section-label">System</div>
            <div class="nav-item" onclick="doLogout()">
                Sign Out
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($userName); ?></div>
                    <div class="user-role"><?php echo htmlspecialchars($userTitle); ?></div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="topbar-left">
                <div class="topbar-title" id="pageTitle">Project Status</div>
            </div>
            <div class="topbar-right">
                <span style="font-size:12px;color:var(--muted)">Mon, 28 Apr 2026</span>
                <button class="topbar-btn primary" id="primaryAction" onclick="primaryAction()">View Timeline</button>
            </div>
        </div>

        <div class="content">
            <div class="page active" id="pg-dashboard">
                <div class="stat-grid">
                    <div class="stat-card" style="--accent-color: var(--accent);">
                        <div class="stat-label">Overall Progress</div>
                        <div class="stat-value">62%</div>
                        <div class="stat-change up">On schedule</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--green);">
                        <div class="stat-label">Current Phase</div>
                        <div class="stat-value" style="font-size:22px;">Structural Works</div>
                        <div class="stat-change up">67% of phase complete</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--blue);">
                        <div class="stat-label">Project Status</div>
                        <div class="stat-value" style="font-size:22px; color:var(--green);">On Track</div>
                        <div class="stat-change">Target completion: Aug 2026</div>
                    </div>
                    <div class="stat-card" style="--accent-color: var(--yellow);">
                        <div class="stat-label">Next Milestone</div>
                        <div class="stat-value" style="font-size:22px;">MEP Installation</div>
                        <div class="stat-change">Planned for Jul 2026</div>
                    </div>
                </div>

                <div class="two-col">
                    <div>
                        <div class="card mb-0">
                            <div class="card-header">
                                <div class="card-title">Project Summary</div>
                                <span class="tag green">Read Only</span>
                            </div>
                            <div style="display:grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap:16px; font-size:13px;">
                                <div>
                                    <div style="color:var(--muted); margin-bottom:4px;">Project Location</div>
                                    <div>Calamba, Laguna</div>
                                </div>
                                <div>
                                    <div style="color:var(--muted); margin-bottom:4px;">Project Architect</div>
                                    <div>ABC Architects Inc.</div>
                                </div>
                                <div>
                                    <div style="color:var(--muted); margin-bottom:4px;">Primary Contractor</div>
                                    <div>R. Santos Construction</div>
                                </div>
                                <div>
                                    <div style="color:var(--muted); margin-bottom:4px;">Project Manager</div>
                                    <div>Engr. Ricardo Santos</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card mb-0" style="margin-bottom:16px;">
                            <div class="card-header">
                                <div class="card-title">Project Snapshot</div>
                                <div style="font-size:12px;color:var(--muted)">Last updated: Apr 28, 2026</div>
                            </div>
                            <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:62%"></div></div>
                            <div class="proj-meta" style="margin-top:10px;"><span>62% complete</span><span>Target: Aug 2026</span></div>
                            <div style="margin-top:14px; display:grid; gap:10px;">
                                <div style="display:flex; justify-content:space-between; gap:12px; font-size:13px;"><span style="color:var(--muted);">Phase owner</span><span>Site Engineering Team</span></div>
                                <div style="display:flex; justify-content:space-between; gap:12px; font-size:13px;"><span style="color:var(--muted);">Latest review</span><span>Approved for next phase</span></div>
                                <div style="display:flex; justify-content:space-between; gap:12px; font-size:13px;"><span style="color:var(--muted);">Client access</span><span>Read only</span></div>
                            </div>
                        </div>

                        <div class="card mb-0">
                            <div class="card-header">
                                <div class="card-title">Latest Site Update</div>
                                <span class="tag blue">Apr 26, 2026</span>
                            </div>
                            <div style="font-size:13px; line-height:1.7; color:var(--text);">
                                Column forms completed on Levels 3-5. Level 4 slab pour was completed successfully and structural work remains on track.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page" id="pg-timeline">
                <div class="page-header">
                    <h1>Timeline & Milestones</h1>
                    <p>Construction phases and project milestones.</p>
                </div>

                <div class="card mb-0">
                    <div class="card-title" style="margin-bottom:14px;">Phase Milestones</div>
                    <div class="timeline-wrap">
                        <div class="timeline-phase">
                            <div class="phase-dot done"></div>
                            <div class="phase-info">
                                <div class="phase-name">Phase 1 Site Preparation & Earthworks</div>
                                <div class="phase-dates">Jan 15 Feb 28, 2026 Completed on time</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--green);">O</div>
                            </div>
                        </div>
                        <div class="timeline-phase">
                            <div class="phase-dot done"></div>
                            <div class="phase-info">
                                <div class="phase-name">Phase 2 Foundation Works</div>
                                <div class="phase-dates">Mar 1 Apr 10, 2026 Completed 3 days early</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--green);">O</div>
                            </div>
                        </div>
                        <div class="timeline-phase">
                            <div class="phase-dot current"></div>
                            <div class="phase-info">
                                <div class="phase-name">Phase 3 Structural Works</div>
                                <div class="phase-dates">Apr 11 Jun 30, 2026 · In progress</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--accent);">67%</div>
                            </div>
                        </div>
                        <div class="timeline-phase">
                            <div class="phase-dot upcoming"></div>
                            <div class="phase-info">
                                <div class="phase-name">Phase 4 MEP Installation</div>
                                <div class="phase-dates">Jul 1 Jul 31, 2026 · Upcoming</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--muted);">—</div>
                            </div>
                        </div>
                        <div class="timeline-phase">
                            <div class="phase-dot upcoming"></div>
                            <div class="phase-info">
                                <div class="phase-name">Phase 5 Finishing & Turnover</div>
                                <div class="phase-dates">Aug 1 Aug 31, 2026 · Upcoming</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--muted);">—</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page" id="pg-updates">
                <div class="page-header">
                    <h1>Site Updates</h1>
                    <p>Latest news and milestones from your construction site.</p>
                </div>

                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="card-title">Column Forms Completed</div>
                            <div style="font-size:11px; color:var(--muted);">Apr 26, 2026</div>
                        </div>
                        <div style="font-size:13px; line-height:1.7;">Column forms completed on Levels 3-5. Level 4 slab pour completed successfully.</div>
                        <div style="font-size:12px; color:var(--muted); margin-top:8px;">Phase 3 - Structural Works</div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="card-title">Foundation Phase Closed</div>
                            <div style="font-size:11px; color:var(--muted);">Apr 19, 2026</div>
                        </div>
                        <div style="font-size:13px; line-height:1.7;">Foundation phase officially closed. Structural works mobilization complete.</div>
                        <div style="font-size:12px; color:var(--muted); margin-top:8px;">Phase Transition</div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="card-title">Foundation Completed Early</div>
                            <div style="font-size:11px; color:var(--muted);">Apr 10, 2026</div>
                        </div>
                        <div style="font-size:13px; line-height:1.7;">Foundation works completed 3 days ahead of schedule. Excellent work by the contractor team.</div>
                        <div style="font-size:12px; color:var(--muted); margin-top:8px;">Phase 2 - Foundation Works</div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="card-title">Site Inspection Passed</div>
                            <div style="font-size:11px; color:var(--muted);">Feb 28, 2026</div>
                        </div>
                        <div style="font-size:13px; line-height:1.7;">Site inspections passed. All safety protocols confirmed. Ready for the foundation stage.</div>
                        <div style="font-size:12px; color:var(--muted); margin-top:8px;">Quality Assurance</div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="card-title">Site Preparation Complete</div>
                            <div style="font-size:11px; color:var(--muted);">Feb 25, 2026</div>
                        </div>
                        <div style="font-size:13px; line-height:1.7;">Site preparation and earthworks completed. Equipment and materials mobilized.</div>
                        <div style="font-size:12px; color:var(--muted); margin-top:8px;">Phase 1 - Site Preparation</div>
                    </div>
                </div>

                <div style="margin-top:24px; padding:12px; background:rgba(61,107,61,0.08); border-radius:8px; border:1px solid rgba(61,107,61,0.15); font-size:12px; color:var(--muted);">
                    Internal cost and workforce data is restricted to authorized personnel only.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const pageTitles = {
    dashboard: 'Project Status',
    timeline: 'Timeline & Milestones',
    updates: 'Site Updates',
};

function navigate(page, el) {
    localStorage.setItem('dg-client-current-page', page);
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

    const pg = document.getElementById('pg-' + page);
    if (pg) pg.classList.add('active');
    if (el) el.classList.add('active');

    const pageTitle = document.getElementById('pageTitle');
    if (pageTitle) pageTitle.textContent = pageTitles[page] || page;
}

function doLogout() {
    if (confirm('Are you sure you want to sign out?')) {
        window.location.href = 'logout.php';
    }
}

function primaryAction() {
    const timelineNav = document.getElementById('nav-timeline');
    navigate('timeline', timelineNav);
}

document.addEventListener('DOMContentLoaded', () => {
    const savedPage = localStorage.getItem('dg-client-current-page');
    if (savedPage && pageTitles[savedPage]) {
        const navItem = document.getElementById(`nav-${savedPage}`);
        navigate(savedPage, navItem);
    } else {
        navigate('dashboard', document.getElementById('nav-dashboard'));
    }
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWbSxccPQtF3EpF3fnJHog6LaEVF+z4NhkxqHY4xZe3Z8L0L" crossorigin="anonymous"></script>

</body>
</html>

