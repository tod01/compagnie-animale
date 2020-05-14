window.onload = function () {
    $(document).ready(function () {

        $(".dropdown-especes div a").click(function () {
            let w = $(".dropdown-especes").width();
            $(".dropdown-especes div a").removeClass("active");
            $(".dropdown-especes button").text($(this).text()).css("width", w);
            $(this).addClass("active");

            /*if ($(this).hasClass("by-default")) {
                $("#div-form-control-race").hide();
            } else {
                $("#div-form-control-race").show();
            }*/
        });


        $("#radio-announcements").click(function () {
            $("#radio-eleveurs").removeAttr("checked");
            $(this).attr("checked", "");
            $(".btn-group-toggle-type").show();

            if ($("#radio-ventes").attr("checked")) {
                $(".btn-prix").show();
            }
        });

        $("#radio-eleveurs").click(function () {
            $("#radio-announcements").removeAttr("checked");
            $(this).attr("checked", "");
            $(".btn-group-toggle-type").hide();
            $(".btn-prix").hide();
        });

        $("#radio-ventes").click(function () {
            $("#radio-dons").removeAttr("checked");
            $(this).attr("checked", "");
            $(".btn-prix").show();
        });

        $("#radio-dons").click(function () {
            $("#radio-ventes").removeAttr("checked");
            $(this).attr("checked", "");
            $(".btn-prix").hide();
        });

        $(".option-select").click(function () {
            let specie = $(this).text();
        })

        /*$(".slider").slider({
            range: true,
            orientation: "horizontal",
            min: 0,
            max: 2000,
            step : 5,
            values: [0, 2000]
        });*/


        /*$("#form-search").submit(function (event) {
            if($(".card-search").has(".words-search").length === 0) {
                $(".card-search").append("<div class='words-search d-flex flex-wrap'></div>");
            }
            //$('.words-search').html("");
            let words = $('.form-control-key-words').val();
            let races = $('.form-control-key-words-races').val();
            $('.form-control-key-words').val("");
            $('.form-control-key-words-races').val("");
            let wordsArray = words.split(" ")
            let racesArray = races.split(" ");
            wordsArray = racesArray.concat(wordsArray);
            wordsArray.forEach(function (word) {
                if (word.length) {
                    $('.words-search').append("<div class='alert alert-primary alert-dismissible alert-search' role='alert'>" +
                        word +
                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                        "<span aria-hidden='true'>&times;</span></button>" +
                        "</div>");
                }
            });
        });*/
    });
};

