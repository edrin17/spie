<!-- Button to trigger the modal -->
<button class="btn" type="button" data-toggle="modal" data-target="#<?php echo($action.'--'.$object->id); ?>"><?php echo($icon); ?></i></button>

<!-- Rest of your code ... -->

<!-- Modal for deleting <?php echo($object->id); ?> -->
<div class="modal fade" id="<?php echo('delete--'.$object->id); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo($action.'--'.$object->id); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3> <span class="label label-danger" id="<?php echo($action.'--'.$object->id); ?>">Etes-vous sûr de vouloir supprimer:</span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo $this->Form->create($object); ?>
                <div class="modal-body">
                    <?php echo $this->Form->input('entityId',['type' => 'hidden' , 'value' => $object->id]); ?>
                    <?php echo $this->Form->input('action',['type' => 'hidden' , 'value' => $action]); ?>
                    <h3><?php echo($object->fullName); ?>?</h3>
                </div>
                <div class="modal-footer"><!-- modal-footer -->
                    <button type="button" class="btn btn-default ml-auto" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-<?php echo($buttonColor); ?>"><?php echo($button); ?></button>       
                </div><!-- /modal-footer -->
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
