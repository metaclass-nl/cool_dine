<div>
    <div class="search_text mb-2 ">
        <input class="form-control" name="search_text" id="search_text" value="<?= htmlspecialchars($search_text) ?>" placeholder="Zoek naar restaurant .." />
    </div>
    <div class="distance mb-2 form-group">
        <label class="control-label required" for="coordinates">Plaats</label>
        <select name="coordinates" class="form-control">
            <option value="">&nbsp;</option>
            <?php
            foreach ($towns as $town) {
                include('town-option.php');
            }
            ?>
        </select>
        <label class="control-label required" for="distance">Afstand</label>
        <select name="distance" class="form-control">
            <option value="">&nbsp;</option>
            <?php
            foreach ($distances as $option) {
                include('distance-option.php');
            }
            ?>
        </select>
    </div>
</div>
