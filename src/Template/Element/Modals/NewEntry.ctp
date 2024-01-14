<!-- Button to trigger the modal -->
<button class="btn btn-info" type="button" data-toggle="modal" data-target="#addCompetenceModal">Ajouter une compétence intermédiaire</button>

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
                <!-- Form inside the modal -->
                <form id="addCompetenceForm">
                    <div class="form-group">
                        <label for="competenceName">Nom de la compétence intermédiaire:</label>
                        <input type="text" class="form-control" id="competenceName" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><!-- modal-footer -->
                <button type="button" class="btn btn-default ml-auto" data-dismiss="modal">Fermer</button>
                <button type="sumbit" class="btn btn-primary">Sauvegarder</button>
            </div><!-- /modal-footer -->
        </div>
    </div>
</div>

<table class="table">
    <!-- Table content... -->
</table>

<script type="text/javascript">
    // ... Your existing functions ...

    // Function to handle form submission inside the modal
    $('#addCompetenceForm').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the entered name
        var competenceName = $('#competenceName').val();

        // Check if the user entered a name
        if (competenceName !== "") {
            // Perform any additional logic you need with the entered name
            console.log("Compétence intermédiaire ajoutée:", competenceName);

            // You can choose to send the entered name to the server or update the UI accordingly

            // Close the modal
            $('#addCompetenceModal').modal('hide');
        } else {
            // Handle the case where the user entered an empty name
            console.log("Nom vide. Veuillez entrer un nom.");
        }
    });
</script>