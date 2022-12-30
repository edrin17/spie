<div class="container-fuild">
    <div class="row">
        <div class="col-lg-2">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Filtrer par référentiel:',
                'onchange' => 'filter()',
                'default' => $referential_id
            ]); ?>
        </div>
        <div class="col-lg-2">
            <?php echo $this->Form->input('classe_id', [
                'label' => 'Filtrer par classe:',
                'onchange' => 'filter()',
                'default' => $classe_id
            ]); ?>
        </div>
        <div class="col-lg-2">
            <?php echo $this->Form->input('periode_id', [
                'label' => 'Filtrer par période',
                'onchange' => 'filter()',
                'default' => $periode_id
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $this->Form->input('rotation_id', [
                'label' => 'Filtrer par rotation',
                'onchange' => 'filter()',
                'default' => $rotation_id
            ]); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
function filter()
{
    var $referential_id = document.getElementById("referential-id").value;
    var $classe_id = document.getElementById("classe-id").value;
    var $periode_id = document.getElementById("periode-id").value;
    var $rotation_id = document.getElementById("rotation-id").value;
    var url = "<?php echo $this->Url->build(['controller'=>'Suivis','action'=>'tp']) ?>" +
        "/?referential_id=" + $referential_id +
        "&classe_id=" + $classe_id +
        "&periode_id=" + $periode_id+
        "&rotation_id=" + $rotation_id;
	window.location = url;
}
</script>
