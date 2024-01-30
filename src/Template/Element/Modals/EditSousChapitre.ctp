<!-- Button to trigger the modal -->
<button class="btn" type="button" data-toggle="modal" data-target="#<?php echo($action.'--'.$object->id); ?>"><?php echo($icon); ?></i></button>

<!-- Rest of your code ... -->

<!-- Modal for <?php echo($action); ?>er le sous-chapitre <?php echo($object->id); ?> -->
<div class="modal fade" id="<?php echo($action.'--'.$object->id); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo($action.'--'.$object->id); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="<?php echo($action.'--'.$object->id); ?>Label"><?php echo($button); ?>:<?php echo($object->FullName); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo $this->Form->create($object); ?>
                <div class="modal-body">
                    <?php echo $this->Form->input('entityId',['type' => 'hidden' , 'value' => $object->id]); ?>
                    <?php echo $this->Form->input('action',['type' => 'hidden' , 'value' => $action]); ?>
                    <div class="form-group">
                        <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>
                        <?php echo $this->Form->input('niveaux_taxo_id', [
                            'label' => "Niveau taxonomique",
                            'options' => $niveauxTaxos
                        ]); ?>      
                    </div>
                </div>
                <div class="modal-footer"><!-- modal-footer -->
                    <button type="button" class="btn btn-default ml-auto" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-<?php echo($buttonColor); ?>"><?php echo($button); ?></button>       
                </div><!-- /modal-footer -->
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>