<button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">CLUSTER MEET</button>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CLUSTER MEET</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="">REDIS NODE IP:PORT</label>
            <input type="text" name="redis-server" class="form-control" placeholder="ip:port">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="redis-submit">提交</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$().ready(function() {

  $("#redis-submit").click(function() {
    var server = $('input[name=redis-server]').val();

    ajaxpostform("/ajax/cluster/meet", {"server": server}, function(data, textStatus, jqXHR) {
      var result = JSON.parse(data);
      if (result.errno == 0) {
        alert("meet successfully!");
        location.reload();
      } else {
        console.warn(result);
        alert(result.message);
      }
    });
  });
});
</script>
