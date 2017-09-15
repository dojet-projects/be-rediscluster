
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
<script type="text/javascript">
  var node_id = '<?php echo safeHtml($tpl_node_id) ?>'
</script>
  <body>

<?php include TEMPLATE.'mod/nav.tpl.php'; ?>

    <div class="container" role="main">
      <div class="row">
        <div class="col-xs-12">
          <h2>Node <?php echo safeHtml($tpl_node_id); ?></h2>
          <button class="btn btn-primary" id="btn-addslots">AddSlots</button>
          <h3>Info</h3>
          <p><?php echo nl2br(safeHtml($tpl_info));?></p>
          <button class="btn btn-danger" id="btn-forget">FORGET</button>
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
  $('#btn-forget').click(function() {
    if (!confirm('are you sure to forget this node?')) {
      return;
    }
    $.post('/ajax/cluster/forget', {id: node_id}, function(data, textStatus, jqXHR) {
      var errno = data.errno;
      if (0 == errno) {
        window.location.href = '/';
      }
    }, "json");
  });
})
</script>
<script type="text/javascript">
$().ready(function() {
  $('#btn-addslots').click(function() {
    var slots = prompt("input slots:");
    $.post('/ajax/cluster/addslots', {id: node_id, slots: slots}, function(data, textStatus, jqXHR) {
      var errno = data.errno;
      if (0 == errno) {
        alert("add slots success");
      } else {
        alert("[ERROR]" + data.message);
      }
    }, "json");
  });
})
</script>
