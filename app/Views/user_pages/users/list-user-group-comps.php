<ul id="tree-user-group-comp">
    <?= h_generateTreeView($componentTree, $group && $group->system_components !== null? json_decode($group->system_components):[]); ?>
</ul>

<input type="hidden" class="form-control form-control-sm" autocomplete="off" id="user-group-access-checked" required value="<?= $group && $group->system_components !== null ? (is_string($group->system_components) ? json_encode(array_map('intval', json_decode($group->system_components))) : json_encode(array_map('intval', $group->system_components))) : []; ?>">
<input type="hidden" class="form-control form-control-sm" autocomplete="off" id="user-group-access-unchecked" required>
<input type="hidden" class="form-control form-control-sm" autocomplete="off" id="edit-user-group-access-id" required>

<!-- Internal Treeview js -->
<script src="<?php echo base_url('assets/plugins/treeview/treeview.js'); ?>"></script>

