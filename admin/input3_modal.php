<!-- Add and Edit Session Modal -->
<div id="<?php  echo $id;  ?>" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo $title;  ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label for="employeeName" class="form-label"><?php echo $f1lbl;  ?></label>
                    <input type="number" value="<?php echo $f1value;  ?>" name="<?php echo $f1name;  ?>" class="form-control" id="<?php echo 'id'.$f1name;  ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="StartleaveDate" class="form-label"><?php echo $f2lbl;  ?></label>
                    <input type="date" value="<?php echo $f2value;  ?>" name="<?php echo $f2name;  ?>" class="form-control" data-provider="flatpickr" id="<?php echo 'id'.$f2name;  ?>">
                </div>
                <div class="mb-3">
                    <label for="EndleaveDate" class="form-label"><?php echo $f3lbl;  ?></label>
                    <input type="date" value="<?php echo $f3value;  ?>" name="<?php echo $f3name;  ?>" class="form-control" data-provider="flatpickr" id="<?php echo 'id'.$f3name;  ?>">
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary " name="submit" value="<?php echo $btnvalue; ?>">Yes</button>
                    <input type="hidden" value="<?php echo $hivalue; ?>" name="<?php echo $hname; ?>">
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->