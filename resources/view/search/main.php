<!-- section('content') -->
<form name="searchform" >
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php include 'search-bar.php' ?>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <div>
                Resultaten: <?= htmlspecialchars($meta['total_hits']) ?>  | Totaal aantal: <?= htmlspecialchars($meta['total_all']) ?>
                <?php
                    foreach ($range_fields as $field => $range) {
                        if ($range_fields)
                        include 'range-aggregation.php';
                    }

                    foreach ($facets as $field => $facet) {
                        include 'bucket-aggregation.php';
                    }
                ?>
                <noscript>
                    <input type="submit" name="apply" value="Toepassen">
                </noscript>
            </div>
        </div>
        <div class="col-md-8">
            <div>
                <div class="card-deck">
                    <?php
                        foreach ($data as $item) {
                            include 'search-result.php';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!-- endsection -->