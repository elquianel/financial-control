$('#hasStock').on('change', function(){
    let stock = $('#hasStock').val();
    // alert(stock);

    if(stock == 'yes'){
        let stock = $('.add_qtd').hasClass('d-none');
        $('.add_qtd').removeClass('d-none');
    }else{
        $('.add_qtd').addClass('d-none')
    }
}) 