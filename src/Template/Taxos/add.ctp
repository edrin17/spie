<?php echo $this->Form->create($taxo); ?>
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-6">
            <label for="name">Nom du niveau</label>
            <input name="name" type="text" id="name" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="num">Numéro</label>
            <input name="num" type="number" id="nul" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="content">Numéro</label>
            <textarea name="content" row="6" placeholder="Description" id="content" class="form-control">
        </div>
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <?php echo $this->Form->button('Enregistrer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
        </div>
    </div>
</div>

<?php echo $this->Form->end(); ?>