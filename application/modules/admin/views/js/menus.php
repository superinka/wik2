<script src="<?php echo admin_theme('');?>/assets/js/jquery.nestable.min.js"></script>
<script>

$(document).ready(function()
{

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 0,
		maxDepth : 2
    })
    .on('change', updateOutput);



    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });


});
</script>

<script>
  $(document).ready(function(){
    $("#load").hide();
    $("#submit").click(function(){
       $("#load").show();

       var dataString = { 
              label : $("#label").val(),
              link : $("#link").val(),
              id : $("#id").val()
            };
		if($("#label").val() == '' || $("#link").val() ==''){
			$("#load").hide();
		}
		if($("#label").val() != '' &&  $("#link").val() !='') {
			console.log(dataString);
			$.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "admin/menus/save_menu",
            data: dataString,
            dataType: "json",
			cache : false,
            success: function(data){
              if(data.type == 'add'){
                 $("#menu-id").append(data.menu);
              } else if(data.type == 'edit'){
                 $('#label_show'+data.id).html(data.label);
                 $('#link_show'+data.id).html(data.link);
              }
              $('#label').val('');
              $('#link').val('');
              $('#id').val('');
              $("#load").hide();
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        	});
		}

    });

    $('.dd').on('change', function() {
        $("#load").show();
     
          var dataString = { 
              data : $("#nestable-output").val(),
            };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "admin/menus/save",
            data: dataString,
            cache : false,
            success: function(data){
              $("#load").hide();
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });

    $("#save").click(function(){
         $("#load").show();
     
          var dataString = { 
              data : $("#nestable-output").val(),
            };
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "admin/menus/save",
            data: dataString,
            cache : false,
            success: function(data){
              $("#load").hide();
              alert('Data has been saved');
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });

 
    $(document).on("click",".del-button",function() {
        var x = confirm('Delete this menu?');
        var id = $(this).attr('id');
		//console.log(id);
        if(x){
            $("#load").show();
             $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "admin/menus/delete",
                data: { id : id },
                cache : false,
                success: function(data){
                  $("#load").hide();
                  $("li[data-id='" + id +"']").remove();
                } ,error: function(xhr, status, error) {
                  alert(error);
                },
            });
        }
    });

    $(document).on("click",".edit-button",function() {
        var id = $(this).attr('id');
        var label = $(this).attr('label');
        var link = $(this).attr('link');
        $("#id").val(id);
        $("#label").val(label);
        $("#link").val(link);
    });

    $(document).on("click","#reset",function() {
        $('#label').val('');
        $('#link').val('');
        $('#id').val('');
    });

  });

</script>
