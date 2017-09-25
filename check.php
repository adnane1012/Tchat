<?php
$ok = true;
?>
<table>
    <tr>
        <th>version PHP</th>
        <td><?php if (phpversion() < 5.4){echo 'KO'; $ok=fales;} else {echo 'OK';} ?></td>
    </tr>
</table>