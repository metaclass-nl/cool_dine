<div class="card mt-3">
    <div class="card-header">
        <?php $value = isset($criteria[$field]) ? $criteria[$field] : '';
              $min_max = isset($stats[$field])
                  ? ' '. $stats[$field]['min']. ' - '. $stats[$field]['max']
                  : '';
        ?>
        <?= $range['label'] ?> (€<?= $min_max ?>)
    </div>
    <div class="card-body">
        <input class="form-control filter-range-input" name="criteria[<?= $field ?>]" value="<?= htmlspecialchars($value) ?>" placeholder="<?= $range['placeholder'] ?>">
    </div>
</div>
