$('body').on('change', '.jsClickFactorBtn', function() {
        var btn = $(this).attr('data-btn');
        
        var par = $('#jsSelect1').val();
        var par2 = $('#jsSelect2').val();
        
        if (par != '' && par2 != '') {
            $(btn).click();
        }
});