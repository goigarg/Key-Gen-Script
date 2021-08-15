
$("#ajaxSubmit").click(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url:'/dash/data',
        success:function(data) {
        $('#msg').val(JSON.parse(data));
        }
    });
});