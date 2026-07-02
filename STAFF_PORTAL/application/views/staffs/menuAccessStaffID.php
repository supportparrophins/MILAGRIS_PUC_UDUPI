<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
  *, *::before, *::after { box-sizing: border-box; }

  body {
    background: #f0f2f7;
    font-family: 'DM Sans', sans-serif;
    margin: 0;
    padding: 0;
    color: #1a2340;
  }

  /* ── PAGE WRAPPER ── */
  .ma-wrapper {
    max-width: 1300px;
    margin: 28px auto;
    padding: 0 16px 40px;
  }

  /* ── PAGE TITLE BAR ── */
  .ma-titlebar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
  }
  .ma-titlebar .ma-icon {
    width: 42px; height: 42px;
    background: #1e3a8a;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 18px;
    flex-shrink: 0;
  }
  .ma-titlebar h4 {
    margin: 0; font-size: 1.35rem; font-weight: 700; color: #1a2340;
  }
  .ma-titlebar p { margin: 0; font-size: 0.82rem; color: #6b7a99; }

  /* ── TOOLBAR PANEL ── */
  .ma-toolbar {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 14px rgba(0,0,0,0.07);
    padding: 18px 22px;
    margin-bottom: 20px;
  }

  /* Role selector row */
  .ma-role-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 14px;
  }
  .ma-role-label {
    font-size: 0.82rem; font-weight: 600; color: #6b7a99;
    text-transform: uppercase; letter-spacing: .05em;
    white-space: nowrap;
  }

  /* ── Role Select Wrapper ── */
  .ma-select-wrap {
    position: relative;
    min-width: 260px;
    max-width: 360px;
    flex: 1;
  }
  .ma-select-wrap select {
    width: 100%;
    appearance: none;
    -webkit-appearance: none;
    background: #f8f9fc;
    border: 1.5px solid #dde1ee;
    border-radius: 8px;
    font-size: 0.95rem;
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
    color: #1a2340;
    padding: 9px 38px 9px 14px;
    cursor: pointer;
    outline: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
  }
  .ma-select-wrap select:focus {
    border-color: #1e3a8a;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(30,58,138,0.10);
  }
  .ma-select-wrap select option[value=""] { color: #9aa3bb; }
  .ma-select-arrow {
    position: absolute;
    right: 13px; top: 50%;
    transform: translateY(-50%);
    font-size: 11px;
    color: #6b7a99;
    pointer-events: none;
  }

  .ma-btn-search {
    background: #1e3a8a;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 9px 22px;
    font-size: 0.93rem;
    font-weight: 600;
    cursor: pointer;
    display: flex; align-items: center; gap: 7px;
    transition: background .2s, transform .1s;
    white-space: nowrap;
  }
  .ma-btn-search:hover { background: #163172; transform: translateY(-1px); }

  /* Divider */
  .ma-divider {
    height: 1px; background: #eef0f7; margin: 0 0 16px 0;
  }

  /* ── COMPACT BULK SECTION ── */
  .ma-bulk-bar {
    display: flex;
    flex-direction: column;
    gap: 0;
  }
  .ma-chips-row {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    padding-bottom: 12px;
  }
  .ma-bulk-sep-h {
    height: 1px;
    background: #eef0f7;
    margin-bottom: 12px;
  }
  .ma-grant-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }
  /* Grant / Revoke ALL pills */
  .ma-btn-grant-all, .ma-btn-revoke-all {
    border: none; border-radius: 7px;
    padding: 6px 14px; font-size: 0.82rem; font-weight: 700;
    cursor: pointer; transition: .15s;
    display: flex; align-items: center; gap: 6px;
    white-space: nowrap; flex-shrink: 0;
  }
  .ma-btn-grant-all  { background: #1a9c55; color: #fff; }
  .ma-btn-revoke-all { background: #d63031; color: #fff; }
  .ma-btn-grant-all:hover  { background: #167a43; }
  .ma-btn-revoke-all:hover { background: #b52828; }

  /* separator removed - now using horizontal divider */

  /* each perm chip group: label + +/- buttons */
  .ma-chip-group {
    display: flex; align-items: center;
    background: #f4f5fb;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e4e7f0;
    flex-shrink: 0;
  }
  .ma-chip-label {
    font-size: 0.77rem; font-weight: 600; color: #4a5470;
    padding: 0 8px; white-space: nowrap;
    display: flex; align-items: center; gap: 5px;
  }
  .ma-chip-label i { font-size: 11px; color: #8a94b0; }
  .ma-chip-on, .ma-chip-off {
    border: none; cursor: pointer;
    font-size: 0.72rem; font-weight: 700;
    padding: 5px 9px; transition: background .15s;
    line-height: 1;
  }
  .ma-chip-on  { background: #d0f5e4; color: #167a43; border-left: 1px solid #e4e7f0; }
  .ma-chip-off { background: #fad7d5; color: #b52828; border-left: 1px solid #e4e7f0; }
  .ma-chip-on:hover  { background: #b8edcf; }
  .ma-chip-off:hover { background: #f5b8b5; }

  /* ── SAVE BUTTONS ── */
  .ma-save-bar {
    display: flex; justify-content: flex-end;
    margin-bottom: 18px;
  }
  .ma-btn-save {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    color: #fff; border: none; border-radius: 10px;
    padding: 10px 32px; font-size: 1rem; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(30,58,138,0.30);
    transition: transform .15s, box-shadow .15s;
  }
  .ma-btn-save:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(30,58,138,0.35); }

  /* ── CARDS GRID ── */
  .ma-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 16px;
  }

  /* ── PERMISSION CARD ── */
  .pcard {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    overflow: hidden;
    display: flex; flex-direction: column;
    transition: box-shadow .2s, transform .2s;
  }
  .pcard:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.11); transform: translateY(-2px); }

  .pcard-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    padding: 13px 16px 11px;
    display: flex; align-items: center; justify-content: space-between;
  }
  .pcard-title {
    color: #fff; font-size: 0.92rem; font-weight: 700;
    line-height: 1.3; flex: 1; margin-right: 10px;
  }
  .pcard-title .module-tag {
    display: block; font-size: 0.7rem; font-weight: 500;
    color: rgba(255,255,255,0.65); margin-bottom: 1px;
    text-transform: uppercase; letter-spacing: .05em;
  }

  /* Master "All" toggle inside header */
  .pcard-all-toggle { flex-shrink: 0; display: flex; align-items: center; gap: 8px; }
  .pcard-all-toggle span { color: rgba(255,255,255,0.80); font-size: 0.77rem; font-weight: 600; }

  .pcard-body { padding: 10px 16px 14px; flex: 1; }

  /* permission row */
  .prow {
    display: flex; align-items: center; justify-content: space-between;
    padding: 7px 0;
    border-bottom: 1px solid #f0f2f7;
  }
  .prow:last-child { border-bottom: none; }
  .prow-label {
    font-size: 0.875rem; font-weight: 500; color: #3d4a6b;
    display: flex; align-items: center; gap: 8px;
  }
  .prow-label .prow-icon {
    width: 22px; height: 22px; border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; flex-shrink: 0;
  }
  .prow-icon.read    { background: #e8f4fd; color: #1a6dbd; }
  .prow-icon.add     { background: #e8faf1; color: #1a9c55; }
  .prow-icon.edit    { background: #fff7e0; color: #c68a00; }
  .prow-icon.del     { background: #fdecea; color: #d63031; }
  .prow-icon.approve { background: #f3e8ff; color: #7c3aed; }
  .prow-icon.super   { background: #fff0e0; color: #d97706; }
  .prow-icon.dash    { background: #e0f2fe; color: #0284c7; }
  .prow-icon.report  { background: #fef3c7; color: #b45309; }

  /* ── TOGGLE SWITCH ── */
  .ts { display: inline-block; position: relative; width: 42px; height: 24px; flex-shrink: 0; }
  .ts input { display: none; }
  .ts-track {
    width: 42px; height: 24px; background: #d1d5e0; border-radius: 50px;
    position: absolute; top: 0; left: 0; cursor: pointer;
    transition: background .22s;
  }
  .ts-track::after {
    content: '';
    position: absolute;
    width: 18px; height: 18px;
    background: #fff;
    border-radius: 50%;
    top: 3px; left: 3px;
    transition: transform .22s, box-shadow .22s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.18);
  }
  .ts input:checked ~ .ts-track { background: #22c55e; }
  .ts input:checked ~ .ts-track::after { transform: translateX(18px); }

  /* all-master toggle on header gets blue */
  .pcard-header .ts input:checked ~ .ts-track { background: rgba(255,255,255,0.9); }
  .pcard-header .ts input:checked ~ .ts-track::after { background: #1e3a8a; }
  .pcard-header .ts .ts-track { background: rgba(255,255,255,0.30); }
  .pcard-header .ts .ts-track::after { background: #fff; }

  @media (max-width: 680px) {
    .ma-bulk-grid { grid-template-columns: 1fr 1fr; }
    .ma-bulk-header:first-child, .ma-bulk-row-label { grid-column: 1 / -1; }
    .ma-cards-grid { grid-template-columns: 1fr; }
  }
</style>

</head>
<body>
<div class="ma-wrapper">

  <!-- Title Bar -->
  <div class="ma-titlebar">
    <div class="ma-icon"><i class="fas fa-shield-alt"></i></div>
    <div>
      <h4>Menu Access Control</h4>
      <p>Manage role-based permissions for each module</p>
    </div>
  </div>

  <!-- Toolbar Panel -->
  <div class="ma-toolbar">

    <!-- Role Selector -->
    <form id="rolselect" method="POST" action="<?php echo base_url() ?>menuAccessStaffId">
      <div class="ma-role-row">
        <span class="ma-role-label"><i class="fas fa-user-tag" style="margin-right:5px;"></i>Role</span>
        <div class="ma-select-wrap">
          <i class="fas fa-chevron-down ma-select-arrow"></i>
          <select id="firstSelect" name="staffId" class="form-control selectpicker" data-live-search="true" required>
                        <option value="">Select a Staff</option>
                        
                                <option value="<?php echo $by_staff_id; ?>" selected>
                                    Selected staff: <?php echo $by_staff_id ?>
                                </option>
                                <?php
                           
                        foreach ($staffInfo as $rl) {
                            ?>
                            <option value="<?php echo $rl->staff_id ?>">
                                <?php echo $rl->name ?> - <?php echo $rl->staff_id ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
        </div>
        <button type="submit" class="ma-btn-search">
          <i class="fas fa-search"></i> Search
        </button>
      </div>
    </form>

    <div class="ma-divider"></div>

    <!-- Bulk Actions -->
    <div class="ma-bulk-bar">

      <!-- Row 1: Permission Chips -->
      <div class="ma-chips-row">
        <div class="ma-chip-group">
          <span class="ma-chip-label"><i class="fas fa-eye"></i> Read</span>
          <button type="button" class="ma-chip-on enable-read">+</button>
          <button type="button" class="ma-chip-off disable-read">−</button>
        </div>
        <div class="ma-chip-group">
          <span class="ma-chip-label"><i class="fas fa-plus"></i> Add</span>
          <button type="button" class="ma-chip-on enable-add">+</button>
          <button type="button" class="ma-chip-off disable-add">−</button>
        </div>
        <div class="ma-chip-group">
          <span class="ma-chip-label"><i class="fas fa-pen"></i> Edit</span>
          <button type="button" class="ma-chip-on enable-edit">+</button>
          <button type="button" class="ma-chip-off disable-edit">−</button>
        </div>
        <div class="ma-chip-group">
          <span class="ma-chip-label"><i class="fas fa-trash"></i> Delete</span>
          <button type="button" class="ma-chip-on enable-delete">+</button>
          <button type="button" class="ma-chip-off disable-delete">−</button>
        </div>
        <div class="ma-chip-group">
          <span class="ma-chip-label"><i class="fas fa-check-circle"></i> Approve</span>
          <button type="button" class="ma-chip-on enable-approve">+</button>
          <button type="button" class="ma-chip-off disable-approve">−</button>
        </div>
        <div class="ma-chip-group">
          <span class="ma-chip-label"><i class="fas fa-tachometer-alt"></i> Dashboard</span>
          <button type="button" class="ma-chip-on enable-dashboard">+</button>
          <button type="button" class="ma-chip-off disable-dashboard">−</button>
        </div>
        <div class="ma-chip-group">
          <span class="ma-chip-label"><i class="fas fa-file-alt"></i> Report</span>
          <button type="button" class="ma-chip-on enable-report">+</button>
          <button type="button" class="ma-chip-off disable-report">−</button>
        </div>
      </div>

      <!-- Row 2: Grant / Revoke ALL -->
      <div class="ma-bulk-sep-h"></div>
      <div class="ma-grant-row">
        <button type="button" class="ma-btn-grant-all grant-all"><i class="fas fa-unlock-alt"></i> Grant All Permissions</button>
        <button type="button" class="ma-btn-revoke-all revoke-all"><i class="fas fa-lock"></i> Revoke All Permissions</button>
      </div>

    </div>

  </div><!-- /toolbar -->


  <!-- Permission Cards Form -->
  <form action="<?= base_url('updateAccessByStaffID'); ?>" method="POST" id="byFilterMethod">
    <input type="hidden" name="staffId" value="<?= $stafff->staff_id; ?>">

    <!-- Top Save -->
    <div class="ma-save-bar">
      <button type="submit" class="ma-btn-save">
        <i class="fas fa-save"></i> Save Permissions
      </button>
    </div>

    <?php if (!empty($AllModuleInfo)): ?>
    <div class="ma-cards-grid">
      <?php foreach ($AllModuleInfo as $menu):
        $AccessInfo = $staff_model->getModuleAccessInfoByStaffID($menu->row_id, $stafff->staff_id);
        $menuLabel  = preg_replace('/\s+/', ' ', trim(strip_tags(str_replace('&nbsp;', ' ', $menu->menu_name))));
      ?>
      <div class="pcard permission-card">

        <!-- Card Header -->
        <div class="pcard-header">
          <div class="pcard-title">
            <?php if (!empty($menu->module_name)): ?>
              <span class="module-tag"><?= htmlspecialchars($menu->module_name) ?></span>
            <?php endif; ?>
            <?= htmlspecialchars($menuLabel) ?>
          </div>
          <!-- All toggle -->
          <div class="pcard-all-toggle">
            <span>All</span>
            <label class="ts">
              <input type="checkbox" id="all-<?= $menu->row_id ?>-<?= $stafff->staff_id ?>" class="all-toggle-master">
              <span class="ts-track"></span>
            </label>
          </div>
        </div>

        <!-- Card Body -->
        <div class="pcard-body">
          <input type="hidden" name="module_id[]" value="<?= $menu->row_id; ?>">

          <!-- Read -->
          <div class="prow">
            <span class="prow-label">
              <span class="prow-icon read"><i class="fas fa-eye"></i></span> Read
            </span>
            <label class="ts">
              <input type="checkbox" id="view-<?= $menu->row_id ?>-<?= $stafff->staff_id ?>" class="perm-toggle"
                name="can_view[<?= $menu->row_id ?>][<?= $stafff->staff_id ?>]"
                value="1" <?= !empty($AccessInfo->can_view) ? 'checked' : '' ?>>
              <span class="ts-track"></span>
            </label>
          </div>

          <!-- Add -->
          <div class="prow">
            <span class="prow-label">
              <span class="prow-icon add"><i class="fas fa-plus"></i></span> Add
            </span>
            <label class="ts">
              <input type="checkbox" id="add-<?= $menu->row_id ?>-<?= $stafff->staff_id ?>" class="perm-toggle"
                name="can_add[<?= $menu->row_id ?>][<?= $stafff->staff_id ?>]"
                value="1" <?= !empty($AccessInfo->can_add) ? 'checked' : '' ?>>
              <span class="ts-track"></span>
            </label>
          </div>

          <!-- Edit -->
          <div class="prow">
            <span class="prow-label">
              <span class="prow-icon edit"><i class="fas fa-pen"></i></span> Edit
            </span>
            <label class="ts">
              <input type="checkbox" id="edit-<?= $menu->row_id ?>-<?= $stafff->staff_id ?>" class="perm-toggle"
                name="can_edit[<?= $menu->row_id ?>][<?= $stafff->staff_id ?>]"
                value="1" <?= !empty($AccessInfo->can_edit) ? 'checked' : '' ?>>
              <span class="ts-track"></span>
            </label>
          </div>

          <!-- Delete -->
          <div class="prow">
            <span class="prow-label">
              <span class="prow-icon del"><i class="fas fa-trash"></i></span> Delete
            </span>
            <label class="ts">
              <input type="checkbox" id="delete-<?= $menu->row_id ?>-<?= $stafff->staff_id ?>" class="perm-toggle"
                name="can_delete[<?= $menu->row_id ?>][<?= $stafff->staff_id ?>]"
                value="1" <?= !empty($AccessInfo->can_delete) ? 'checked' : '' ?>>
              <span class="ts-track"></span>
            </label>
          </div>

          <!-- Approve -->
          <div class="prow">
            <span class="prow-label">
              <span class="prow-icon approve"><i class="fas fa-check-circle"></i></span> Approve / Reject
            </span>
            <label class="ts">
              <input type="checkbox" id="approve-<?= $menu->row_id ?>-<?= $stafff->staff_id ?>" class="perm-toggle"
                name="can_approve[<?= $menu->row_id ?>][<?= $stafff->staff_id ?>]"
                value="1" <?= !empty($AccessInfo->can_approve) ? 'checked' : '' ?>>
              <span class="ts-track"></span>
            </label>
          </div>

          <!-- Super Access -->
          <div class="prow">
            <span class="prow-label">
              <span class="prow-icon super"><i class="fas fa-star"></i></span> Super Access
            </span>
            <label class="ts">
              <input type="checkbox" id="super-<?= $menu->row_id ?>-<?= $stafff->staff_id ?>" class="perm-toggle"
                name="super_access[<?= $menu->row_id ?>][<?= $stafff->staff_id ?>]"
                value="1" <?= !empty($AccessInfo->super_access) ? 'checked' : '' ?>>
              <span class="ts-track"></span>
            </label>
          </div>

          <!-- Dashboard -->
          <div class="prow">
            <span class="prow-label">
              <span class="prow-icon dash"><i class="fas fa-tachometer-alt"></i></span> Dashboard
            </span>
            <label class="ts">
              <input type="checkbox" id="dashboard-<?= $menu->row_id ?>-<?= $stafff->staff_id ?>" class="perm-toggle"
                name="dashboard[<?= $menu->row_id ?>][<?= $stafff->staff_id ?>]"
                value="1" <?= !empty($AccessInfo->dashboard) ? 'checked' : '' ?>>
              <span class="ts-track"></span>
            </label>
          </div>

          <!-- Report -->
          <div class="prow">
            <span class="prow-label">
              <span class="prow-icon report"><i class="fas fa-file-alt"></i></span> Report
            </span>
            <label class="ts">
              <input type="checkbox" id="report-<?= $menu->row_id ?>-<?= $stafff->staff_id ?>" class="perm-toggle"
                name="report[<?= $menu->row_id ?>][<?= $stafff->staff_id ?>]"
                value="1" <?= !empty($AccessInfo->report) ? 'checked' : '' ?>>
              <span class="ts-track"></span>
            </label>
          </div>

        </div><!-- /pcard-body -->
      </div><!-- /pcard -->
      <?php endforeach; ?>
    </div><!-- /grid -->

    <!-- Bottom Save -->
    <div class="ma-save-bar" style="margin-top:24px;">
      <button type="submit" class="ma-btn-save">
        <i class="fas fa-save"></i> Save Permissions
      </button>
    </div>

    <?php endif; ?>
  </form>

</div><!-- /ma-wrapper -->

<script src="<?php echo base_url(); ?>assets/js/student.js" type="text/javascript"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  function syncMaster(card) {
    var master = card.querySelector('.all-toggle-master');
    var perms  = card.querySelectorAll('.perm-toggle');
    if (!master || perms.length === 0) return;
    master.checked = Array.from(perms).every(function (c) { return c.checked; });
  }

  function syncAllMasters() {
    document.querySelectorAll('.pcard').forEach(syncMaster);
  }

  document.querySelectorAll('.pcard').forEach(function (card) {
    var master = card.querySelector('.all-toggle-master');
    var perms  = card.querySelectorAll('.perm-toggle');
    if (!master) return;

    master.addEventListener('change', function () {
      perms.forEach(function (cb) { cb.checked = master.checked; });
    });
    perms.forEach(function (cb) {
      cb.addEventListener('change', function () { syncMaster(card); });
    });
    syncMaster(card);
  });

  // Global bulk buttons
  var actions = {
    '.grant-all':        { sel: '.pcard input[type="checkbox"]', val: true,  sync: true },
    '.revoke-all':       { sel: '.pcard input[type="checkbox"]', val: false, sync: true },
    '.enable-read':      { sel: 'input[id^="view-"]',      val: true,  sync: true },
    '.disable-read':     { sel: 'input[id^="view-"]',      val: false, sync: true },
    '.enable-add':       { sel: 'input[id^="add-"]',       val: true,  sync: true },
    '.disable-add':      { sel: 'input[id^="add-"]',       val: false, sync: true },
    '.enable-edit':      { sel: 'input[id^="edit-"]',      val: true,  sync: true },
    '.disable-edit':     { sel: 'input[id^="edit-"]',      val: false, sync: true },
    '.enable-delete':    { sel: 'input[id^="delete-"]',    val: true,  sync: true },
    '.disable-delete':   { sel: 'input[id^="delete-"]',    val: false, sync: true },
    '.enable-approve':   { sel: 'input[id^="approve-"]',   val: true,  sync: true },
    '.disable-approve':  { sel: 'input[id^="approve-"]',   val: false, sync: true },
    '.enable-dashboard': { sel: 'input[id^="dashboard-"]', val: true,  sync: true },
    '.disable-dashboard':{ sel: 'input[id^="dashboard-"]', val: false, sync: true },
    '.enable-report':    { sel: 'input[id^="report-"]',    val: true,  sync: true },
    '.disable-report':   { sel: 'input[id^="report-"]',    val: false, sync: true },
  };

  Object.entries(actions).forEach(function ([selector, cfg]) {
    var btn = document.querySelector(selector);
    if (!btn) return;
    btn.addEventListener('click', function () {
      document.querySelectorAll(cfg.sel).forEach(function (cb) { cb.checked = cfg.val; });
      if (cfg.sync) syncAllMasters();
    });
  });
});
</script>