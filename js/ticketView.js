$(document).ready(function () {


    //if a view button is clocked
    $('.view').click(function () {
        //get list of buttons
        var buttons = $('.view');
        var tickets = $('.ticketModal');

        //loop through all buttons of class view
        for (var i = 0; i < buttons.length; i++) {
            //once we find the index of the button that was clicked
            if (buttons[i] == this) {
                console.log('yes');
                //show the modal of matching index if it is hidden
                if($(tickets[i]).is(':hidden')){
                    $(tickets[i]).toggle();
                }
            }
        }
    }); //end view click

    //close all modals by clicking close button or esc key
    $('.closeModalButton').click(function () {
        $('.ticketModal').hide();
    });
    $(document).on('keydown',function(key){
        if(key.keyCode == 27){

        }

    });


});

