<?php 
//table section :

$ElectricTable = $args[0];
$tabletitle = $args[1];

?>

<div class="table-responsive ">
    <table class="table table-bordered table-hover caption-top fon infotable">
        <caption><?= esc_html($tabletitle); ?></caption>
        <thead class="table-light">
            <tr>
                <th class="text-center">פרטים על העסקה</th>
                <th class="text-center">פרטים על היזם</th>
                <th class="text-center">זכויות בעלי הדירות ודיור ציבורי</th>
                <th class="text-center">מידע נוסף</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ElectricTable as $cols) : ?>
                <tr>
                    <td>
                        <?= esc_html($cols['area_table_details']); ?>
                    </td>
                    <td><?= esc_html($cols['area_table_details_entrepreneur']); ?></td>
                    <td><?= esc_html($cols['area_table_rights']); ?></td>
                    <td><?= esc_html($cols['area_table_more_details']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

