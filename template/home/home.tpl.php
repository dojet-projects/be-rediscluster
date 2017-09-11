
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

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Redis Cluster Dash</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" role="main">
<?php if (count($tpl_servers) > 0) : ?>
      <div class="row">
        <div class="col-xs-12">
          <table class="table table-hover">
            <thead>
              <th width="1">#</th>
              <th>SERVER</th>
            </thead>
            <tbody>
            <?php foreach ($tpl_servers as $id => $server) : ?>
              <tr>
                <td><?php echo safeHtml($id + 1) ?></td>
                <td><?php echo safeHtml($server['server']) ?></td>
              </tr>
            <?php endforeach ?>
            </tbody>
          </table>
          <button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">MEET</button>
        </div>
      </div>
<?php else : ?>
      <div class="row">
        <div class="col-xs-12" style="margin: 1em auto;">
          <button id="init" class="btn btn-primary btn-lg" data-toggle="modal" data-target=".bs-example-modal-lg">添加Redis服务器</button>
        </div>
      </div>
<?php endif ?>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">添加Redis服务器</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">REDIS SERVER IP:PORT</label>
            <input type="text" name="redis-server" class="form-control" placeholder="ip:port">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">AUTH</label>
            <input type="text" name="redis-auth" class="form-control" placeholder="auth">
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
    var auth = $('input[name=redis-auth]').val();

    var data = new FormData();
    data.append('server', server);
    data.append('auth', auth);
    $.ajax({
      url: "/ajax/server/add",
      type: 'POST',
      data: data,
      mimeType: "multipart/form-data",
      cache: false,
      contentType: false,
      processData: false,
      success: function (data, textStatus, jqXHR) {
        var result = JSON.parse(data);
        if (result.errno == 0) {
          alert("add server success")
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