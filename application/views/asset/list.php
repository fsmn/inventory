<?php
defined('BASEPATH') or exit ('No direct script access allowed');
$header = "Assets";
if (isset ($po)) {
    $header = sprintf("<a href='%s' title='View the related asset for these assets'>%s for PO# %s</a>", site_url("/po/view/$po"), $header, $po);
}
// lets get all the statuses in a list
$statuses = array();
$current_status = "";

foreach ($assets as $asset) {
    if ($asset->status != $current_status) {
        $statuses [] = $asset->status;
        $current_status = $asset->status;
    }
}
?>

<?php if ($this->ion_auth->in_group(1)): ?>

    <h3><?php echo $header; ?></h3>
<h4>Total Found: <?php echo count($assets);?></h4>
    <a href="<?php echo $_SERVER['REQUEST_URI'] . "&export=true"; ?>" class="btn btn-default">
        Export <i class="fa fa-download"></i>
    </a>

    <div class="asset-block">
        <?php foreach ($statuses as $status): ?>
            <div class="column">
                <h4><?php echo $status; ?></h4>
                <ul class="list-group">

                    <?php foreach ($assets as $asset): ?>

                        <?php if ($status == $asset->status): ?>

                            <li class="" id="asset-item_<?php echo $asset->id; ?>"><a
                                        href="<?php echo site_url("asset/view/$asset->id"); ?>"
                                        class="view-inline list-group-item asset-item"
                                >
                                    <?php echo $asset->product; ?><?php echo $asset->name ? sprintf(" (%s)", $asset->name) : ""; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
    <aside class="details-block float"></aside>
<?php endif;