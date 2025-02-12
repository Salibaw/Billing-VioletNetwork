<div class="modal fade" id="addCatModal" tabindex="-1" aria-labelledby="addCatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCatModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <!-- Category Form for entering category information -->
                    <form id="addCatForm" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label for="catName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="catName" name="catName"
                                value="{{ old('catName') }}">
                            <div id="catNameError" class="invalid-feedback"></div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveCatBtn" class="btn btn-primary">Save</button>
            </div>
            </form><!-- Category Form -->
        </div>
    </div>
</div>
<div id="successAlert" class="alert alert-success" style="display: none;">
    Category created successfully!
</div>

<script>
    $(document).ready(function() {
        $('#saveCatBtn').on('click', function() {
            let form = document.getElementById('addCatForm');
            let formData = new FormData(form);
            axios.post('{{ route('storeCat') }}', formData)
                .then(function(response) {
                    // Handle success
                    console.log(response.data);
                    // Close the modal
                    $('#addCatModal').modal('hide');
                    // Show success message
                    $('#successAlert').fadeIn().delay(2000).fadeOut();
                    location.reload();
                })
                .catch(function(error) {
                    // Handle error
                    if (error.response) {
                        let errors = error.response.data.errors;
                        // Display validation errors
                        if (errors.catName) {
                            document.getElementById('catName').classList.add('is-invalid');
                            document.getElementById('catNameError').innerHTML = errors.catName[0];
                        }
                    }
                });
        });
    });
</script>
