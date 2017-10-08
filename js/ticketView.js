$(document).ready(function(){

    var inModal = false;

    //if a view button is clocked
    $('.view').click(function(){
        console.log(this);

        buttons = $('.view');
        tickets = $('.ticketModal');

        var buttonIndex;
        for(var i = 0; i < buttons.length; i++){
            console.log(buttons[i]);
            if(buttons[i] == this){
                buttonIndex = i;
                $(tickets[buttonIndex]).show();
                inModal = true;
            }

        }

    });

});
