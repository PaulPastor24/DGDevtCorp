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
    <link rel="stylesheet" href="css/client.css">
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
            <div class="logo-sub">Client Portal</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Project Overview</div>
            <div class="nav-item active" onclick="navigate('dashboard', this)">
                Project Status
            </div>
            <div class="nav-item" onclick="navigate('timeline', this)">
                Timeline & Phases
            </div>

            <div class="nav-section-label">Updates</div>
            <div class="nav-item" onclick="navigate('updates', this)">
                Site Updates
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
                <div class="user-avatar">CU</div>
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($userName); ?></div>
                    <div class="user-role"><?php echo htmlspecialchars($userTitle); ?></div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="topbar-title" id="pageTitle">Project Status</div>
            <div class="topbar-right">
                <span style="font-size:12px;color:var(--muted)">Mon, 28 Apr 2026</span>
                <div class="topbar-notif">
                    <div class="notif-dot"></div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="page active" id="pg-dashboard">
                <div class="client-banner">
                    <div class="client-banner-label">Client Portal â€” Read Only</div>
                    <div class="client-banner-title">Rizal Residential Complex</div>
                    <div class="client-banner-sub">Your project is progressing on schedule. Last updated: Apr 28, 2026</div>
                </div>

                <div class="kpi-grid">
                    <div class="kpi-card">
                        <div class="kpi-title">Overall Progress</div>
                        <div class="kpi-value" style="color:var(--accent);">62%</div>
                        <div class="kpi-sub">Phase 3 of 5 underway</div>
                    </div>
                    <div class="kpi-card">
                        <div class="kpi-title">Current Phase</div>
                        <div class="kpi-value" style="font-size:16px; padding-top:4px;">Structural Works</div>
                        <div class="kpi-sub">67% of phase complete</div>
                    </div>
                    <div class="kpi-card">
                        <div class="kpi-title">Project Status</div>
                        <div class="kpi-value" style="font-size:16px; padding-top:4px; color:var(--green);">On Track</div>
                        <div class="kpi-sub">Target completion: Aug 2026</div>
                    </div>
                </div>

                <div class="stat-grid" style="grid-template-columns: 1fr;">
                    <div class="card mb-0">
                        <div class="card-title" style="margin-bottom:12px;">Project Summary</div>
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; font-size:13px;">
                            <div>
                                <div style="color:var(--muted); margin-bottom:4px;">Project Location</div>
                                <div>ðŸ“ Calamba, Laguna</div>
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
                                <div class="phase-name">Phase 1 â€” Site Preparation & Earthworks</div>
                                <div class="phase-dates">Jan 15 â€“ Feb 28, 2026 Â· Completed on time</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--green);">âœ“</div>
                            </div>
                        </div>
                        <div class="timeline-phase">
                            <div class="phase-dot done"></div>
                            <div class="phase-info">
                                <div class="phase-name">Phase 2 â€” Foundation Works</div>
                                <div class="phase-dates">Mar 1 â€“ Apr 10, 2026 Â· Completed 3 days early</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--green);">âœ“</div>
                            </div>
                        </div>
                        <div class="timeline-phase">
                            <div class="phase-dot current"></div>
                            <div class="phase-info">
                                <div class="phase-name">Phase 3 â€” Structural Works</div>
                                <div class="phase-dates">Apr 11 â€“ Jun 30, 2026 Â· In progress</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--accent);">67%</div>
                            </div>
                        </div>
                        <div class="timeline-phase">
                            <div class="phase-dot upcoming"></div>
                            <div class="phase-info">
                                <div class="phase-name">Phase 4 â€” MEP Installation</div>
                                <div class="phase-dates">Jul 1 â€“ Jul 31, 2026 Â· Upcoming</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--muted);">â€”</div>
                            </div>
                        </div>
                        <div class="timeline-phase">
                            <div class="phase-dot upcoming"></div>
                            <div class="phase-info">
                                <div class="phase-name">Phase 5 â€” Finishing & Turnover</div>
                                <div class="phase-dates">Aug 1 â€“ Aug 31, 2026 Â· Upcoming</div>
                            </div>
                            <div class="phase-right">
                                <div class="phase-pct" style="color:var(--muted);">â€”</div>
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
                    <div style="padding:16px; background:var(--surface); border-radius:10px; border-left:4px solid var(--accent); border: 1px solid var(--border);">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                            <div style="font-size:13px; font-weight:500;">Column forms completed on Levels 3â€“5. Level 4 slab pour completed successfully.</div>
                            <div style="font-size:11px; color:var(--muted);">Apr 26, 2026</div>
                        </div>
                        <div style="font-size:12px; color:var(--muted);">Phase 3 â€” Structural Works</div>
                    </div>

                    <div style="padding:16px; background:var(--surface); border-radius:10px; border-left:4px solid var(--green); border: 1px solid var(--border);">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                            <div style="font-size:13px; font-weight:500;">Foundation phase officially closed. Structural works mobilization complete.</div>
                            <div style="font-size:11px; color:var(--muted);">Apr 19, 2026</div>
                        </div>
                        <div style="font-size:12px; color:var(--muted);">Phase Transition</div>
                    </div>

                    <div style="padding:16px; background:var(--surface); border-radius:10px; border-left:4px solid var(--green); border: 1px solid var(--border);">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                            <div style="font-size:13px; font-weight:500;">Foundation works completed 3 days ahead of schedule. Excellent work by contractor team.</div>
                            <div style="font-size:11px; color:var(--muted);">Apr 10, 2026</div>
                        </div>
                        <div style="font-size:12px; color:var(--muted);">Phase 2 â€” Foundation Works</div>
                    </div>

                    <div style="padding:16px; background:var(--surface); border-radius:10px; border-left:4px solid var(--blue); border: 1px solid var(--border);">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                            <div style="font-size:13px; font-weight:500;">Site inspections passed. All safety protocols confirmed. Ready for foundation stage.</div>
                            <div style="font-size:11px; color:var(--muted);">Feb 28, 2026</div>
                        </div>
                        <div style="font-size:12px; color:var(--muted);">Quality Assurance</div>
                    </div>

                    <div style="padding:16px; background:var(--surface); border-radius:10px; border-left:4px solid var(--green); border: 1px solid var(--border);">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                            <div style="font-size:13px; font-weight:500;">Site preparation and earthworks completed. Equipment and materials mobilized.</div>
                            <div style="font-size:11px; color:var(--muted);">Feb 25, 2026</div>
                        </div>
                        <div style="font-size:12px; color:var(--muted);">Phase 1 â€” Site Preparation</div>
                    </div>
                </div>

                <div style="margin-top:24px; padding:12px; background:rgba(59,130,246,0.06); border-radius:8px; border:1px solid rgba(59,130,246,0.15); font-size:12px; color:var(--muted);">
                    ðŸ”’ Internal cost and workforce data is restricted to authorized personnel only.
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
        window.location.href = 'landing.html';
    }
}

function goHome() {
    window.location.href = 'landing.html';
}
</script>

</body>
</html>

