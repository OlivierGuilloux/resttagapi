<?php
script('resttagapi', 'script');
//script('resttagapi', 'jquery.min');
script('resttagapi', 'jquery.dataTables.min');
script('resttagapi', 'dataTables.bootstrap4.min');
style('resttagapi', 'style');
style('resttagapi', 'dataTables.bootstrap4.min');
style('resttagapi', 'bootstrap.min');
?>
<div>
  <h1>Tags list</h1>
  
  <hr/>
  <table id="tagsStat" class="display datatable dt" role="grid">
    <thead>
      <tr>
        <th><input type="checkbox" name="resttagapi_checkAll" id="resttagapi_checkAll" alt="check/unckeck all" title="check/unckeck all" /></th>
        <th>Name</th>
        <th>Nb</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($_['tagsStats'] as $entry){ 
        ?>
        <tr>
          <td><input type="checkbox" value="<? echo $entry['id']; ?>" name="resttagapi_ids" class="resttagapi_ids" /></td>
          <td><a href="/index.php/apps/files/?dir=<? echo $entry['id']; ?>&view=systemtagsfilter" alt="View" title"View"><? echo $entry['name']; ?></a></td>
          <td><? echo $entry['nb']; ?></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
<input type="button" name="delete" value="Delete selected tags" id="resttagapi_actionDelete" class="resttagapi_actionDelete" title="Delete selected tags" />
