<div class="card custom-card overflow-hidden">
    <div class="card-body">
        <div class="table-responsive  export-table">
            <table id="school-global-ajax-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0">Name</th>
                        <th class="border-bottom-0">Staff No</th>
                        <th class="border-bottom-0">Gender</th>
                        <th class="border-bottom-0">Class Subject</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php if (!empty($teachers)) : ?>
                    <?php foreach ($teachers as $key => $teacher) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= esc($teacher->name); ?></td>
                        <td><?= esc($teacher->people_number); ?></td>
                        <td><?= esc($teacher->gender); ?></td>
                        <td>
                            <?php foreach ($teacher->classes as $key => $class) : ?>
                                <span class="badge bg-primary me-1"><?= $class['short_name'] . (!empty($class['subjects']) ? ' - '. implode(', ', $class['subjects']) :''  ) ?> </span>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>