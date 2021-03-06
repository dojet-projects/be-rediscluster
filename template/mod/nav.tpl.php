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
          <a class="navbar-brand" href="/">Redis Cluster Dash</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <p class="navbar-text pull-right">
            <?php echo isset($tpl_ipport) ? safeHtml($tpl_ipport) : ''; ?>
          </p>
          <ul class="nav navbar-nav">
            <li><a href="/nodelist">Node List</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
