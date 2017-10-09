
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

    <title>Node List | Redis Cluster Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="/static/css/main.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="/static/js/main.js"></script>

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
        <div id="nodes"></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button class="btn btn-primary" id="btn-meet">MEET</button>
        </div>
      </div>
    </div> <!-- /container -->

    <div style="display: none;">
<?php include TEMPLATE.'mod/node.block.tpl.php'; ?>
    </div>
  </body>
</html>
<script type="text/javascript">
  $().ready(function() {
    $('#btn-meet').click(function() {
      var ipport = prompt("input node ip:port");
      ajaxpostform("/ajax/cluster/meet", {"server": ipport}, function(data, textStatus, jqXHR) {
        var result = JSON.parse(data);
        if (result.errno == 0) {
          alert("meet successfully!");
          // location.reload();
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
    function refresh_nodes() {
      ajaxpostform("/ajax/cluster/nodes", {}, function(data, status) {
        // $('#nodes').html("");
        data = JSON.parse(data);
        // console.log(data);
        if (data.errno != 0) {
          console.log(data.message);
          return;
        }

        var exists = {};
        $('div[role=node-block]').each(function(i, e) {
          exists[$(e).attr('data-node-id')] = e;
        });

        g.nodes = data.data;
        for (var i in g.nodes) {
          var id = g.nodes[i].id;
          // console.log(id);
          if ($('div[data-node-id=' + id + ']').length == 0) {
            var b = $('#node-block').clone().removeAttr('id');
            b.attr('data-node-id', id).attr('role', 'node-block');
            b.appendTo($('#nodes'));
          }
          delete exists[id];
        }

        for (var id in exists) {
          $('div[data-node-id=' + id + ']').remove();
        }

        refresh_nodeinfo();
      });
    }
    refresh_nodes();
    setInterval(refresh_nodes, 3000);
  });
</script>
<script type="text/javascript">
  var g = {nodes: []};
</script>