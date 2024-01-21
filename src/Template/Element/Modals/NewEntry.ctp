<!-- Button to trigger the modal -->
<button class="btn btn-info" type="button" data-toggle="modal" data-target="#addCompetenceModal">Ajouter une entrée</button>

<!-- Rest of your code ... -->

<!-- Modal for adding compétence intermédiaire -->
<div class="modal fade" id="addCompetenceModal" tabindex="-1" role="dialog" aria-labelledby="addCompetenceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addCompetenceModalLabel"><?php echo $modalTitle ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="form-group">
                    <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>
                    <?php echo $this->Form->input('numero',[
                        'label' => 'Numéro de la compétence',
                        'option' => 'number'
                    ]); ?>
                    <?php echo $this->Form->input('action',['type' => 'hidden' , 'value' => 'add']); ?>
                    </div>
                </div>
                <div class="modal-footer"><!-- modal-footer -->
                    <button type="button" class="btn btn-default ml-auto" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>       
                </div><!-- /modal-footer -->
            </form>
        </div>
    </div>
</div>

<script>
    /* Generate the URL using a script block
    var url = "";
   
   $('#addCompetenceForm').submit(function (event) {
        console.log("Form submitted!");  // Add this line
        // Get the entered name
        var competenceName = $('#competenceName').val();

        // Check if the user entered a name
        if (competenceName !== "") {
            // Perform any additional logic you need with the entered name
            console.log(url);
            
            //Send data to controller
            //$.ajax({
            //url: url,
            //async: false, // Make the request synchronous
            //type: "POST",
            //});

            // Close the modal
            $('#addCompetenceModal').modal('hide');

            //refresh the page
            
        } else {
            // Handle the case where the user entered an empty name
            console.log("Nom vide. Veuillez entrer un nom.");
        }
    });  */  
</script>
