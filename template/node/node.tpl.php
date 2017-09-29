
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
          <h2>Node <?php echo safeHtml($tpl_node_id); ?>
            <small>
              IP: <?php echo $tpl_node_ip ?>
              Port: <?php echo $tpl_node_port ?>
            </small>
          </h2>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-lg-6">
          <h3>Cluster Info</h3>
          <ul class="list-group">
          <?php foreach ($tpl_cluster_info as $key => $value) : ?>
            <li class="list-group-item"><?php echo safeHtml(sprintf("%s : %s", $key, $value)); ?></li>
          <?php endforeach ?>
          </ul>
        </div>
        <div class="col-xs-12 col-lg-6">
          <h3>Redis Info</h3>
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <?php foreach ($tpl_info as $name => $section) :
                  $collapse_id = sprintf("collapse-%s", $name);
          ?>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="heading<?php echo safeHtml($collapse_id)?>">
                <h4 class="panel-title">
                  <a role="button" data-toggle="collapse" data-parent="#" href="#<?php echo safeHtml($collapse_id) ?>" aria-expanded="false" aria-controls="<?php echo safeHtml($collapse_id) ?>">
                    <?php echo safeHtml($name); ?>
                  </a>
                </h4>
              </div>
              <div id="<?php echo safeHtml($collapse_id) ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo safeHtml($collapse_id)?>">
                <ul class="list-group">
                <?php foreach ($section as $key => $value) : ?>
                  <li class="list-group-item"><?php echo safeHtml(sprintf("%s : %s", $key, $value));?></li>
                <?php endforeach ?>
                </ul>
              </div>
            </div>
          <?php endforeach ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button class="btn btn-success" id="btn-replicate">Replicate</button>
          <h3>slots</h3>
          <p id="slots"></p>
          <button class="btn btn-primary" id="btn-addslots">AddSlots</button>
          <button class="btn btn-danger" id="btn-delslots">DelSlots</button>
          <button class="btn btn-success" id="btn-migrate">Migrate Slot</button>
          <h3>Dangerous Opts</h3>
          <button class="btn btn-danger" id="btn-forget">FORGET</button>
          <button class="btn btn-danger" id="btn-reset">RESET</button>
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
function get_slots() {
  $.post('/ajax/cluster/slots', {id: node_id}, function(data, textStatus, jqXHR) {
    var errno = data.errno;
    if (0 == errno) {
      var slots = data.data.slots;
      $('#slots').html(
        slots.map(function(e, i) {
          return e[0] != e[1] ? e[0] + '-' + e[1] : e[0];
        }).join(' , ')
      );
    } else {
      console.log("[ERROR]" + data.message);
    }
  }, 'json');
};

$().ready(function() {
  get_slots();
  setInterval(get_slots, 3000);
})
</script>
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
      } else {
        alert("[ERROR]" + data.message);
      }
    }, "json");
  });
})
</script>
<script type="text/javascript">
$().ready(function() {
  $('#btn-reset').click(function() {
    if (!confirm('are you sure to reset this node?')) {
      return;
    }
    $.post('/ajax/cluster/reset', {id: node_id}, function(data, textStatus, jqXHR) {
      var errno = data.errno;
      if (0 == errno) {
        alert('reset success');
      } else {
        alert("[ERROR]" + data.message);
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
        get_slots();
      } else {
        alert("[ERROR]" + data.message);
      }
    }, "json");
  });
})
</script>
<script type="text/javascript">
$().ready(function() {
  $('#btn-delslots').click(function() {
    var slots = prompt("input slots:");
    $.post('/ajax/cluster/delslots', {id: node_id, slots: slots}, function(data, textStatus, jqXHR) {
      var errno = data.errno;
      if (0 == errno) {
        alert("del slots success");
        get_slots();
      } else {
        alert("[ERROR]" + data.message);
      }
    }, "json");
  });
})
</script>
<script type="text/javascript">
$().ready(function() {
  $('#btn-migrate').click(function() {
    var slot = prompt("input slot:");
    var destination_node_id = prompt("destination_node_id:");
    $.post('/ajax/cluster/migrate-slot',
      {source_node_id: node_id, destination_node_id: destination_node_id, slot: slot},
      function(data, textStatus, jqXHR) {
        var errno = data.errno;
        if (0 == errno) {
          alert("migrate slot success");
          get_slots();
        } else {
          alert("[ERROR]" + data.message);
        }
      },
    "json");
  });
})
</script>
<script type="text/javascript">
$().ready(function() {
  $('#btn-replicate').click(function() {
    var master_node_id = prompt("master_node_id:");
    $.post('/ajax/cluster/replicate',
      {node_id: node_id, master_node_id: master_node_id},
      function(data, textStatus, jqXHR) {
        var errno = data.errno;
        if (0 == errno) {
          alert("replicate success");
          get_slots();
        } else {
          alert("[ERROR]" + data.message);
        }
      },
    "json");
  });
})
</script>
