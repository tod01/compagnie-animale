var path = window.location.pathname;
var page = path.split("/").pop();


if(page == 'offers') {


    (function(){
        // Get inputs by container
        
        $('.double-slider input[type="range"]').on('input', function(e){    
            // Split the elements From/To Slider and From/To values so you can handle them separtely 
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
        
        });
      })();

    $(function(){
        $("[data-toggle=popover]").popover({
            html : true,
            content: function() {
              var content = $(this).attr("data-popover-content");
              return $(content).children(".popover-body").html();
            },
            title: function() {
              var title = $(this).attr("data-popover-content");
              return $(title).children(".popover-heading").html();
            }
        });
    });
}

if(page == 'ads') {
    let nbr_of_pictures = 0;
    const ALLOWED_PICTURES = 2;

    function disable_price() {
        console.log('tod')
    }

    function add_picture() {

       // '<div class="col-sm-2 imgUp"><div class="imagePreview">' +
        //'</div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>'

        let parentDiv = document.querySelector('.allPictures');
        let originalDiv = document.querySelector('.imgUp');

        let new_node = creation('div', 'class', 'col-md-7 col-lg-5 col-sm-8 imgUp');
        let new_node_content = creation('div', 'class', 'imagePreview');

        let label = creation('label', 'class', 'btn btn-primary btn-upload');
        label.appendChild( document.createTextNode('Upload'));
        let input = creation('input', 'type', 'file');

        input.setAttribute('class', 'uploadFile img');
        input.setAttribute('name', 'uploaded_file');
        input.setAttribute('value', 'Upload Photo');
        input.setAttribute('style', "width:0px;height:0px;overflow:hidden;");
        input.setAttribute('onchange', 'upload_file(this)');

        label.appendChild(input);

        new_node.appendChild(new_node_content);
        new_node.appendChild(label);
        let i = creation('i', 'class', 'fa fa-times del');
        i.setAttribute('onclick', 'delButton(this.parentNode)');
        new_node.appendChild(i);

        parentDiv.insertBefore(new_node, originalDiv)
        nbr_of_pictures++;


        if(nbr_of_pictures == ALLOWED_PICTURES) {
            close_plus_button();
            return;
        }
    }


    function close_plus_button() {
        document.querySelector('.imgAdd').style.pointerEvents = "none";
    }

    function creation(element, attr, value) {
        let new_node = document.createElement(element);
        new_node.setAttribute(attr,value);

        return new_node;
    }

    function delButton(btn) {
        nbr_of_pictures--;
        btn.parentNode.removeChild(btn);
        document.querySelector('.imgAdd').style.pointerEvents = "auto";
    }


    function upload_file(btn) {

        let files = !!btn.files ? btn.files : [];

        if(!files.length || !window.FileReader) {
            console.log(files)
           return;
        }

        if(/^image/.test(files[0].type)) {
            let reader = new FileReader();
            reader.readAsDataURL(files[0]);

            reader.onloadend = function () {
                btn.closest('.imgUp').querySelector('.imagePreview').style.backgroundImage = "url("+this.result+")";
            }
        }
    }

}




/*

$(".imgAdd").click(function(){
    $(this).closest(".row").find('.imgAdd').before();
});
$(document).on("click", "i.del" , function() {
    $(this).parent().remove();
});
$(function() {
    $(document).on("change",".uploadFile", function()
    {
        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }

    });
});*/

/* to check */
/*
<input type="file" class="fileuploader" style="display: none;">
<button class="fileuploader-btn">Select a Video File</button><br>
 */
/*
jQuery(document).ready(function($){

// Click button to activate hidden file input
$('.fileuploader-btn').on('click', function(){
$('.fileuploader').click();
});

// Click above calls the open dialog box
// Once something is selected the change function will run
$('.fileuploader').change(function(){

// Create new FileReader as a variable
var reader = new FileReader();

// Onload Function will run after video has loaded
reader.onload = function(file){
var fileContent = file.target.result;
$('body').append('<video src="' + fileContent + '" width="320" height="240" controls></video>');
}

// Get the selected video from Dialog
reader.readAsDataURL(this.files[0]);

});

});
 */
