<script>
    $(document).ready(function () {
        MakeDataTable('table_surveys');
        MakeDataTable('table_templates');
        MakeDataTable('table_company_activepackage');
        MakeServicesTable();
        MakeCustomerTable();
        MakeGoogleReviewUrlTable();
        MakeCustomerServicesDetailsTable();
        MakeEmailManagementSchedulingTable();
        MakeEmailManagementPendingTable();
        MakeEmailManagementSentTable();
        MakeEmailManagementRecordTable();
        MakeCompanyPackageHistoryTable();
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function validateCardLength(event)
    {
      let card_number = $("#card_number").val();
      if(card_number.length > 15){
        event.preventDefault();
      }
    }

    function validateExpiryMonthLength(event)
    {
      let expiry_month = $("#expiry_month").val();
      if(expiry_month.length > 1){
        event.preventDefault();
      }
    }

    function validateCVCLength(event)
    {
      let cvc = $("#cvc").val();
      if(cvc.length > 2){
        event.preventDefault();
      }
    }

    function validateExpiryYearLength(event)
    {
      let expiry_year = $("#expiry_year").val();
      if(expiry_year.length > 3){
        event.preventDefault();
      }
    }

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

    function confirmDeleteSurvey(id) {
        $('#deleteSurveyId').val(id);
        $("#deleteSurveyModal").modal('toggle');
    }

    function confirmDeleteSurvey2() {
        let id = $('#deleteSurveyId').val();
        window.open('{{url('/survey/delete')}}' + "/" + id, '_self');
    }

    /* Services - Start */
    function MakeServicesTable() {
        if ($("#table_services")) {
            $("#table_services").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": false,
                "ajax": {
                    "url": "{{url('/services-all')}}",
                    "type": "POST"
                }
            });
        }
    }
    function deleteService(id) {
        let values = id.split('_');
        $("#deleteServiceId").val(values[1]);
        $("#deleteServiceModal").modal('toggle');
    }
    function confirmDeleteService() {
        let ServiceId = $("#deleteServiceId").val();
        $.ajax({
            type: "post",
            url: "{{url('/service-delete')}}",
            data: {ServiceId: ServiceId}
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $("#deleteServiceModal").modal('toggle');
                $("#success-message-content").text("Service Deleted Successfully");
                $("#success-message").show();
                $("#error-message").hide();
                $('#table_services').DataTable().ajax.reload();
                setTimeout(function () {
                    $("#success-message-content").text("");
                    $("#success-message").slideUp();
                    $("#error-message").hide();
                }, 2500);
            } else {
                $("#deleteServiceModal").modal('toggle');
                $("#error-message-content").text("An Unhandled Error Occurred");
                $("#success-message").hide();
                $("#error-message").show();
                $('#table_services').DataTable().ajax.reload();
                setTimeout(function () {
                    $("#error-message-content").text("");
                    $("#success-message").hide();
                    $("#error-message").slideUp();
                }, 2500);
            }
        });
    }

    function banService(id){
      let values = id.split('_');
      $.ajax({
          type: "post",
          url: "{{url('/service-ban')}}",
          data: {ServiceId: values[1]}
      }).done(function (data) {
          if (jQuery.trim(data) === 'Success') {
              $("#success-message-content").text("Service Updated Successfully");
              $("#success-message").show();
              $("#error-message").hide();
              $('#table_services').DataTable().ajax.reload();
              setTimeout(function () {
                  $("#success-message-content").text("");
                  $("#success-message").slideUp();
                  $("#error-message").hide();
              }, 2500);
          } else {
              $("#error-message-content").text("An Unhandled Error Occurred");
              $("#success-message").hide();
              $("#error-message").show();
              $('#table_services').DataTable().ajax.reload();
              setTimeout(function () {
                  $("#error-message-content").text("");
                  $("#success-message").hide();
                  $("#error-message").slideUp();
              }, 2500);
          }
      });
    }

    function activeService(id){
      let values = id.split('_');
      $.ajax({
          type: "post",
          url: "{{url('/service-active')}}",
          data: {ServiceId: values[1]}
      }).done(function (data) {
          if (jQuery.trim(data) === 'Success') {
              $("#success-message-content").text("Service Updated Successfully");
              $("#success-message").show();
              $("#error-message").hide();
              $('#table_services').DataTable().ajax.reload();
              setTimeout(function () {
                  $("#success-message-content").text("");
                  $("#success-message").slideUp();
                  $("#error-message").hide();
              }, 2500);
          } else {
              $("#error-message-content").text("An Unhandled Error Occurred");
              $("#success-message").hide();
              $("#error-message").show();
              $('#table_services').DataTable().ajax.reload();
              setTimeout(function () {
                  $("#error-message-content").text("");
                  $("#success-message").hide();
                  $("#error-message").slideUp();
              }, 2500);
          }
      });
    }

    function editService(id){
      let values = id.split('_');
      let form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "{{ url('/service-edit') }}");
      let hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "_token");
      hiddenField.setAttribute("value", "{{ csrf_token() }}");
      form.appendChild(hiddenField);
      hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "ServiceId");
      hiddenField.setAttribute("value", values[1]);
      form.appendChild(hiddenField);
      document.body.appendChild(form);
      form.submit();
    }
    /* Services - End */

    /* Customers - Start */
    function MakeCustomerTable() {
        if ($("#table_customers")) {
            $("#table_customers").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": false,
                "ajax": {
                    "url": "{{url('/customers-all')}}",
                    "type": "POST"
                }
            });
        }
    }
    function MakeCustomerServicesDetailsTable(){
      let CustomerId = $('#view_customerId').val();
      if ($("#table_customers_services_details")) {
          $("#table_customers_services_details").DataTable({
              "processing": true,
              "serverSide": true,
              "paging": true,
              "bPaginate": true,
              "ordering": false,
              "ajax": {
                  "url": "{{url('/customerservice-view')}}",
                  "type": "POST",
                  "data": {CustomerId: CustomerId}
              }
          });
      }
    }
    function deleteCustomer(id) {
        let values = id.split('_');
        $("#deleteCustomerId").val(values[1]);
        $("#deleteCustomerModal").modal('toggle');
    }
    function confirmDeleteCustomer() {
        let CustomerId = $("#deleteCustomerId").val();
        $.ajax({
            type: "post",
            url: "{{url('/customer-delete')}}",
            data: {CustomerId: CustomerId}
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $("#deleteCustomerModal").modal('toggle');
                $("#success-message-content").text("Customer Deleted Successfully");
                $("#success-message").show();
                $("#error-message").hide();
                $('#table_customers').DataTable().ajax.reload();
                setTimeout(function () {
                    $("#success-message-content").text("");
                    $("#success-message").slideUp();
                    $("#error-message").hide();
                }, 2500);
            } else {
                $("#deleteCustomerModal").modal('toggle');
                $("#error-message-content").text("An Unhandled Error Occurred");
                $("#success-message").hide();
                $("#error-message").show();
                $('#table_customers').DataTable().ajax.reload();
                setTimeout(function () {
                    $("#error-message-content").text("");
                    $("#success-message").hide();
                    $("#error-message").slideUp();
                }, 2500);
            }
        });
    }

    function banCustomer(id){
      let values = id.split('_');
      $.ajax({
          type: "post",
          url: "{{url('/customer-ban')}}",
          data: {CustomerId: values[1]}
      }).done(function (data) {
          if (jQuery.trim(data) === 'Success') {
              $("#success-message-content").text("Customer Updated Successfully");
              $("#success-message").show();
              $("#error-message").hide();
              $('#table_customers').DataTable().ajax.reload();
              setTimeout(function () {
                  $("#success-message-content").text("");
                  $("#success-message").slideUp();
                  $("#error-message").hide();
              }, 2500);
          } else {
              $("#error-message-content").text("An Unhandled Error Occurred");
              $("#success-message").hide();
              $("#error-message").show();
              $('#table_customers').DataTable().ajax.reload();
              setTimeout(function () {
                  $("#error-message-content").text("");
                  $("#success-message").hide();
                  $("#error-message").slideUp();
              }, 2500);
          }
      });
    }

    function activeCustomer(id){
      let values = id.split('_');
      $.ajax({
          type: "post",
          url: "{{url('/customer-active')}}",
          data: {CustomerId: values[1]}
      }).done(function (data) {
          if (jQuery.trim(data) === 'Success') {
              $("#success-message-content").text("Customer Updated Successfully");
              $("#success-message").show();
              $("#error-message").hide();
              $('#table_customers').DataTable().ajax.reload();
              setTimeout(function () {
                  $("#success-message-content").text("");
                  $("#success-message").slideUp();
                  $("#error-message").hide();
              }, 2500);
          } else {
              $("#error-message-content").text("An Unhandled Error Occurred");
              $("#success-message").hide();
              $("#error-message").show();
              $('#table_customers').DataTable().ajax.reload();
              setTimeout(function () {
                  $("#error-message-content").text("");
                  $("#success-message").hide();
                  $("#error-message").slideUp();
              }, 2500);
          }
      });
    }

    function editCustomer(id){
      let values = id.split('_');
      let form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "{{ url('/customer-edit') }}");
      let hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "_token");
      hiddenField.setAttribute("value", "{{ csrf_token() }}");
      form.appendChild(hiddenField);
      hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "CustomerId");
      hiddenField.setAttribute("value", values[1]);
      form.appendChild(hiddenField);
      document.body.appendChild(form);
      form.submit();
    }

    function viewCustomer(id){
      let values = id.split('_');
      let form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "{{ url('/customer-view') }}");
      let hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "_token");
      hiddenField.setAttribute("value", "{{ csrf_token() }}");
      form.appendChild(hiddenField);
      hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "CustomerId");
      hiddenField.setAttribute("value", values[1]);
      form.appendChild(hiddenField);
      document.body.appendChild(form);
      form.submit();
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

    function addCustomerNewService(id)
    {
      let values = id.split("_");
      $("#serviceCustomerId").val(values[1]);
      $.ajax({
          type: "post",
          url: "{{url('/service/all')}}",
          data: {}
      }).done(function (data) {
          let services = JSON.parse(data);
          let options = '';
          for(let i=0; i < services.length; i++){
            options +=
            '<option value="'+ services[i].id +'">'+ services[i].service_name +'</option>';
          }
          $("#_service").html('').append(options);
          $("#addNewCustomerServiceModal").modal('toggle');
      });
    }
    /* Customers - End */

    /* Google Review URL - Start */
    function MakeGoogleReviewUrlTable() {
        if ($("#table_google_url")) {
            $("#table_google_url").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": false,
                "ajax": {
                    "url": "{{url('/googlereview-all')}}",
                    "type": "POST"
                }
            });
        }
    }

    function editGoogleReviewUrl(id) {
        let values = id.split('_');
        $("#editGoogleReviewUrlId").val(values[1]);
        $("#editGoogleReviewUrlModal").modal('toggle');
    }

    function updateGoogleReviewUrl() {
      let GoogleReviewUrlId = $("#editGoogleReviewUrlId").val();
      let Url = $("#edit_google_url").val();
      if(Url !== ''){
        $.ajax({
            type: "post",
            url: "{{url('/googlereview/update')}}",
            data: {GoogleReviewUrlId: GoogleReviewUrlId, Url: Url}
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $("#editGoogleReviewUrlModal").modal('toggle');
                $("#success-message-content").text("Google Review Url Successfully");
                $("#success-message").show();
                $("#error-message").hide();
                $('#table_google_url').DataTable().ajax.reload();
                setTimeout(function () {
                    $("#success-message-content").text("");
                    $("#success-message").slideUp();
                    $("#error-message").hide();
                }, 2500);
            } else {
                $("#editGoogleReviewUrlModal").modal('toggle');
                $("#error-message-content").text("An Unhandled Error Occurred");
                $("#success-message").hide();
                $("#error-message").show();
                $('#table_google_url').DataTable().ajax.reload();
                setTimeout(function () {
                    $("#error-message-content").text("");
                    $("#success-message").hide();
                    $("#error-message").slideUp();
                }, 2500);
            }
        });
      }
      else {
        $("#editGoogleReviewUrlModal").modal('toggle');
      }
    }
    /* Google Review URL - End */

    /* Emails Management Scheduling - Start */
    function MakeEmailManagementSchedulingTable() {
        if ($("#table_emails_schedule")) {
            $("#table_emails_schedule").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": false,
                "ajax": {
                    "url": "{{url('/scheduling/all')}}",
                    "type": "POST"
                }
            });
        }
    }
    function editCustomerServiceEmailDate(id)
    {
      let values = id.split('_');
      $("#editCustomerServiceId").val(values[1]);
      $("#editEmailScheduleModal").modal('toggle');
    }
    function updateCustomerServiceEmailDate() {
      let CustomerServiceId = $("#editCustomerServiceId").val();
      let EmailDate = $("#edit_email_date").val();
      if(EmailDate !== ''){
        $.ajax({
            type: "post",
            url: "{{url('/scheduling/update')}}",
            data: {CustomerServiceId: CustomerServiceId, EmailDate: EmailDate}
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $("#editEmailScheduleModal").modal('toggle');
                $("#success-message-content").text("Email Date Updated Successfully");
                $("#success-message").show();
                $("#error-message").hide();
                $("#edit_email_date").val('');
                $('#table_emails_schedule').DataTable().ajax.reload();
                setTimeout(function () {
                    $("#success-message-content").text("");
                    $("#success-message").slideUp();
                    $("#error-message").hide();
                }, 2500);
            } else {
                $("#editEmailScheduleModal").modal('toggle');
                $("#error-message-content").text("An Unhandled Error Occurred");
                $("#success-message").hide();
                $("#error-message").show();
                $("#edit_email_date").val('');
                $('#table_emails_schedule').DataTable().ajax.reload();
                setTimeout(function () {
                    $("#error-message-content").text("");
                    $("#success-message").hide();
                    $("#error-message").slideUp();
                }, 2500);
            }
        });
      }
      else {
        $("#table_emails_schedule").modal('toggle');
      }
    }
    /* Emails Management Scheduling - End */

    /* Emails Management Pending - Start */
    function MakeEmailManagementPendingTable() {
        if ($("#table_emails_pending")) {
            $("#table_emails_pending").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": false,
                "ajax": {
                    "url": "{{url('/pending/all')}}",
                    "type": "POST"
                }
            });
        }
    }
    /* Emails Management Pending - End */

    /* Emails Management Sent - Start */
    function MakeEmailManagementSentTable() {
        if ($("#table_emails_sent")) {
            $("#table_emails_sent").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": false,
                "ajax": {
                    "url": "{{url('/sent/all')}}",
                    "type": "POST"
                }
            });
        }
    }
    /* Emails Management Sent - End */

    /* Emails Management Sent - Start */
    function MakeEmailManagementRecordTable() {
        if ($("#table_emails_record")) {
            $("#table_emails_record").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": false,
                "ajax": {
                    "url": "{{url('/record/all')}}",
                    "type": "POST"
                }
            });
        }
    }
    /* Emails Management Sent - End */

    /* Company Packages History - Start */
    function MakeCompanyPackageHistoryTable()
    {
      if ($("#table_company_package_history")) {
          $("#table_company_package_history").DataTable({
              "processing": true,
              "serverSide": true,
              "paging": true,
              "bPaginate": true,
              "ordering": false,
              "ajax": {
                  "url": "{{url('/company/packages/history')}}",
                  "type": "POST"
              }
          });
      }
    }

    function viewCompanyPackageInvoice(id)
    {
      let form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "{{ url('/company/package/invoice') }}");
      let hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "_token");
      hiddenField.setAttribute("value", "{{ csrf_token() }}");
      form.appendChild(hiddenField);
      hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "TransactionId");
      hiddenField.setAttribute("value", id);
      form.appendChild(hiddenField);
      document.body.appendChild(form);
      form.submit();
    }
    /* Company Packages History - End */

    /* Email Scheduling Dates Setting - Start */
    function CreateEmailDate1(value)
    {
      if(value === '')
      {
        $("#email_date2").prop('disabled', true);
        $("#email_date3").prop('disabled', true);
        $("#email_date4").prop('disabled', true);
        $("#email_date2").val('');
        $("#email_date3").val('');
        $("#email_date4").val('');
      }
      else
      {
        $("#email_date2").prop('disabled', false);
      }
    }

    function CreateEmailDate2(value)
    {
      if(value === '')
      {
        $("#email_date3").prop('disabled', true);
        $("#email_date4").prop('disabled', true);
        $("#email_date3").val('');
        $("#email_date4").val('');
      }
      else
      {
        $("#email_date3").prop('disabled', false);
      }
    }

    function CreateEmailDate3(value)
    {
      if(value === '')
      {
        $("#email_date4").prop('disabled', true);
        $("#email_date4").val('');
      }
      else
      {
        $("#email_date4").prop('disabled', false);
      }
    }

    function CreateEmailDate4()
    {

    }
    /* Email Scheduling Dates Setting - End */
</script>
