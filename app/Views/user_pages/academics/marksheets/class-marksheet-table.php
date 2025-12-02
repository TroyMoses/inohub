<?php 
 function filterMarks($marks, $marksKey) {
    if ($marks && isset($marks[$marksKey])) {
        return $marks[$marksKey];
    }

    return null;
 }
?>
<input type="hidden" value="<?= esc($subjectId); ?>" id="term-student-subjects-subject-id">
<div class="table-responsive  export-table">
    <table id="view-class-streams-marksheet-table" class="table table-bordered text-nowrap key-buttons border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">Student No</th>
                <th class="border-bottom-0">Student Name</th>
                <?php if (!empty($exams)) : ?>
                    <?php foreach ($exams as $key => $exam) : ?>
                        <th class="border-bottom-0"><?= esc($exam['short_name']) . '(/'.$exam['classes'][0]['total_mark'].')'; ?></th>
                    <?php endforeach; ?>
                <?php endif; ?> 
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)) : ?>
            <?php foreach ($students as $key => $student) : ?>
            <tr>
                <td><?= esc($student->people_number); ?></td>
                <td><?= esc($student->name); ?></td>
                <?php if (!empty($exams)) : ?>
                    <?php foreach ($exams as $key => $exam) : ?>
                        <td>  <input type="text" value="<?= esc(filterMarks($student->marks, "{$student->student_id}_{$subjectId}_{$termId}_{$exam['exam_id']}" )); ?>" class="form-control form-control-sm" data-studentid="<?= esc($student->student_id); ?>" data-id="<?= esc($exam['exam_id']); ?>" autocomplete="off" name="student-subject-exam-mrk" required> </td>
                    <?php endforeach; ?>
                <?php endif; ?> 
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>