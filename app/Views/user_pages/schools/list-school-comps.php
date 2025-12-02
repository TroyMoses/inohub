<div class="divider">GENERAL FEATURES </div>

<ul id="tree-school-group-comp">
    <?= h_generateTreeView($componentTree, $system_components); ?>
</ul>

<input type="hidden" class="form-control form-control-sm" autocomplete="off" id="school-group-access-checked" required value="<?= $system_components ? (is_string($system_components) ? json_encode(array_map('intval', json_decode($system_components))) : json_encode(array_map('intval', $system_components))) : []; ?>">
<input type="hidden" class="form-control form-control-sm" autocomplete="off" id="school-group-access-unchecked" required>

<div class="modal-footer">
    <button class="btn ripple btn-primary" id="btn-save-sch-group-components" type="button">Save Changes</button>
</div>
<!-- Internal Treeview js -->
<script src="<?php echo base_url('assets/plugins/treeview/treeview.js'); ?>"></script>

