<?php if(isset($exam)): ?>
    <div class="main">
        <table border="0" cellpadding="0" cellspacing="1" style="width:100%">
            <tr>
                <?php foreach($exam[0] as $field => $value): ?>
                <th>
                    <?php echo $field; ?>
                </th>
                <?php endforeach; ?>
            </tr>
            <?php foreach($exam as $row): ?>
            <tr>
                <?php foreach($row as $value): ?>
                <td>
                    <?php echo $value?>
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif;?>

