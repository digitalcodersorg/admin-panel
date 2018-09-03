<?php
$attributeIdArray = [];
if (!empty($rightListBox)) {
    foreach ($rightListBox as $values) {
        $attributeIdArray[] = $values['id'];
    }
}
?>

<select multiple="multiple" size="10" name="ListBox[]">
    <?php
    if (!empty($leftListBox)) {
        foreach ($leftListBox as $value) {
            if (!in_array($value['id'], $attributeIdArray)) {
                ?>
                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php } else { ?>
                <option value="<?= $value['id'] ?>" selected="true"><?= $value['name'] ?></option>
            <?php
            }
        }
    }
    ?>
</select>