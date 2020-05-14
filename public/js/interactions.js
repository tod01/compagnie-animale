

function get_particular_ads(event) {

    particulars = document.querySelector('#particulars');
    professionals = document.querySelector('#professionals');

    $status = event.target.checked;

    /* do not allow both buttons to be deselected */
    if(!particulars.checked && !professionals.checked) {
        particulars.checked = true;
        professionals.checked = true;
        $status = "default";
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* send the data to the OfferController to be added */
    $.ajax({
        type:"POST",
        url:"offers/filterResults/",
        data: {
            'status' : $status,
            'ads_order' : event.target.value,
        },

        success : function(results) {
            
            $('#post-data').html(results.html);

            if(results.nber_of_posts == 0) {
                $('.ajax-load').html("No ads were found!");
                return;
            }
        }
    });
}

function get_interaction(event, id, eventType, start="") {
    
    /* set in the data base the user's actions if he is connected */

    /* if he is connected */
   // if(status) {
    console.log('interaction')
    event_type_strength = {
        'SEARCH' : 1.5,
        'VIEW'   : 2.0,
        'LIKE'   : 2.5,
        'CONTACT': 3.0,
        'FOLLOW' : 4.0
    };

    if(eventType != "VIEW") {
        event.preventDefault();
    }
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* send the data to the OfferController to be added */
    $.ajax({
            type:"POST",
            url:start+"interaction/",
            data: {
                'id' : id,
                'eventType' : eventType,
                'eventStrength' : event_type_strength[eventType],
            },

            success : function(results) {
                console.log(results);
            }
    });
    //}
}

function like_unlike(event) {
    
    event.preventDefault();
    //event.target.style.color = 'red';
    
   //console.log(state);

   element = event.target;

   if (element.classList.contains('far') ) {
        element.classList.remove('far');
        element.classList.toggle('fas');
        element.style.color = '#ff6e14';
   }else {
        element.classList.remove('fas');
        element.classList.toggle('far');
        element.style.color = '#3490dc';
   }

}


function follow_unfollow(event, status) {
    
    event.preventDefault();
    if(status) {
        console.log('here')
        element = event.target
        if(element.textContent == "Follow") {
            console.log('danger')
            element.classList.remove("btn-primary");
            element.classList.toggle("btn-danger");
            element.textContent = "Unfollow"
        }else {
            element.classList.remove("btn-danger");
            element.classList.toggle("btn-primary");
            element.textContent = "Follow"
        }
    }
}


function price_slider(e) {
    const fromSlider = $(this).parent().children('input[type="range"].from'),
            toSlider = $(this).parent().children('input[type="range"].to'),
            fromValue = parseInt($(this).parent().children('input[type="range"].from').val()),
            toValue = parseInt($(this).parent().children('input[type="range"].to').val()),
            currentlySliding = $(this).hasClass('from') ? 'from' : 'to',
            outputElemFrom = $(this).parent().children('.value-output.from'),
            outputElemTo = $(this).parent().children('.value-output.to');
  
        // Check which slider has been adjusted and prevent them from crossing each other 
        if(currentlySliding == 'from' && fromValue >= toValue){
          fromSlider.val((toValue - 1));
          fromValue = (toValue - 1);
        } else if(currentlySliding == 'to' && toValue <= fromValue){
          toSlider.val((fromValue + 1)); 
          toValue = (fromValue + 1);
        }
  
        // Updating the output values so they mirror the current slider's value
        outputElemFrom.html(fromValue);
        outputElemTo.html(toValue);
  
        // Caluculating and setting the progressbar widths    
        $('.progressbar_from').css('width', ((fromSlider.width() / parseInt(fromSlider[0].max)) * fromSlider[0].value)  + "px");
        $('.progressbar_to').css('width', (toSlider.width() - ((toSlider.width() / parseInt(toSlider[0].max)) * toSlider[0].value))  + "px");
    
}