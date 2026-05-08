let currentRole = 'admin';

function selectRole(el, role) {
  document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
  if (el) el.classList.add('active');
  currentRole = role;
}

function doLogin() {
  const loginPage = document.getElementById('loginPage');
  const mainApp = document.getElementById('mainApp');
  if (loginPage) loginPage.style.display = 'none';
  if (mainApp) mainApp.style.display = 'flex';
  if (currentRole === 'client') {
    navigate('client', document.querySelector('[onclick*="client"]'));
  }
}

function doLogout() {
  document.getElementById('mainApp').style.display = 'none';
  document.getElementById('loginPage').style.display = 'flex';
}

const pageTitles = {
  dashboard: 'Management Dashboard',
  client: 'Client Dashboard',
  timeline: 'Project Timeline',
  report: 'Progress Report Submission',
  phase: 'Admin Phase Management',
  attendance: 'Facial Attendance',
  materials: 'Materials & Inventory',
  alerts: 'Alerts & Notifications',
};

const primaryActions = {
  dashboard: '+ New Project',
  client: '',
  timeline: '+ Add Phase',
  report: '+ New Report',
  phase: '',
  attendance: '+ Register Worker',
  materials: '+ Log Delivery',
  alerts: 'Mark All Read',
};

function navigate(page, el) {
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
}

function primaryAction() {
  showToast('Feature coming soon!');
}

function showToast(msg) {
  const t = document.getElementById('toast');
  if (!t) return;
  t.textContent = msg;
  t.style.opacity = '1';
  t.style.transform = 'translateY(0)';
  setTimeout(() => {
    t.style.opacity = '0';
    t.style.transform = 'translateY(20px)';
  }, 2800);
}

const inventoryData = {
  "Overall": { total: '₱4.93M', html: '' },
};

function handleInventoryLocationChange(sel) {
  const loc = sel.value;
  const totalEl = document.getElementById('total-inventory-value');
  const list = document.getElementById('inventory-list');
  if (inventoryData[loc]) {
    if (totalEl) totalEl.textContent = inventoryData[loc].total;
    if (list) list.innerHTML = inventoryData[loc].html;
  }
}

document.addEventListener('DOMContentLoaded', () => {
  if (typeof initialRole !== 'undefined') {
    currentRole = initialRole;
    // set active role tab if present
    const el = document.querySelector('.role-tab[onclick*="' + currentRole + '"]');
    if (el) el.classList.add('active');
    if (currentRole === 'client') {
      navigate('client', document.querySelector('[onclick*="client"]'));
    }
  }

  const sel = document.getElementById('inventory-location');
  if (sel) handleInventoryLocationChange(sel);
  const primary = document.getElementById('primaryAction');
  if (primary) primary.style.display = 'block';
});
