  <table role="nodes-list" class="table table-hover" style="display: none;">
    <thead><tr></tr>
    </thead>
    <tbody>
    </tbody>
  </table>
<script type="text/javascript">
$().ready(function() {
  // cluster nodes list
  function render_nodes_list() {
    $.get('/ajax/cluster/nodes', function(resp, status) {
      // console.log(resp);

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
