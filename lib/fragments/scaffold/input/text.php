<?php
/** @var rex_fragment $this */
$name = $this->getVar('name');
$label = $this->getVar('label');

if (null === $label || '' === $label) {
    $label = $name;
}

$value = $this->getVar('value');
$notice = $this->getVar('notice');
?>

<dl class="rex-form-group form-group">
    <dt>
        <label for="<?= $name ?>"><?= $label ?></label>
    </dt>

    <dd>
        <input class="form-control"
               id="<?= $name ?>"
               type="text"
               name="<?= $name ?>"
               value="<?= $value ?>">

        <?php if ($notice) : ?>
            <p class="help-block rex-note"><?= $notice ?></p>
        <?php endif ?>
    </dd>
</dl>