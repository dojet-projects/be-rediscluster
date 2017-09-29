
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
<?php foreach ($tpl_nodes as $node) : ?>
        <div class="col-xs-12 col-lg-3 col-md-4 col-sm-6" role="node" data-node-id="<?php echo safeHtml($node->id()); ?>">
          <div class="thumbnail" style="overflow: hidden;">
            <div class="caption">
              <h4><a href="/node/<?php echo $node->id() ?>"><?php echo $node->ip().':'.$node->port(); ?></a></h4>
              <hr />
              <p>node-id: <span role="node-id"><?php echo substr($node->id(), 0, 16).'...' ?></span></p>
              <p><span role="keyspace">db0: k=6382342, e=0, ttl=123748974823</span></p>
              <p>slots: <span role="slots">0-34773</span></p>
              <p>used_memory:<span role="used_memory">24.29M</span></p>
              <p>used_memory_peak:<span role="used_memory_peak">24.32M</span></p>
              <p>mem_fragmentation_ratio:<span role="mem_fragmentation_ratio">1.03</span></p>
            </div>
          </div>
        </div>
<?php endforeach ?>
      </div>
    </div> <!-- /container -->


  </body>
</html>
<script type="text/javascript">
  $().ready(function() {
    function refresh_nodeinfo() {
      var ids = [];
      $('div[role=node]').each(function(i, e) {
        ids.push($(e).attr('data-node-id'));
      });
      ajaxpostform("/ajax/nodeinfo", {ids: ids}, function(data, status) {
        data = JSON.parse(data);
        console.log(data);
        if (data.errno != 0) {
          console.log(data.message);
          return;
        }
        var info = data.data.info;
        for (var id in info) {
          var redis_info = info[id]['redis_info'];
          var nodediv = $('div[data-node-id=' + id + ']');
          var keyspace = [];
          for (var db in redis_info['Keyspace']) {
            keyspace.push(db + ':' + redis_info['Keyspace'][db]);
          }
          $('span[role=keyspace]', nodediv).html(keyspace.join("<br />"));
          $('span[role=slots]', nodediv).html(info[id]['slots'].map(function(e) {
            return e[0] + '-' + e[1];
          }).join(' '));
          $('span[role=used_memory]', nodediv).html(redis_info['Memory']['used_memory_human']);
          $('span[role=used_memory_peak]', nodediv).html(redis_info['Memory']['used_memory_peak_human']);
          $('span[role=mem_fragmentation_ratio]', nodediv).html(redis_info['Memory']['mem_fragmentation_ratio']);
        }
      });
    }
    refresh_nodeinfo();
    setInterval(refresh_nodeinfo, 3000);
  });
</script>