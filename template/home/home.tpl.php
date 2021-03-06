
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>Redis Cluster Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="/static/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      div[role=slots] div {
        border: solid 1px gray; width: 3px; height: 3px; float: left;
      }
    </style>
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>

<?php include TEMPLATE.'mod/nav.tpl.php'; ?>

    <div class="container" role="main">
      <div class="row">
        <div class="col-xs-12">
          <h4>Node List</h4>
<?php include TEMPLATE.'mod/nodelist.tpl.php'; ?>
          <button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">CLUSTER MEET</button>
          <button class="btn btn-success pull-right" id="btn-resharding">RESHARDING</button>
        </div>
      </div>
    </div> <!-- /container -->

    <div class="container">
      <div class="row">
        <div class="col-xs-12" role="slots">
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>


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
  function ajaxpostform(url, data, success) {
    var formdata = new FormData();
    for (k in data) {
      formdata.append(k, data[k]);
    }
    $.ajax({
      url: url,
      type: 'POST',
      data: formdata,
      mimeType: "multipart/form-data",
      cache: false,
      contentType: false,
      processData: false,
      success: success
    });
  }
</script>
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
<script type="text/javascript">
$().ready(function() {
  $("#btn-resharding").click(function() {
    $.get('/ajax/resharding/plan', function(resp, status) {
      if (resp.errno == 0) {
        var pmt = '';
        var plan = resp.data;
        plan.map(function(e) {
          pmt += "node: " + e.id;
          pmt += "\r\n";
          pmt += "slots: ";
          e.slots.map(function(slot) {
            pmt += slot.from + "-" + slot.to;
            pmt += "\r\n";
          });
          pmt += "\r\n";
        });

        if (confirm(pmt)) {
          ajaxpostform('/ajax/resharding/reshard', {plan: JSON.stringify(plan)}, function(data, textStatus, jqXHR) {
            data = JSON.parse(data);
            console.log(data);
            if (data.errno == 0) {
              alert('resharding complete');
            } else {
              alert(data.errno);
            }
          });
        }
      }
    }, "json");
  });
});
</script>