
$(document).ready(function(){
  $('form').preventDoubleSubmission();
});

var taskId;
var repeat = 10;
var editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");
editor.session.setMode("ace/mode/csharp");
editor.setFontSize(14);

var submitButton = $("#submit-code-button");

// load translation from twig data markup

document.addEventListener('DOMContentLoaded', function() {
  taskId = $('.js-app-data').data('taskId');
  yourScore = $('.js-app-data').data('labelYourScore');
  requestFailed = $('.js-app-data').data('labelRequestFailed');
  unitTestReport = $('.js-app-data').data('labelUnitTestReport');
  test = $('.js-app-data').data('labelTest');
  labelFunction = $('.js-app-data').data('labelFunction');
  labelExecuted = $('.js-app-data').data('labelExecuted');
  labelExpected = $('.js-app-data').data('labelExpected');
  labelErrors = $('.js-app-data').data('labelErrors');
  labelErrorId = $('.js-app-data').data('labelErrorId');
  labelErrorLine = $('.js-app-data').data('labelErrorLine');
  labelErrorType = $('.js-app-data').data('labelErrorType');
  labelErrorMessage = $('.js-app-data').data('labelErrorMessage');
  labelExecutionError = $('.js-app-data').data('labelExecutionError');
  labelExecutionErrorMessage = $('.js-app-data').data('labelExecutionErrorMessage');
});

submitButton.click(function (e) {
  e.preventDefault();
  repeat = 10;
  submitButton.prop("disabled",true);

  $.ajax({
    type: "POST",
    contentType: 'application/ld+json; charset=utf-8',
    url: "/api/task_submits",
    data: JSON.stringify({
      'taskId': taskId,
      'code': editor.getValue(),
      'language': 'cs',
      'type': 'code'
    }),
    beforeSend: function () {
      $('#loader').removeClass('hidden');
      $('#submitResult').fadeOut();
      $('#errorList').html("");
      $('#resultList').html("");
    },
    success: function (data) {
      setTimeout(check.bind(this, data.id), 3000);
    },
    error: function (result) {
      $('#loader').addClass('hidden');
      submitButton.prop("disabled",false);
      errorList.html('<div class = "alert alert-danger" > ' + requestFailed );
      if (result.responseJSON !== undefined)
        errorList.children("div").append(' <code>' + result.responseJSON + '</code></div>');
      var errorList = $('#errorList');
    }
  });
});

function check(id)
{
  $.getJSON('/api/task_submits/'+id, function(data)
  {
    console.log(data);
    if (data["evaluated"] != 1)
    {
      if(--repeat > 0)
      {
        // wait another 1 s until evaluated
        setTimeout(check.bind(this, id), 1000);
      }
      else
      {
        $('#loader').addClass('hidden');
        submitButton.prop("disabled",false);
        $('#errorList').html('<div class="alert alert-danger">'+ requestFailed +'</div>');
      }
    }
    else
    {
      $("#upload_form").trigger('reset');
      $('#loader').addClass('hidden');
      $('.alert-no-submissions').hide();
      submitButton.prop("disabled",false);

      if (isNaN(data.score))
      {
        $('#errorList').html('<div class="alert alert-danger">'+ requestFailed +'</div>');
      }

      var score = Math.round(data.score * 100);

      var scoreContainerContent = '<div id="score-container" class="alert" role="alert">' +
        '<h3 align="center">' + yourScore + ': ' + score + '%.</h3> ' +
        '<div class="col-xs-12 col-sm-12 progress-container">' +
        '<div class="progress progress-striped active">' +
        '<div class="progress-bar progress-bar-score bg-success" style="width:0%"></div>' +
        '</div>' +
        '</div>' +
        '</div>';

      var list = $('#submitResult').html(scoreContainerContent).fadeIn();
      var progressBar = $(".progress-bar-score");
      var scoreContainer = $("#score-container");

      if (score === 100) {
        scoreContainer.addClass("alert-success");
        progressBar.addClass("bg-success");
      }

      if (score >= 50 && score < 100) {
        scoreContainer.addClass("alert-warning");
        progressBar.addClass("bg-warning");
      }

      if (score < 50 ) {
        scoreContainer.addClass("alert-danger");
        progressBar.addClass("bg-danger");
      }

      progressBar.animate({
        width: score+ "%"
      }, 2500);

      if (data.errorList.length > 0)
      {
        var elist = parseErrorData(data.errorList);
        var x = 0;
        (function displayErrors() {
          elist.eq(x++).fadeIn(500, displayErrors);
        })();
      }

      if (data.testList.length > 0)
      {
        var tlist = parseTestData(data.testList);
        var i = 0;
        // animate displaying tests - 1 test every 0.5 seconds
        (function displayTests() {
          tlist.eq(i++).fadeIn(500, displayTests);
        })(); // directly execute anonymous function
      }

      var style = "danger";

      if (score > 50 )
        style = "warning";
      if (score == 100)
        style = "success";

      var tableRow = '<tr class="submit-report table-'
        + style + '">'
        + '<td class="align-middle">'+ data.uploadDate + '</td>'
        + '<td class="align-middle">'
        + '<code>'+ data.codeLanguage +'</code>'
        + '</td>'
        + '<td class="align-middle">'
        + '   <div class="progress">'
        + '        <div class="progress-bar bg-' + style
        + '" role="progressbar" style="width: '
        + score + '%" aria-valuenow="'
        + score + '" aria-valuemin="0" aria-valuemax="100">'
        + score + '%</div>'
        + '    </div>'
        + '    </td>'
        + '   </tr>';

      $('.table').prepend(tableRow);

      $('html,body').animate({
          scrollTop: $("#submitResult").offset().top},
        'slow');

    }
    $('[data-toggle="tooltip"]').tooltip();
  });
}

function parseTestData(testList)
{
  let reportHeader = '<h3>'+ unitTestReport +'</h3>';
  $('#resultList').html(reportHeader);

  let resultList = "", img = "", show = "";
  for (let i = 0; i < testList.length; i++)
  {
    if (testList[i].points == 1)
    {
      img = "i_ok"; // set green mark for a test
      show = ""; // don't expand test data
    }
    else
    {
      img = "i_nok"; // set red mark for a test
      show = "show"; // expand test data
    }

    resultList += '<div class="accordion-item">'
      +'  <h2 class="accordion-header" id="panel-heading' + i + '">'
      + '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' + i + '" aria-expanded="true" aria-controls="collapse' + i + '">'

      + test + ' ' + testList[i].id;

    if (testList[i].points == 1)
      resultList +='&nbsp; <i class="fas fa-check" style="color:green"></i>';
    else
      resultList +='&nbsp; <i class="fas fa-times" style="color:red"></i>';

    resultList += '</button>'
    resultList += '</h2>'
    resultList += '<div id="collapse' + i + '" class="accordion-collapse collapse '+show+'" aria-labelledby="panel-heading' + i + '" >'
    resultList += '<div class="accordion-body">'

    resultList += '<p>';

    if(testList[i].expectedMethod != null)
      resultList += labelFunction +': <code>' + testList[i].expectedMethod + "</code><br>";
    if(testList[i].executedMethod != null)
      resultList += labelExecuted +': <code>' + testList[i].executedMethod + "</code><br>";
    if(testList[i].expectedValue != null)
      resultList += labelExpected +': <code>' + testList[i].expectedValue + "</code>&nbsp;";

    resultList += '&nbsp;<img src="/img/'+img+'.png">';

    if(testList[i].failureMessage != null)
      resultList += '<br>'+ labelExecutionError +': <code>' + testList[i].failureMessage + "</code><br>"
    if(testList[i].failureExceptionType != null)
      resultList += '<br>'+ labelExecutionErrorMessage +': <code>' + testList[i].failureExceptionType + "</code><br>"

    resultList += '</p>';
    resultList += '</div>'; // close accordion-body
    resultList += '</div>'; // close collapse
    resultList += '</div>'; // close accordion item

  }

  return $('#accordion').html(resultList).children().hide();
}

function parseErrorData(errorList)
{
  let errortList = "";
  for (let i = 0; i < errorList.length; i++)
  {
    if(i == 0)
      errortList += '<h3>'+labelErrors+'</h3>';

    var alertType = "alert-warning";

    if (errorList[i].type == "error")
      alertType = "alert-danger";

    errortList += '<div id="result">'
      + '<div class="alert '+ alertType +'">'
      + '<img src="/img/i_nok.png">' + "&nbsp;";
    if(errorList[i].id != null)
      errortList += labelErrorId + ': <code>' + errorList[i].id + "</code>&nbsp;";

    if(errorList[i].line != null)
      errortList += labelErrorLine +': <code>' + errorList[i].line + "</code>"+ "&nbsp;";

    if(errorList[i].type != null)
      errortList += labelErrorType +': <code>' + errorList[i].type + "</code>"+ "&nbsp;";

    if(errorList[i].message != null)
      errortList += labelErrorMessage +': <code>' + errorList[i].message + "</code>";

    if(errorList[i].value != null)
      errortList += ': <code>' + errorList[i].value + "</code>";

    errortList +="</div></div>";
  }

  var editor = ace.edit("editor");

  var Range = ace.require('ace/range').Range; // get reference to ace/range

  var markers = [];
  for (let i = 0; i < errorList.length; i++)
  {
    if(errorList[i].line != null)
      markers.push(editor.session.addMarker(new Range(errorList[i].line-1, 0, errorList[i].line-1, 1), "ace-highlight-error-line", "fullLine"));
  }

  editor.getSession().on('change', function() {
    for (let x in markers) {
      editor.session.removeMarker(markers[x]);
    }
  });

  return  $('#errorList').html(errortList).children().hide();
}

function openNav() {
  document.getElementById("module_nav").style.width = "250px";
}

function closeNav() {
  document.getElementById("module_nav").style.width = "0";
}

jQuery.fn.preventDoubleSubmission = function() {
  $(this).on('submit',function(e){
    var $form = $(this);

    if ($form.data('submitted') === true) {
      e.preventDefault();
    } else {
      $form.data('submitted', true);
    }
  });

  return this;
};

$('.openBtn').on(
  'click', function () {
    $("#"+$(this).val()).show();
    $("#"+$(this).val()).appendTo("body");

  });
$('.closeBtn').on(
  'click', function () {
    $("#"+$(this).val()).hide();
  });

$(document).ready(function(){

  $('[data-toggle="tooltip"]').tooltip();

});
