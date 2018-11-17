<?php
    $selected = $coordinates == ((string) $town->getCoordinates()) ? 'selected="selected"' : '';
?>
<option value="<?= $town->getCoordinates() ?>" <?= $selected ?>><?= $town->getName() ?></option>
