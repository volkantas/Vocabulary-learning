$(document).ready(function(){
        var context     = {question: "", correctAnswer:"" , answers: [],  id: 0}
        var showMenuFlag = false;
        var unwantedID  = null;
        getQuestion();
        $(document).on("touchend click","",function(){
            if(showMenuFlag && $(".container-answer").is(":hidden")){
                $(".container-answer").show("fast");
                setTimeout(function(){ answersClickableOn(); },1000)
            }
        });

        function answersClickableOn(){
            $(document).on("click",".container-answer a",function(event){
                event.preventDefault()
                if($(this).data("id") == context.id){
                    showMenuFlag = false;
                    context.correctAnswer = $(this).text();
                    if($("#unwanted").prop('checked')){
                        unwantedID = context.id;
                    }
                    showCorrectAnswer();
                    answersClickableOff();
                }
            });
        }
        function answersClickableOff(){
            $(document).off("click",".container-answer a");
        }

        function getQuestion(){
            $("#preloader").show();
            $(".container-question-answer").html("");
            var entryTmpSrc      = $("#entry-template").html();
            var entryTmp    = Handlebars.compile(entryTmpSrc);
            var request = $.ajax({
                url: "getWord.php",
                type: "POST",
                data: { unwantedID : unwantedID},
                dataType: "json"
            });

            request.done(function( result ) {
                $("#preloader").hide();
                if(result.result){
                    context.answers             = shuffleArray(result.answers);
                    context.question            = result.questionText;
                    context.totalRowInExcel     = result.totalRowInExcel;
                    context.countQuestionLeft   = result.countQuestionLeft
                    context.id                  = result.id;
                    var html                    = entryTmp(context);
                    $(".container-question-answer").html(html);
                    showMenuFlag        = true;
                    unwantedID          = null;
                }
                else{
                    $(".container-question-answer").html(result.message);
                }
            });
        }

        function showCorrectAnswer(){
            var entryTmpSrc      = $("#correct-answer-template").html();
            var entryTmp        = Handlebars.compile(entryTmpSrc);
            var html            = entryTmp(context);
            $(".container-question-answer").html(html).addClass("container-animate");
            setTimeout(function(){ $(".container-question-answer").removeClass("container-animate"); getQuestion() },1000)
        }

        function shuffleArray(array) {
            for (var i = array.length - 1; i > 0; i--) {
                var j = Math.floor(Math.random() * (i + 1));
                var temp = array[i];
                array[i] = array[j];
                array[j] = temp;
            }
            return array;
        }
});

