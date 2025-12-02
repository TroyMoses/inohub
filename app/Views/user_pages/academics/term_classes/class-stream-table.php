<div class="table-responsive  export-table">
    <table id="view-class-streams-table" class="table table-bordered text-nowrap key-buttons border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Stream Name</th>
                <th class="border-bottom-0">Short Name</th>
                <th class="border-bottom-0 call-action">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($streams)) : ?>
            <?php foreach ($streams as $key => $stream) : ?>
            <tr>
                <td><?= $key + 1; ?></td>
                <td><?= esc($stream->name); ?></td>
                <td><?= esc($stream->short_name); ?></td>
                <td class="call-action"><button type="button" class="btn btn-primary btn-sm">--- Action ---</button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>