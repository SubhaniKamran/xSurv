<script>
    $(document).ready(function () {
        
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    let a = '';
    function reactionChecking(id){
        let reaction = id;
        let counter = 2;
        $(".redirects").show();
        setInterval(function() {
            $(".redirects").show();
            counter = counter - 1;
            if(counter >= 0){
                $(".timeremaning").text(counter);    
            }
            if(counter === 0)
            {
                window.open('{{url('/survey/form')}}' + "/" + service + "/" + btoa(customerServiceId) + "/" + btoa(reaction), '_self');
            }
        }, 1000);
    }
</script>
