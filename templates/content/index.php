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
  <table id="tagsStat" class="dataframe dt">
    <thead>
      <tr>
        <th>Name</th>
        <th>Nb</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($_['tagsStats'] as $entry){ 
        ?>
        <tr>
          <td><? echo $entry['name']; ?></td>
          <td><? echo $entry['nb']; ?></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
