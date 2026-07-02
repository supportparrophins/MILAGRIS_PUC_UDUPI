

  <style>
    body {
      background: #f5f6fa;
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 1200px;
      margin: 28px auto 0 auto;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.06);
      padding: 20px 18px 14px 18px;
    }
    .mb-1 {margin-bottom: 8px;}
    .mb-2 {margin-bottom: 16px;}
    .fw-bold {font-weight: 600;}
    .d-flex {display: flex; align-items: center;}
    .form-inline {display: flex;}
    .form-select, .form-control {
      border-radius: 7px;
      border: 1px solid #dadada;
      font-size: 1rem;
      padding: 5px 12px;
      margin-right: 7px;
    }
    .btn {padding: 5px 14px; border-radius: 6px; border: none; font-size: 1rem; cursor: pointer; margin: 2px 6px 2px 0;}
    .btn-primary {background: #1976d2; color: #fff;}
    .btn-outline-primary {background: #fff; border: 1.2px solid #1976d2; color: #1976d2;}
    .btn-outline-danger {background: #fff; border: 1.2px solid #dc3545; color: #dc3545;}
    .btn-sm {font-size: .95rem; padding: 4px 12px;}
    .btn-success {background: #20c997; color: #fff;}
    .row {display: flex; flex-wrap: wrap; gap: 16px; margin-top: 10px;}
    .col-md-4 {flex: 1 1 0; min-width: 280px; max-width: 340px;}
    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0px 1px 6px rgba(0,0,0,0.10);
      padding: 15px 18px 10px 18px;
      margin-bottom: 0;
      min-height: 180px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .permission-group {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 7px;
      font-size: 16px;
    }
    .permission-group:first-of-type {margin-top: 8px;}
    .toggle-switch input {display: none;}
    .toggle-switch label {
      width: 38px; height: 21px; background: #8a7f7fff; border-radius: 50px; display: inline-block;
      position:relative; cursor:pointer; transition:.2s;
    }
    .toggle-switch label:after {
      content: ""; position:absolute; width:16px;height:16px;border-radius:50%;top:2.5px;left:3px;
      background:#fff;transition:.2s;
    }
    .toggle-switch input:checked + label {background: #1976d2;}
    .toggle-switch input:checked + label:after {left:19px;}
    h6 {margin:0 0 2px 0; font-size: 18px;}
    @media (max-width: 900px) {
      .row {flex-direction: column; gap:14px;}
      .col-md-4 {max-width:none;}
      .container {padding: 7px 3vw;}
    }

    /* .permission-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 8px 0;
    } */

    /* .toggle-switch {
    position: relative;
    width: 50px;
    height: 24px;
    }

    .toggle-switch input {
    display: none;
    }

    .toggle-switch label {
    position: absolute;
    cursor: pointer;
    background: #ccc;
    border-radius: 34px;
    width: 100%;
    height: 100%;
    transition: 0.3s;
    }

    .toggle-switch label:before {
    content: "";
    position: absolute;
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background: #fff;
    border-radius: 50%;
    transition: 0.3s;
    }

    

    .toggle-switch input:checked + label:before {
    transform: translateX(26px);
    } */

    .permission-group.all-toggle-row {
        border-bottom: 1.5px solid rgba(0,0,0,0.15);
        margin-bottom: 6px;
        padding-bottom: 7px;
    }
    .permission-group.all-toggle-row span {
        font-weight: 700;
        color: #0a1628;
    }
    .all-toggle-row .toggle-switch input:checked + label {
        background: #0a3d62;  /* darker blue to distinguish from regular toggles */
    }

    .toggle-switch input:checked + label {
    background: #28a745;
    }

    .card.permission-card {
    background: linear-gradient(165deg, #9cbbd5ff 100%, #bed3d3ff 100%); /* blue gradient */
    color: #0f0d0dff; /* white text */
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .card.permission-card h6 {
    font-weight: bold;
    margin-bottom: 15px;
    color: #080707ff;
    }

  </style>
</head>
<body>
  <div class="container">
    <div style="background:#433838; border-radius:6px; box-shadow:0 1px 4px rgba(0,0,0,0.07); padding:6px 8px; margin-bottom:8px;">
        <div class="row mb-1 align-items-center no-gutters">
            <!-- Role Select (6 columns) -->
            <div class="col-md-6">
                <form id="rolselect" method="POST" action="<?php echo base_url() ?>menuAccess" class="d-flex gap-2 mb-0">
                    <select id="firstSelect" name="roleId" class="form-control selectpicker" data-live-search="true" required>
                        <option value="">Select a Role</option>
                        
                                <option value="<?php echo $by_role; ?>" selected>
                                    Selected Role: <?php echo $by_role ?>
                                </option>
                                <?php
                           
                        foreach ($roleInfo as $rl) {
                            ?>
                            <option value="<?php echo $rl->roleId ?>">
                                <?php echo $rl->role ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
            </div>

            <!-- Search Button (3 columns) -->
            <div class="col-md-3">
                <div class="input-group">

                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Search</button>
                </div>

            </div>
            </form>
            <!-- <form action="<?php //echo base_url(); ?>updateAccess" method="POST" id="byFilterMethod" enctype="multipart/form-data"> -->
            <!-- <div class="col-md-2 text-center">
                <div class="input-group">

                    <button type="submit" class="btn w-100 d-flex align-items-center" 
                            style="background:#eaf9ef; color:#268d41; border-radius:6px; padding:0.6em 1em; font-weight:400; font-size:1.13em; border:none;">
                        <i class="fas fa-save" style="margin-right:0.5em; color:#268d41;"></i>
                        <span style="color:#268d41;">Save</span>
                    </button>
                </div>

            </div> -->

        </div>


        <div class="d-flex flex-wrap gap-2" style="margin-top:12px;">
                <button type="button" class="btn btn-outline-primary btn-sm grant-all">Grant All</button>
                <button type="button" class="btn btn-outline-danger btn-sm revoke-all">Revoke All</button>
                <button type="button" class="btn btn-outline-primary btn-sm enable-read">Enable all Read</button>
                <button type="button" class="btn btn-outline-danger btn-sm disable-read">Disable all Read</button>
                <button type="button" class="btn btn-outline-primary btn-sm enable-add">Enable all Add</button>
                <button type="button" class="btn btn-outline-danger btn-sm disable-add">Disable all Add</button>
                <button type="button" class="btn btn-outline-primary btn-sm enable-edit">Enable all Edit</button>
                <button type="button" class="btn btn-outline-danger btn-sm disable-edit">Disable all Edit</button>
                <button type="button" class="btn btn-outline-primary btn-sm enable-delete">Enable all Delete</button>
                <button type="button" class="btn btn-outline-danger btn-sm disable-delete">Disable all Delete</button>
                <button type="button" class="btn btn-outline-primary btn-sm enable-approve">Enable all Approve/Reject</button>
                <button type="button" class="btn btn-outline-danger btn-sm disable-approve">Disable all Approve/Reject</button>
                <button type="button" class="btn btn-outline-primary btn-sm enable-dashboard">Enable all Dashboard</button>
                <button type="button" class="btn btn-outline-danger btn-sm disable-dashboard">Disable all Dashboard</button>
                <button type="button" class="btn btn-outline-primary btn-sm enable-report">Enable all Report</button>
                <button type="button" class="btn btn-outline-danger btn-sm disable-report">Disable all Report</button>
            </div>
    </div>



    <!-- Permission Cards Row -->
      <!-- Card: Dashboard -->
<form action="<?= base_url('updateAccess'); ?>" method="POST" id="byFilterMethod">

<input type="hidden" name="role_id" value="<?= $rol->roleId; ?>">

<!-- TOP SAVE BUTTON -->
<div class="d-flex justify-content-center my-3">
    <button type="submit"
        class="btn d-flex align-items-center px-4 py-2"
        style="background:#2fbf71;color:#fff;font-size:1.1rem;font-weight:600;border-radius:8px;box-shadow:0 4px 10px rgba(0,0,0,0.2);">
        <i class="fas fa-save me-2"></i> Save
    </button>
</div>

<?php if (!empty($AllModuleInfo)) { ?>
<div class="row">
<?php foreach ($AllModuleInfo as $menu) { 
    $AccessInfo = $staff_model->getModuleAccessInfo($menu->row_id, $rol->roleId);
?>
    <div class="col-md-4">
        <div class="card permission-card p-3 mb-2">
            <h6>
                <?= !empty($menu->module_name) ? htmlspecialchars($menu->module_name) . ' / ' : '' ?>

                <?= preg_replace('/\s+/', ' ', trim(strip_tags(str_replace('&nbsp;', ' ', $menu->menu_name)))) ?>
            </h6>

            <!-- ALL toggle -->
            <div class="permission-group all-toggle-row">
                <span>All</span>
                <div class="toggle-switch">
                    <input type="checkbox"
                        id="all-<?= $menu->row_id ?>-<?= $rol->roleId ?>"
                        class="all-toggle-master">
                    <label for="all-<?= $menu->row_id ?>-<?= $rol->roleId ?>"></label>
                </div>
            </div>

            <!-- Only this hidden input remains -->
            <input type="hidden" name="module_id[]" value="<?= $menu->row_id; ?>">

            <!-- READ -->
            <div class="permission-group">
                <span>Read</span>
                <div class="toggle-switch">
                    <input type="checkbox"
                        id="view-<?= $menu->row_id ?>-<?= $rol->roleId ?>" class="perm-toggle"
                        name="can_view[<?= $menu->row_id ?>][<?= $rol->roleId ?>]"
                        value="1" <?= !empty($AccessInfo->can_view) ? 'checked' : '' ?>>
                    <label for="view-<?= $menu->row_id ?>-<?= $rol->roleId ?>"></label>
                </div>
            </div>

            <!-- ADD -->
            <div class="permission-group">
                <span>Add</span>
                <div class="toggle-switch">
                    <input type="checkbox"
                        id="add-<?= $menu->row_id ?>-<?= $rol->roleId ?>" class="perm-toggle"
                        name="can_add[<?= $menu->row_id ?>][<?= $rol->roleId ?>]"
                        value="1" <?= !empty($AccessInfo->can_add) ? 'checked' : '' ?>>
                    <label for="add-<?= $menu->row_id ?>-<?= $rol->roleId ?>"></label>
                </div>
            </div>

            <!-- EDIT -->
            <div class="permission-group">
                <span>Edit</span>
                <div class="toggle-switch">
                    <input type="checkbox"
                        id="edit-<?= $menu->row_id ?>-<?= $rol->roleId ?>" class="perm-toggle"
                        name="can_edit[<?= $menu->row_id ?>][<?= $rol->roleId ?>]"
                        value="1" <?= !empty($AccessInfo->can_edit) ? 'checked' : '' ?>>
                    <label for="edit-<?= $menu->row_id ?>-<?= $rol->roleId ?>"></label>
                </div>
            </div>

            <!-- DELETE -->
            <div class="permission-group">
                <span>Delete</span>
                <div class="toggle-switch">
                    <input type="checkbox"
                        id="delete-<?= $menu->row_id ?>-<?= $rol->roleId ?>" class="perm-toggle"
                        name="can_delete[<?= $menu->row_id ?>][<?= $rol->roleId ?>]"
                        value="1" <?= !empty($AccessInfo->can_delete) ? 'checked' : '' ?>>
                    <label for="delete-<?= $menu->row_id ?>-<?= $rol->roleId ?>"></label>
                </div>
            </div>

            <!-- APPROVE -->
            <div class="permission-group">
                <span>Approve / Reject</span>
                <div class="toggle-switch">
                    <input type="checkbox"
                        id="approve-<?= $menu->row_id ?>-<?= $rol->roleId ?>" class="perm-toggle"
                        name="can_approve[<?= $menu->row_id ?>][<?= $rol->roleId ?>]"
                        value="1" <?= !empty($AccessInfo->can_approve) ? 'checked' : '' ?>>
                    <label for="approve-<?= $menu->row_id ?>-<?= $rol->roleId ?>"></label>
                </div>
            </div>

            <!-- SUPER -->
            <div class="permission-group">
                <span>Super Access</span>
                <div class="toggle-switch">
                    <input type="checkbox"
                        id="super-<?= $menu->row_id ?>-<?= $rol->roleId ?>" class="perm-toggle"
                        name="super_access[<?= $menu->row_id ?>][<?= $rol->roleId ?>]"
                        value="1" <?= !empty($AccessInfo->super_access) ? 'checked' : '' ?>>
                    <label for="super-<?= $menu->row_id ?>-<?= $rol->roleId ?>"></label>
                </div>
            </div>

            <div class="permission-group">
                <span>Dashboard</span>
                <div class="toggle-switch">
                    <input type="checkbox"
                        id="dashboard-<?= $menu->row_id ?>-<?= $rol->roleId ?>" class="perm-toggle"
                        name="dashboard[<?= $menu->row_id ?>][<?= $rol->roleId ?>]"
                        value="1" <?= !empty($AccessInfo->dashboard) ? 'checked' : '' ?>>
                    <label for="dashboard-<?= $menu->row_id ?>-<?= $rol->roleId ?>"></label>
                </div>
            </div>

            <div class="permission-group">
                <span>Report</span>
                <div class="toggle-switch">
                    <input type="checkbox"
                        id="report-<?= $menu->row_id ?>-<?= $rol->roleId ?>" class="perm-toggle"
                        name="report[<?= $menu->row_id ?>][<?= $rol->roleId ?>]"
                        value="1" <?= !empty($AccessInfo->report) ? 'checked' : '' ?>>
                    <label for="report-<?= $menu->row_id ?>-<?= $rol->roleId ?>"></label>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
</div>

<!-- BOTTOM SAVE BUTTON -->
<div class="d-flex justify-content-center my-4">
    <button type="submit"
        class="btn d-flex align-items-center px-4 py-2"
        style="background:#2fbf71;color:#fff;font-size:1.1rem;font-weight:600;border-radius:8px;box-shadow:0 4px 10px rgba(0,0,0,0.2);">
        <i class="fas fa-save me-2"></i> Save
    </button>
</div>
<?php } ?>

</form>
<br>
<br>
<br>



      
    </div>
  </div>



<script src="<?php echo base_url(); ?>assets/js/student.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    // alert(baseURL);

    // $("form").submit(()=>{
    //     // alert('hi');
    //     showLoader();
    // });
    // var loader = '<img height="70" src="<?php //echo base_url(); ?>/assets/images/loader.gif"/>';
    // jQuery('ul.pagination li a').click(function (e) {
    //     e.preventDefault();            
    //     var link = jQuery(this).get(0).href;            
    //     var value = link.substring(link.lastIndexOf('/') + 1);
    //     jQuery("#byFilterMethod").attr("action", baseURL + "menuAccess/" + value);
    //     jQuery("#byFilterMethod").submit();
    // });

    // jQuery('.datepicker').datepicker({
    //     autoclose: true,
    //     orientation: "bottom",
    //     format: "dd-mm-yyyy"

    // });

    // //checkbox select
    // $("#role_id").change(function() {
    //     var role_id = $("#role_id").val();
    //     $('#roleId').val(role_id);
    // });
    // $("#dept_id").change(function() {
    //     var dept_id = $("#dept_id").val();
    //     $('#deptId').val(dept_id);
    // });
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ── Helper: sync a single card's master toggle ──
    function syncMaster(card) {
        var master = card.querySelector('.all-toggle-master');
        var perms  = card.querySelectorAll('.perm-toggle');
        if (!master || perms.length === 0) return;
        master.checked = Array.from(perms).every(function(c) { return c.checked; });
    }

    // ── Helper: sync ALL cards' master toggles ──
    function syncAllMasters() {
        document.querySelectorAll('.permission-card').forEach(function(card) {
            syncMaster(card);
        });
    }

    // ── Per-card All toggle logic ──
    document.querySelectorAll('.permission-card').forEach(function(card) {
        var master = card.querySelector('.all-toggle-master');
        var perms  = card.querySelectorAll('.perm-toggle');
        if (!master) return;

        // Master → check/uncheck all in this card
        master.addEventListener('change', function() {
            perms.forEach(function(cb) { cb.checked = master.checked; });
        });

        // Individual toggle → sync master
        perms.forEach(function(cb) {
            cb.addEventListener('change', function() {
                syncMaster(card);
            });
        });

        // ✅ On page load — reflect saved DB values
        syncMaster(card);
    });

    // ── Global bulk buttons — sync masters after each action ──
    document.querySelector('.grant-all').onclick = function() {
        document.querySelectorAll('.permission-card input[type="checkbox"]').forEach(cb => cb.checked = true);
    };
    document.querySelector('.revoke-all').onclick = function() {
        document.querySelectorAll('.permission-card input[type="checkbox"]').forEach(cb => cb.checked = false);
    };
    document.querySelector('.enable-read').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="view-"]').forEach(cb => cb.checked = true);
        syncAllMasters();
    };
    document.querySelector('.disable-read').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="view-"]').forEach(cb => cb.checked = false);
        syncAllMasters();
    };
    document.querySelector('.enable-add').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="add-"]').forEach(cb => cb.checked = true);
        syncAllMasters();
    };
    document.querySelector('.disable-add').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="add-"]').forEach(cb => cb.checked = false);
        syncAllMasters();
    };
    document.querySelector('.enable-edit').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="edit-"]').forEach(cb => cb.checked = true);
        syncAllMasters();
    };
    document.querySelector('.disable-edit').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="edit-"]').forEach(cb => cb.checked = false);
        syncAllMasters();
    };
    document.querySelector('.enable-delete').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="delete-"]').forEach(cb => cb.checked = true);
        syncAllMasters();
    };
    document.querySelector('.disable-delete').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="delete-"]').forEach(cb => cb.checked = false);
        syncAllMasters();
    };
    document.querySelector('.enable-approve').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="approve-"]').forEach(cb => cb.checked = true);
        syncAllMasters();
    };
    document.querySelector('.disable-approve').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="approve-"]').forEach(cb => cb.checked = false);
        syncAllMasters();
    };
    document.querySelector('.enable-dashboard').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="dashboard-"]').forEach(cb => cb.checked = true);
        syncAllMasters();
    };
    document.querySelector('.disable-dashboard').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="dashboard-"]').forEach(cb => cb.checked = false);
        syncAllMasters();
    };
    document.querySelector('.enable-report').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="report-"]').forEach(cb => cb.checked = true);
        syncAllMasters();
    };
    document.querySelector('.disable-report').onclick = function() {
        document.querySelectorAll('.permission-card input[id^="report-"]').forEach(cb => cb.checked = false);
        syncAllMasters();
    };

});
</script>
