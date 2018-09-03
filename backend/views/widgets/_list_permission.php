<?php
$attributeIdArray = [];
if (!empty($rightListBox)) {
    foreach ($rightListBox as $values) {
        $attributeIdArray[] = $values['child'];
    }
}
?>

<div class="wrapper  animated fadeInRight">
    <div class="row">
        <?php if (!empty($leftListBox)) { ?>
            <?php foreach ($leftListBox as $data) { ?>
                <div class="col-md-3 col-sm-3 margin_15px listPremis">
                    <div class="ibox">
                        <div class="ibox-content product-box ">
                            <div class="product-desc">

                                <a href="#" class="product-name"> <?= ucfirst($data['name']); ?></a>
                                <?php if (!empty($data['authItems'])) { ?>
                                    <?php foreach ($data['authItems'] as $permission) { ?>
                                        <?php if (!in_array($permission['name'], $attributeIdArray)) { ?>
                                            <div class="i-checks"><label class="checkbox-container"> <input type="checkbox" name="ListBox[]" value="<?= $permission['name'] ?>"> <i></i> <?= ucwords(str_replace('-', ' ', $permission['name'])); ?>
                                                <span class="checkmark"></span></label></div>
                                        <?php } else {
                                            ?>
                                            <div class="i-checks"><label class="checkbox-container"> <input type="checkbox" checked  name="ListBox[]" value="<?= $permission['name'] ?>"> <i></i> <?= ucwords(str_replace('-', ' ', $permission['name'])); ?> <span class="checkmark"></span></label></div>
                                                <?php } ?>
                                                <?php
                                            }
                                        }
                                        ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>




</div>