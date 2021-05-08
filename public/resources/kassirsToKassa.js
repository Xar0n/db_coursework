jQuery('#formSelectKassa').on('change', function(){
    jQuery.ajax({
        url: '/api/kassirstokassa',
        method: 'post',
        data: {
            kassaSelected: $(this).val(),
        },
        success: function(result){
            kassirs = jQuery.parseJSON(result);
            document.getElementById('formSelectKassir').innerHTML = '';
            $.each(kassirs,function(index,kassir){
                document.getElementById('formSelectKassir').innerHTML = document.getElementById('formSelectKassir').innerHTML +
                    '<option value="'+kassir.id+'">'+ kassir.familiya + ' ' + kassir.imya + ' ' + kassir.otchestvo +'</option>';
            });
        }
    });
});
