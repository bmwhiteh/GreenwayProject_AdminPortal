$(document).ready(function () {
    //show scheduled table on click
    $('#showScheduledTasks').click(function(){
        $('#scheduledTaskTable').show();
        $('#completedTaskTable').hide();
    });

    //show completed schedule on click
    $('#showCompletedTassks').click(function(){
        console.log("h");
        $('#scheduledTaskTable').hide();
        $('#completedTaskTable').show();
    });
});