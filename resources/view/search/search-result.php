        <div class="card panel-default mb-3" style="min-width: 28%; max-width: 28%">
            <img class="card-img-top p-3" src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" />
            <div class="card-body">
                <h4 class="card-title" v-text="<?= htmlspecialchars($item['name']) ?>" ><?= htmlspecialchars($item['name']) ?></h4>
                <p>&euro; <?= htmlspecialchars($item['avgMenuPrice']) ?></p>
                <p>
                    <?= htmlspecialchars($item['description']) ?>
                </p>
            </div>
        </div>
