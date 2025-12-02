<div class="main-contacts-list" id="mainContactList" style="height:auto !important">
    <?php if (!empty($results)) : ?>
        <?php foreach ($results as $key => $result) : ?>
            <div data-id="<?= esc($result->student_id); ?>" data-name="<?= esc($result->people_number); ?>:<?= esc($result->name); ?> <?= $result->current_class ? $result->current_class->class_short_name:''; ?> <?= $result->current_class && $result->current_class->stream_name ? '('. $result->current_class->stream_name. ')': ''; ?>" class="main-contact-item student-report-card-generation" style="padding: 5px 30px; padding-left: 0px;">
                <div class="main-contact-body" style="margin-left: 5px;">
                    <h6><?= esc($result->people_number); ?>:<?= esc($result->name); ?> <?= $result->current_class ? $result->current_class->class_short_name:''; ?> <?= $result->current_class && $result->current_class->stream_name ? '('. $result->current_class->stream_name. ')': ''; ?> </h6>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="main-contact-item" style="padding: 5px 30px; padding-left: 0px;">
            <div class="main-contact-body" style="margin-left: 5px;">
                <h6>No results found</h6>
            </div>
        </div>
    <?php endif; ?>
</div>