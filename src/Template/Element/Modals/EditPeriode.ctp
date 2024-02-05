<!-- Button to trigger the modal -->
<button class="btn" type="button" data-toggle="modal" data-target="#<?php echo($action.'--'.$object->id); ?>"><?php echo($icon); ?></i></button>

<!-- Rest of your code ... -->

<!-- Modal for adding compétence intermédiaire -->
<!-- Modal for <?php echo($action); ?>ing compétence intermédiaire <?php echo($object->id); ?> -->
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
                    <div class="form-group">
                    <?php echo $this->Form->input('numero', [
                        'label' => "Numéro de la période",
                        'option' => 'number'
                    ]); ?>
                    <?php echo $this->Form->input('progression_id', [
                        'label' => "Progression",
                        'option' => $progressions
                    ]); ?>
                    <?php echo $this->Form->input('action',['type' => 'hidden' , 'value' => 'edit']); ?>
                    </div>
                </div>
                <div class="modal-footer"><!-- modal-footer -->
                    <button type="button" class="btn btn-default ml-auto" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-<?php echo($buttonColor); ?>"><?php echo($button); ?></button>       
                </div><!-- /modal-footer -->
            </form>
        </div>
    </div>
</div>