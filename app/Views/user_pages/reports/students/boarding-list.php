<?php helper('h_date'); ?>
<div class="card custom-card overflow-hidden">
    <div class="card-body">
        <div class="table-responsive  export-table">
            <table id="school-global-ajax-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0">Name</th>
                        <th class="border-bottom-0">Student No</th>
                        <th class="border-bottom-0">Admission No</th>
                        <th class="border-bottom-0">Gender</th>
                        <th class="border-bottom-0">DOB</th> 
                        <th class="border-bottom-0">Class</th>
                        <th class="border-bottom-0">Dormitry</th>
                        <th class="border-bottom-0">Bed No</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php if (!empty($students)) : ?>
                    <?php foreach ($students as $key => $student) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= esc($student->name); ?></td>
                        <td><?= esc($student->people_number); ?></td>
                        <td><?= esc($student->admission_no); ?></td>
                        <td><?= esc($student->gender); ?></td>
                        <td><?= esc(h_format_date_display($student->dob)); ?></td>
                        <td><?= esc($student->class_name) . ($student->class_short_name ?  ' ('. $student->class_short_name . ')' :''); ?></td>
                        <td><?= esc($student->dormitry_name); ?></td>
                        <td><?= esc($student->bed_number); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>