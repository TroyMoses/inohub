<form id="new-fees-structure-registration-form" method="post" action="" enctype="multipart/form-data">
    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="form-group">
                <label class="form-label" for="gender">Fees Type:<span class="tx-danger">*</span></label>
                <select name="gender" class="form-control form-select form-control-sm" id="fees-structure-class-class-id" data-bs-placeholder="Select Gender" required>
                    <option value="">--- select ---</option>
                    <?php if (!empty($fees_types)) : ?>
                        <?php foreach ($fees_types as $key => $fees_type) : ?>
                            <option value="<?= esc($fees_type->id); ?>"><?= esc($fees_type->name); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <table class="table table-bordered text-nowrap key-buttons border-bottom">
                <tbody>
                    <?php if (!empty($classes)) : ?>
                        <?php foreach ($classes as $key => $_class) : ?>
                            <tr>
                                <td><?= esc($_class->name); ?> <?= $_class->short_name ? '('. esc($_class->short_name). ')':''; ?></td>
                                <td><input type="number" data-classid="<?= esc($_class->id); ?>" class="form-control form-control-sm" name="fees-structure-class-amount" autocomplete="off" value="0" required></td> 
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>