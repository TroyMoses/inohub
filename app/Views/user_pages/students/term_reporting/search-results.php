<?php if (!empty($results)) : ?>
    <table class="table table-bordered text-nowrap key-buttons border-bottom search-table">
        <thead>
            <tr>
                <th class="border-bottom-0">Name</th>
                <th class="border-bottom-0">Student No</th>
                <th class="border-bottom-0">Admission No</th>
                <th class="border-bottom-0">Class</th>
                <th class="border-bottom-0">Gender</th>
                <th class="border-bottom-0 call-action">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $key => $result) : ?>
                <tr>
                    <td><?= esc($result->name); ?></td>
                    <td><?= esc($result->people_number); ?></td>
                    <td><?= esc($result->admission_no); ?></td>
                    <td><?= $result->current_class ? ( $result->current_class->class_name . ($result->current_class->class_short_name ? '('. esc($result->current_class->class_short_name). ')':'') ) : ( $result->class_name . ($result->class_short_name ? '('. esc($result->class_short_name). ')':'') ); ?> <?= $result->current_class && $result->current_class->stream_name ? (' - '. $result->current_class->stream_name):($result->stream_name ? ' - '. $result->stream_name :''); ?> </td> 
                    <td><?= esc($result->gender); ?></td>
                    <td class="call-action"><button type="button" data-id="<?= h_encrypt_decrypt(esc($result->id)); ?>" class="btn btn-primary btn-sm view-reporting-student-details">view</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table> 
<?php else: ?>
    <p>No Results Found</p>
<?php endif; ?>