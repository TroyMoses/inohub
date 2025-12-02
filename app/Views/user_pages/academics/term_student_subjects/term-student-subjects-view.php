
<div class="row">
    <div class="col-lg-4 col-xl-3">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Streams</div>
            </div>
            <div class="main-content-left main-content-left-mail card-body pt-0">
                <div class="main-settings-menu">
                    <nav class="nav main-nav-column">
                        <?php if (!empty($streams)) : ?>
                            <?php foreach ($streams as $key => $_stream) : ?>
                                <a id="view-student-subjects-tb-<?= esc($_stream->id); ?>" class="nav-link thumb <?php echo $stream ? $stream->id == $_stream->id ? 'active':'' :''?> mb-2 view-student-subjects-tb"
                                    href="javascript:view_student_subjects(<?= esc($_stream->id); ?>);;"><i class="fe fe-home"></i> Stream - <?= esc($_stream->name); ?> </a>
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
                <div class="card-title">Student Subjects</div>                
                <div id="term-student-subjects-table-container">
                    <?= view('user_pages/academics/term_student_subjects/term-student-subjects-table') ?>
                </div>

            </div>
        </div>
    </div>
</div>