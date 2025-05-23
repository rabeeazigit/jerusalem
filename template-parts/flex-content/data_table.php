<?php
$title = $args["title"] ?? null;
$table_data = $args["table_data"] ?? null;
$columns_to_render = 0;
?>

<?php if ($title) : ?>
    <div class="fs-5 fw-bold mb-3">
        <?= $title; ?>
    </div>
<?php endif; ?>

<?php if ($table_data && is_array($table_data) && !empty($table_data)) : ?>
    <div class="data_table_wrapper overflow-x-auto">
        <table class="table table-bordered mb-4" style="border-color: #b1a899">
            <thead>
                <tr>
                    <?php foreach ($table_data[0] as $table_header) : ?>
                        <?php if (!empty($table_header)) : $columns_to_render++ ?>
                            <th class="pb-3 p-2 pb-md-5 p-md-3" style="background-color: #b1a89980">
                                <?= $table_header; ?>
                            </th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($table_data as $i => $table_data) : ?>
                    <?php if ($i == 0) continue; ?>
                    <tr>
                        <?php if ($columns_to_render >= 1) : ?>
                            <td class="pb-3 p-2 pb-md-5 p-md-3">
                                <?= $table_data["column_1"]; ?>
                            </td>
                        <?php endif; ?>

                        <?php if ($columns_to_render >= 2) : ?>
                            <td class="pb-3 p-2 pb-md-5 p-md-3">
                                <?= $table_data["column_2"]; ?>
                            </td>
                        <?php endif; ?>

                        <?php if ($columns_to_render >= 3) : ?>
                            <td class="pb-3 p-2 pb-md-5 p-md-3">
                                <?= $table_data["column_3"]; ?>
                            </td>
                        <?php endif; ?>

                        <?php if ($columns_to_render >= 4) : ?>
                            <td class="pb-3 p-2 pb-md-5 p-md-3">
                                <?= $table_data["column_4"]; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>