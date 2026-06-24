$(document).ready(()=>{  
    $("#chatOptionCollapseButton").click(function(){
        if($(this).data('collapsed')){
            $(this).data('collapsed',false);
            $(this).find('i').attr('class', 'fas fa-th-list');
        }else{
            $(this).data('collapsed',true);
            $(this).find('i').attr('class', 'fas fa-compress-arrows-alt');
        }
    });
    
    $("#chatCloseButton").click(()=>{
        $("#chatWidgetRoot").hide();
        $("#chatOpenButton").show();
    });

    $("#chatOpenButton").click(()=>{
        $("#chatOpenButton").hide();
        $("#chatWidgetRoot").show();
    });
});