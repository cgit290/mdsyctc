<div class="modal fade bs-example-modal-center" id="mds" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px"></lord-icon>
                <div class="mt-4">
                    <h4 class="mb-3">$msg</h4>
                    <!-- <p class="text-muted mb-4"> The transfer was not successfully received by us. the email of the recipient wasn't correct.</p> -->
                    <div class="hstack gap-2 justify-content-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" onclick="reloadPage()">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
           
            
<script>
    function reloadPage() {
    location.reload();
    }
</script>