<!-- Modal start here-->
<form class="form-horizontal" role="form" method="post" action="?">

    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="height: 60px; border-style: none;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 class="text-danger text-center lead"><bold>Warning Alert</bold></h3>
                </div>
                <div class="modal-body" style="height: 60px; border-style: none;">
                    <h4 class="text-primary text-center">Do you want to Delete this?</h4>
                    <input type="hidden" class="form-control col-lg-10" id="deleteId" name="delete" value=""/>
                </div>
                <div class="modal-footer" style="height: 60px; border-style: none;">
                    <input styles="" type="submit" class="btn btn-primary alert-success" value="Yes" name="del"/>
                    <button style="" type="button" class="btn btn-danger alert-error" data-dismiss="modal">No</button>

                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal end here-->
