<div class="users form large-12 columns content">
    <?php echo $this->Form->create($rotation); ?>
    <fieldset>
        <legend><?php echo __('Editer une rotation') ?></legend>
        <?php echo $this->Form->input('referential_id', [
            'label' => 'Référentiel',
            'default' => $referential_id,
            'onchange' => 'chainedPeriodes()'
        ]); ?>
        <?php echo $this->Form->input('periode_id', [
            'label' => 'Période correspondante dans le référentiel',

        ]); ?>

        <?php echo $this->Form->input('numero',[
            'label' => 'Numéro de rotation',
            'option' => 'number',
            'min' => '1',
            'max' => '10'
        ]); ?>

        <?php echo $this->Form->input('nom',[
            'label' => 'Nom',
            'option' => 'text'
        ]); ?>

        <?php echo $this->Form->input('theme_id',[
            'label' => 'Nom du thème',
            'options' => $listThemes
        ]); ?>
    </fieldset>
    <?php echo $this->Form->button('Sauvegarder'); ?>
    <?php echo $this->Form->end(); ?>
</div>

<script>
function chainedPeriodes()
{
    var $referential_id = document.getElementById("referential-id").value;
    $.get("<?php echo $this->Url->build(['controller'=>'FiltresAjaxes','action'=>'chainedPeriodes']) ?>" +
        "/?referential_id=" + $referential_id,
        function(resp) {
            $('#periode-id').html(resp);
            //$('#competences-terminale-id').trigger("onchange")
        }
    );
}
</script>
