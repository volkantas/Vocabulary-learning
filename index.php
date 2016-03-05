<!DOCTYPE html>

<html>
   <head>
       <title>Karışık Soru - Kelime Listesi | İngilizce - Türkçe | Mobile</title>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="HandheldFriendly" content="True">
       <meta name="MobileOptimized" content="320">
       <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0">
       <script src="js/jquery-1.10.2.min.js"></script>
       <script src="js/handlebars.js"></script>
       <script src="js/main.js"></script>
       <link rel="stylesheet" type="text/css" href="css/main.css">
   </head>
    <body ontouchstart="">
    <div id="preloader"></div>
    <div class="container-question-answer">
        <!-- entry-template -->
    </div>
    </body>
</html>

<script id="entry-template" type="text/x-handlebars-template">
    <div class="question">
        {{question}}
    </div>
    <hr>
    <div class="container-answer">
        {{#each answers}}
        <a data-id="{{this.id}}" href="#">
            <div class="answer">
                {{this.text}}
            </div>
        </a>
        {{/each}}
        <div id="unwanted-container">
            <label for="unwanted" onclick="">
                <input id="unwanted" type="checkbox">
                Bu oturumda bir daha sorma. ({{countQuestionLeft}}/{{totalRowInExcel}})
            </label>
        </div>
    </div>

</script>

<script id="correct-answer-template" type="text/x-handlebars-template">
    <div class="question">
        {{question}}
    </div>
    <hr>
    <div class="question">
        {{correctAnswer}}
    </div>

</script>