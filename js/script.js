$(document).ready(function() {
  $('.dt').DataTable();

  $('#resttagapi_checkAll').toggle(function(){
    $('.resttagapi_ids').attr('checked','checked');
    $(this).val('uncheck all');
  },function(){
    $('.resttagapi_ids').removeAttr('checked');
    $(this).val('check all');        
  });

  $('#resttagapi_actionDelete').on('click touch', function() {
    $('.resttagapi_ids:checkbox:checked').each(function(index) {
        var tagId = $(this).val();
        var tr = $(this).parents("tr");
        $.ajax({
            url: '/index.php/apps/resttagapi/api/v1/restapi/tags/'+tagId,
            type: "DELETE",
            success: function(result) {
                console.log(result);
                tr.remove();
            },
            error: function(result) {
                console.log(result);
            },
            done: function(result) {
                console.log('done');
            }
        });
    });
  });
});

