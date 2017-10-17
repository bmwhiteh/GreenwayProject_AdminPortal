$(document).ready(function () {

    $('#showScheduledTasks').click(function(){
        $('#scheduledTaskTable').show();
        $('#completedTaskTable').hide();
    });

    $('#showCompletedTassks').click(function(){
        console.log("h");
        $('#scheduledTaskTable').hide();
        $('#completedTaskTable').show();
    });
});