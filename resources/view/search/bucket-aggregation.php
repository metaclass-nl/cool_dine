    <div class="card mt-3">
        <div class="card-header">
            <?= htmlspecialchars($option_fields[$field]) ?>
        </div>
        <div class="card-body">
            <div class="checkbox">
                <?php
                    foreach ($facet as $item) {
                        include 'bucket-aggregation-item.php';
                    }
                ?>
            </div>
        </div>
    </div>
