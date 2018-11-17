<?php $checked = isset($criteria[$field][$item['label']]) ? 'checked' : '';
?>
<label style="width: 100%;">
    <span style="float: right; color: darkgrey;"><?= htmlspecialchars($item['value']) ?> </span>
    <input class="filter-option-input" type="checkbox" name="criteria[<?= htmlspecialchars($field) ?>][<?= htmlspecialchars($item['label']) ?>]" value="1" <?= $checked ?>> <?= htmlspecialchars($item['label']) ?>
</label>

