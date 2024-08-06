<div id="<?php echo $id==''? 'mds':$id; ?>" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"><?php echo $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="fs-15">
                <?php echo $message ?>
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <button type="submit" class="btn btn-primary " name="submit" value="<?php echo $btnvalue ?>">Yes</button>
                <input type="hidden" value="<?php echo $hivalue ?>" name="<?php echo $hname ?>">
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->