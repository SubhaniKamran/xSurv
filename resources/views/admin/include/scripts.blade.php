<script>
    $(document).ready(function () {
      MakeDataTable('table_admin_templates');
      MakeDataTable('table_companies_surveys');
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    tinyMCE.init({
        //mode : "textareas",
        mode : "specific_textareas",
        editor_selector : "myTextEditor",
          plugins: [
            "code table"
          ],
          menubar: "format table tools",
    });

    function MakeDataTable(id) {
        let Element = $("#" + id);
        if(Element.length){
            Element.DataTable();
        }
    }

    function ViewSurveyQuestions(Questions) {
        let Rows = '';
        for (let i = 0; i < Questions.length; i++){
            let _question = Questions[i];
            _question = _question.replace("~", ",");
            Rows += '<div class="col-sm-6">' +
                '       <div class="form-group ">' +
                '           <label for="question">Question</label>' +
                '           <input id="question_' + i + '" type="text" class="form-control" name="question" placeholder="Question" value="' + _question + '" disabled />' +
                '       </div>' +
                '   </div>' +
                '   <div class="col-sm-6">' +
                '       <div class="form-group">' +
                '           <label for="answer">Answer</label>' +
                '           <input id="answer_' + i + '" readonly type="text" class="form-control" name="answer" placeholder="Answer" />' +
                '       </div>' +
                '   </div>';
        }
        $("#questionsRow").html(Rows);
        $("#viewSurveyQuestionsModal").modal('toggle');
    }

    function ViewServiceSurveyQuestions(id){
      let values = id.split('_');
      $.ajax({
          type: "post",
          url: "{{url('/service-survey')}}",
          data: {SurveyId: values[1]}
      }).done(function (data) {
          let Questions = JSON.parse(data);
          let Rows = '';
          for (let i = 0; i < Questions.length; i++){
              let _question = Questions[i];
              _question = _question.replace("~", ",");
              Rows += '<div class="col-sm-6">' +
                  '       <div class="form-group ">' +
                  '           <label for="question">Question</label>' +
                  '           <input id="question_' + i + '" type="text" class="form-control" name="question" placeholder="Question" value="' + _question + '" disabled />' +
                  '       </div>' +
                  '   </div>' +
                  '   <div class="col-sm-6">' +
                  '       <div class="form-group">' +
                  '           <label for="answer">Answer</label>' +
                  '           <input id="answer_' + i + '" readonly type="text" class="form-control" name="answer" placeholder="Answer" />' +
                  '       </div>' +
                  '   </div>';
          }
          $("#questionsRow").html(Rows);
          $("#viewSurveyQuestionsModal").modal('toggle');
      });
    }

    function ViewCustomerSurvey(id){
      let values = id.split('_');
      $.ajax({
          type: "post",
          url: "{{url('/customer-survey')}}",
          data: {CustomerServiceId: values[1]}
      }).done(function (data) {
          let Survey = JSON.parse(data);
          let Rows = '';
          if(Survey.length > 0){
            let Questions = JSON.parse(Survey[0]);
            let Answer = JSON.parse(Survey[1]);
            for (let i = 0; i < Questions.length; i++){
                let answer =  '';
                if(Answer !== null){
                  if(typeof Answer[i] === 'undefined')
                  {
                    answer = '';
                  }
                  else {
                    answer = Answer[i];
                  }
                }
                let _question = Questions[i];
                _question = _question.replace("~", ",");
                Rows += '<div class="col-sm-6">' +
                    '       <div class="form-group ">' +
                    '           <label for="question">Question</label>' +
                    '           <input id="question_' + i + '" type="text" class="form-control" name="question" placeholder="Question" value="' + _question + '" disabled />' +
                    '       </div>' +
                    '   </div>' +
                    '   <div class="col-sm-6">' +
                    '       <div class="form-group">' +
                    '           <label for="answer">Answer</label>' +
                    '           <input id="answer_' + i + '" readonly type="text" class="form-control" name="answer" value="' + answer + '" placeholder="Answer" />' +
                    '       </div>' +
                    '   </div>';
            }
          }
          $("#questionsRow").html(Rows);
          $("#viewSurveyQuestionsModal").modal('toggle');
      });
    }

    /* Company - Start */
    function confirmDelete(id) {
        $("#deleteCompanyModal").modal('toggle');
        $("#deleteCompanyId").val(id);
    }

    function confirmDeleteCompany()
    {
      let id = $("#deleteCompanyId").val();
      $("#deleteCompanyModal").modal('toggle');
      document.getElementById('delete-company-'+id).submit();
    }
    /* Company - End */

    /* Template - Start */
    function adminTemplateDelete(id) {
        $("#deleteSurveyModal").modal('toggle');
        $("#deleteSurveyId").val(id);
    }

    function confirmAdminTemplateDelete()
    {
      let id = $("#deleteSurveyId").val();
      $("#deleteSurveyModal").modal('toggle');
      document.getElementById('delete-survey-'+id).submit();
    }
    /* Template - End */

    /* Package - Start */
    function adminPackageDelete(id) {
      $("#deletePackageModal").modal('toggle');
      $("#deletePackageId").val(id);
    }

    function confirmAdminPackageDelete()
    {
      let id = $("#deletePackageId").val();
      $("#deletePackageModal").modal('toggle');
      document.getElementById('delete-package-'+id).submit();
    }
    /* Package - End */

    /* General Settings Logo - Start */
    function editGeneralSettingsLogo(id)
    {
      $("#editGeneralSettingsLogoModal").modal('toggle');
      $("#editGeneralSettingsLogoId").val(id);
    }

    /* General Settings Logo - End */
</script>
