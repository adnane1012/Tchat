<?php $ok = true; ?>
<table>
    <tr>
        <th>version PHP</th>
        <td>
            <?php if (phpversion() < 5.4) : ?>
                <?php echo 'KO' ?>
                <?php $ok=fales ?>
            <?php else : ?>
                <?php echo 'OK'; ?>
            <?php endif ?>
        </td>
    </tr>
</table>