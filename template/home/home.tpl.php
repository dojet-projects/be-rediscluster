
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
  </head>
  <body>

<?php include TEMPLATE.'mod/nav.tpl.php'; ?>

    <div class="container" role="main">
      <div class="row">
        <div class="col-xs-12">
          <h4>Node List</h4>
          <table role="nodes-list" class="table table-hover" style="display: none;">
            <thead><tr></tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">CLUSTER MEET</button>
        </div>
      </div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>

<script type="text/javascript">
$().ready(function() {

  // cluster nodes list
  function render_nodes_list() {
    $.get('/ajax/cluster/nodes', function(resp, status) {
      console.log(resp);

      var nl = $('table[role=nodes-list]').css('display', '');
      $("thead tr", nl).html('');
      $("tbody", nl).html('');

      var data = resp.data;
      if (data.length <= 0) {
        console.log("no cluster nodes");
      }
      for (title in data[0]) {
        $("thead tr", nl).append("<th>" + title + "</th>");
      }

      for (idx in data) {
        var new_tr = $("<tr>").appendTo($("tbody", nl));
        for (k in data[idx]) {
          $("<td>").html(data[idx][k]).attr('data-key', k).appendTo(new_tr);
        }
      }

      function _make_node_link(e, id) {
        if (id.length < 40) {return;}
        var a = $('<a>').attr({"title": id, 'href': "/node/" + id});
        a.html(id.substring(0, 16) + '...');
        $(e).html(a);
      }

      $("td[data-key=id]").each(function(i, e) {
        _make_node_link(e, $(e).html());
      });

      $("td[data-key=master]").each(function(i, e) {
        _make_node_link(e, $(e).html());
      });
    });
  };
  render_nodes_list();
  window.render_nodes_list_interval = window.setInterval(render_nodes_list, 3000);
});
</script>

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
          <!-- <div class="form-group">
            <label for="exampleInputEmail1">AUTH</label>
            <input type="text" name="redis-auth" class="form-control" placeholder="auth">
          </div> -->
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

    var data = new FormData();
    data.append('server', server);
    $.ajax({
      url: "/ajax/cluster/meet",
      type: 'POST',
      data: data,
      mimeType: "multipart/form-data",
      cache: false,
      contentType: false,
      processData: false,
      success: function (data, textStatus, jqXHR) {
        var result = JSON.parse(data);
        if (result.errno == 0) {
          alert("meet successfully!");
          location.reload();
        } else {
          console.warn(result);
          alert(result.message);
        }

      }
    });
  });
});
</script>