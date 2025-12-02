<div class="table-responsive  export-table mt-4">
    <table id="view-student-report-card-table" class="table table-bordered text-nowrap key-buttons border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0" rowspan="2">Student Name</th>
                <th class="border-bottom-0" rowspan="2">Student No</th>
                <?php if (!empty($exams)) : ?>
                    <?php foreach ($exams as $key => $exam) : ?> 
                        <th class="border-bottom-0" colspan="<?= count($subjects) + 1 ?>" style="text-align: center; font-weight: bold; border: 1.5px solid;"><?= esc($exam['short_name']); ?></th>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($grading_type_key == 'grading') {?>
                    <th class="border-bottom-0" rowspan="2">Total</th>
                <?php } ?>
                <th class="border-bottom-0" rowspan="2">Teacher Comment</th>
                <th class="border-bottom-0" rowspan="2">Head Teacher Comment</th>
                <th class="border-bottom-0" rowspan="2"><?= $studentId != 0 ? 'Action':'<label class=""><input name="" id="select-all" style="margin-top:.5em; margin-bottom:0em" type="checkbox" required></label>' ?> </th>
            </tr>
            
            <tr>
                <?php foreach ($exams as $exam): ?>
                    <?php foreach ($subjects as $key => $subject): ?>
                        <th style="<?= $key == 0? 'border-left: 1.5px solid;':'' ?>" ><?= $subject['short_name'] ?></th>
                    <?php endforeach; ?>
                    <th style="border-right: 1.5px solid;"><?= $grading_type_key == 'grading' ? 'Grade' : 'Total' ?> </th>
                <?php endforeach; ?> 
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)) : ?>
                <?php foreach ($students as $key => $student) : ?>
                    <tr>
                        <td><?= esc($student->name); ?></td>
                        <td><?= esc($student->people_number); ?></td>

                        <?php foreach ($exams as $exam): ?>
                            <?php foreach ($subjects as $key => $subject): ?>
                                <td style="<?= $key == 0 ? 'border-left: 1.5px solid;':'' ?>" ><?= isset($student->scores['marks'][$exam['id']]['subjects'][$subject['id']]['final_mark']) ? htmlspecialchars($student->scores['marks'][$exam['id']]['subjects'][$subject['id']]['final_mark']) : '-' ?></td>
                            <?php endforeach; ?>
                            <td style="border-right: 1.5px solid;"><?= $grading_type_key != 'grading' ? htmlspecialchars($student->scores['marks'][$exam['id']]['total'] ?? '-') :htmlspecialchars($student->scores['marks'][$exam['id']]['total_agg'] ?? '-') ?></td>
                        <?php endforeach; ?>
                        <?php if ($grading_type_key == 'grading') {?>
                            <td><?= htmlspecialchars($student->scores['grade']['total_agg'] ?? '-') ?></td>
                        <?php } ?>
                        <td> <input type="text" name="teacher_comment" value="<?= htmlspecialchars($student->scores['grade']['teacher_comment'] ?? '') ?>" class="form-control form-control-sm" id="" required> </td>
                        <td><input type="text" name="hm_comment" value="<?= htmlspecialchars($student->scores['grade']['hm_comment'] ?? '') ?>" class="form-control form-control-sm" id="" required></td>

                        <td class="call-action">
                            <?php if ($studentId == 0): ?>
                                <label>
                                    <input class="select-student" data-studentid="<?= esc($student->student_id); ?>" style="margin-top:.5em; margin-bottom:0em" type="checkbox">
                                </label>
                            <?php else: ?>
                                <button type="button" data-studentid="<?= esc($student->student_id); ?>" class="btn btn-primary btn-sm print-student-report-card-btn">Print</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if ($studentId == 0): ?>
    <div class="modal-footer">
        <button class="btn ripple btn-primary btn-sm" style="display:none" id="bulk-print-class-report-cards-btn" type="button">Print</button>
    </div>
<?php endif; ?>