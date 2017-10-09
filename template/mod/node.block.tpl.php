<div class="col-xs-12 col-lg-3 col-md-4 col-sm-6" id="node-block" role="" data-node-id="">
  <div class="thumbnail" style="overflow: hidden;">
    <div class="caption">
      <h4><a href="" role="node-href"></a></h4>
      <hr />
      <p>node-id: <span role="node-id"></span></p>
      <p><span role="keyspace"></span></p>
      <p>slots: <span role="slots"></span></p>
      <p>used_memory:<span role="used_memory"></span></p>
      <p>used_memory_rss:<span role="used_memory_rss"></span></p>
      <p>used_memory_peak:<span role="used_memory_peak"></span></p>
      <p>mem_fragmentation_ratio:<span role="mem_fragmentation_ratio"></span></p>
    </div>
  </div>
</div>
<script type="text/javascript">
function refresh_nodeinfo() {
  if (typeof(g.nodes) == 'undefined') {
    return;
  }
  var ids = g.nodes.map(function(e) {
    return e.id;
  });
  // console.log(ids);
  ajaxpostform("/ajax/nodeinfo", {ids: ids}, function(data, status) {
    data = JSON.parse(data);
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
      $('a[role=node-href]', nodediv).html(info[id]['node']['ip:port']);
      $('a[role=node-href]', nodediv).attr('href', 'node/' + id);
      $('span[role=node-id]', nodediv).html(id.substr(0, 16) + '...');
      $('span[role=keyspace]', nodediv).html(keyspace.join("<br />"));
      $('span[role=slots]', nodediv).html(info[id]['slots'].map(function(e) {
        return e[0] + '-' + e[1];
      }).join(' '));
      $('span[role=used_memory]', nodediv).html(redis_info['Memory']['used_memory_human']);
      $('span[role=used_memory_rss]', nodediv).html(redis_info['Memory']['used_memory_rss']);
      $('span[role=used_memory_peak]', nodediv).html(redis_info['Memory']['used_memory_peak_human']);
      $('span[role=mem_fragmentation_ratio]', nodediv).html(redis_info['Memory']['mem_fragmentation_ratio']);
    }
  });
}

  $().ready(function() {
    // setInterval(refresh_nodeinfo, 3000);
  });
</script>
