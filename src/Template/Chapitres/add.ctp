<?php echo $this->Form->create($chapitre); ?>
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-6">
            <?php echo $this->Form->input('savoir_id', [
                'label' => 'Choix du savoir:',
                'default' => $savoir_id,
                'id' => 'parent_id',
            ]); ?>
        </div>
        <div class="col-lg-6">
            <?php echo $this->Form->input('taxo_id', [
                'label' => 'Choix du niveau taxonomique:',
                'default' => $taxo_id
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="name">Nom du chapitre</label>
            <?php echo $this->Form->text('name', [
                'id' => 'name',
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="num">Numéro</label>
            <?php echo $this->Form->text('num', [
                'id' => 'num',
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="content">Description</label>
            <?php echo $this->Form->textarea('content', [
                'id' => 'content',
                'class' => 'form-control',
                'row' => '6'
            ]); ?>
        </div>
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <?php echo $this->Form->button('Enregistrer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
        </div>
    </div>
</div>

<?php echo $this->Form->end(); ?>