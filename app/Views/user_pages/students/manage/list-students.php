<?php 
    helper('h_date'); 
    $accessRightsKeys = h_session('access_rights_keys') ? h_session('access_rights_keys') : [];
?>
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
                        <th class="border-bottom-0">Class</th>
                        <th class="border-bottom-0">Gender</th>
                        <th class="border-bottom-0">DOB</th>
                        <th class="border-bottom-0">Session Date</th>
                        <th class="border-bottom-0 call-action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)): ?>
                    <?php foreach ($students as $key => $student) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= esc($student->name); ?></td>
                        <td><?= esc($student->people_number); ?></td>
                        <td><?= esc($student->admission_no); ?></td>
                        <td><?= $student->class_name . ($student->stream_name ? ' ('. $student->stream_name .')' :''); ?></td>
                        <td><?= esc($student->gender); ?></td>
                        <td><?= $student->dob ? esc(h_format_date_display($student->dob)):''; ?></td>
                        <td><?= esc(h_format_date_display($student->date_added)); ?></td>
                        <td class="call-action">
                            <button data-id="<?= h_encrypt_decrypt($student->id); ?>" type="button"
                                class="btn btn-primary btn-sm view-student-details">View</button>

                            <?php if(in_array('DELETE_STUDENT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
                                <button data-id="<?= h_encrypt_decrypt($student->id); ?>" type="button"
                                    class="btn btn-danger btn-sm delete-student-details">Delete</button>
                            <?php endif ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>