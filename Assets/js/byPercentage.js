$('#by_percentage').on('change', function(){
    let per = $('#by_percentage').val();

    if(per == 'yes'){
        let per = $('.add_per').hasClass('d-none');
        $('.add_per').removeClass('d-none');
        $('.hideValue').addClass('d-none');
    }else{
        $('.add_per').addClass('d-none');
        $('.hideValue').removeClass('d-none');
    }
}) 