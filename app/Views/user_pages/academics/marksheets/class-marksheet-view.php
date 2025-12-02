<div class="row">
    <div class="col-lg-4 col-xl-3">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Subjects</div>
            </div>
            <div class="main-content-left main-content-left-mail card-body pt-0">
                <div class="main-settings-menu">
                    <nav class="nav main-nav-column">
                        <?php if (!empty($subjects)) : ?>
                        <?php foreach ($subjects as $key => $_subject) : ?>
                        <a id="view-class-streams-marksheet-tb-<?= esc($_subject->subject_id); ?>" class="nav-link thumb <?php echo $subject ? $subject->subject_id == $_subject->subject_id ? 'active':'' :''?> mb-2 view-class-streams-marksheet-tb"
                            href="javascript:view_class_streams_marksheet(<?= esc($_subject->subject_id); ?>);;"><i class="fe fe-home"></i> <?= esc($_subject->name); ?> </a>
                        <?php endforeach; ?> 
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xl-9">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Students</div>
                <div id="view-class-streams-marksheet-page-view-td">
                    <?= view('user_pages/academics/marksheets/class-marksheet-table') ?>
                </div>
            </div>
        </div>
    </div>
</div>