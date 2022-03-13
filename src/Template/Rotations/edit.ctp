<?= $this->Form->create($rotation); ?>
<div class="users form large-9 medium-8 columns content">
    <fieldset>
        <legend><?= __('Editer une rotation') ?></legend>

            <?= $this->Form->input('periode_id', [
                'label' => 'Période correspondante dans le référentiel',
                'options' => $selectPeriodes,
				'default' => $rotation->periode_id
            ]); ?>

            <?= $this->Form->input('numero',[
                'label' => 'Numéro de rotation',
                'option' => 'number',
                'min' => '1',
                'max' => '10'
            ]); ?>

            <?= $this->Form->input('nom',[
                'label' => 'Nom',
                'option' => 'text'
            ]); ?>

            <?= $this->Form->input('theme_id',[
                'label' => 'Nom du thème',
                'options' => $listThemes
            ]); ?>

    </fieldset>
    <?= $this->Form->button(__('Editer')); ?>
</div>
<?= $this->Form->end(); ?>

<script>
function select_periodes()
{
    var id = document.getElementById("classe-id").value;
	$.get("<?= $this->Url->build([
        'controller'=>'FiltresAjaxes',
        'action'=>'chainedPeriodes']) ?>"
        + "/?parent_id=" +id, function(resp) {
            $('#periode-id').html(resp);
        });
}
</script>
