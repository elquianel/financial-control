$('.select-id-company').change(function(event){
  var id_company = event.currentTarget.value;
  $.ajax({
    url: base_url+'Company/getCompanyPhones/'+id_company,
    type:'GET',
    dataType: 'json',  
    success:function(json){
      let phones = [];
      json.forEach(item => {
        phones.push ([
          item.id_phone,
          item.contacts_name,
          item.type,
          item.phone
          ]);
      });
      if(phones.length > 1){
        $('.contact_list li').remove();        
        $( "#id_phone" ).attr( "value", phones[0][0]);
        for(let i=1; i< 4; i++){
          $('.contact_list').append(`<li class='list-group-item'>${phones[0][i]}</li>`);
        }
      }else{
        $('.contact_list li').remove();
        $( "#id_phone" ).attr( "value", phones[0][0]);
        for(let i=1; i< 4; i++){
          $('.contact_list').append(`<li class='list-group-item'>${phones[0][i]}</li>`);
        }
      }
    }
  });
  $.ajax({
    url: base_url+'Company/getCompanyAddress/'+id_company,
    type:'GET',
    dataType: 'json',  
    success:function(json){
      let address = [];
      json.forEach(item => {
        address.push ([
          item.id_address,
          item.type,
          item.address,
          item.address_number,
          item.address_comp,
          item.address_neighb,
          item.address_zipcode,
          item.address_city,
          item.address_state
          ]);
      });
      if(address.length > 1){
        $('.address_list li').remove();
        $( "#id_address" ).attr( "value", address[0][0]);
        for(let i=1; i< 9; i++){
          $('.address_list').append(`<li class='list-group-item'>${address[0][i]}</li>`);
        }
      }else{
        $('.address_list li').remove();
        $( "#id_address" ).attr( "value", address[0][0]);
        for(let i=1; i< 9; i++){
          $('.address_list').append(`<li class='list-group-item'>${address[0][i]}</li>`);
        }
      }
    }
  });
});
$('.select-id-product').change(function(event){
	var id_product = event.currentTarget.value;
	$.ajax({
		url: base_url+'Products/getProductDetail/'+id_product,
		type:'GET',
		dataType: 'json',
		success:function(json){
			console.log(json);
			$('input[name=product_price_per_unit]').val(json.price_per_unit);
			$('input[name=product_price_per_unit]').prop('min',json.price_per_unit);
		}
	});
});
$('.select-id-service').change(function(event){
  var id_service = event.currentTarget.value;  
  $.ajax({
    url: base_url+'Services/getServiceDetail/'+id_service,
    type: 'GET',
    dataType: 'json',
    success:function(jsonService){
      $('input[name=is_continuous]').val(jsonService.is_continuous);
      $('input[name=service_price]').val(jsonService.price_per_unit);
      $('input[name=service_price]').prop('min',jsonService.price_per_unit);
    }
  });
});

// EDIT PRODUCT
var editProduct = document.getElementById('editProduct')
editProduct.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var product_name = button.getAttribute('data-bs-product-name')
  var id_product = button.getAttribute('data-bs-id-product')
  var quantity_sold = button.getAttribute('data-bs-product-quantity')
  var price_per_unit = button.getAttribute('data-bs-product-price-unity')
  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  var modalTitle = editProduct.querySelector('.modal-title')
  var modalBodyInputQuantity = editProduct.querySelector('.modal-body input[name=product_quantity]')
  var modalBodyInputPriceUnit = editProduct.querySelector('.modal-body input[name=product_price_per_unit]')
  $('#editProductForm').attr('action', base_url+'Orders/editProduct/'+id_product);

  modalTitle.textContent = 'Alterando ' + product_name
  modalBodyInputQuantity.value = quantity_sold
  modalBodyInputPriceUnit.value = price_per_unit
});
// END EDIT PRODUCT

// EDIT SERVICE
var editService = document.getElementById('editService');
editService.addEventListener('show.bs.modal', function(event){
  var service_button = event.relatedTarget;
  var id_service_item = service_button.getAttribute('data-bs-id-service');
  var service_name = service_button.getAttribute('data-bs-service-name');
  var is_bonus = service_button.getAttribute('data-bs-service-is-bonus');
  var service_price = service_button.getAttribute('data-bs-service-price');

  var modalTitle = editService.querySelector('.modal-title');
  var modalBodyInputBonus = editService.querySelector('.modal-body input[name=is_bonus]');
  var modalBodyInputPrice = editService.querySelector('.modal-body input[name=service_price]');
  $('#editServiceForm').attr('action', base_url+'Orders/editService/'+id_service_item);

  modalTitle.textContent = 'Alterando ' + service_name;
  modalBodyInputPrice.value = service_price;

  if($("input[type=radio][id=is_bonus1]").val() == is_bonus){
    editService.querySelector('#is_bonus1').setAttribute('checked', 'checked');
  }else{
    editService.querySelector('#is_bonus2').setAttribute('checked', 'checked');
  }
});
// END EDIT SERVICE

$("textarea").keyup(function(){
  var observation = this.value;
  var id_order = this.getAttribute('data-bs-id-order');
  $.ajax({
    url: base_url+'Orders/saveObservations/'+id_order,
    type:'POST',
    dataType: 'json',  
    data: {observations: observation},
    success:function(json){

    }
  });
});


//Salvando a empresa

$("#id_company").change(function(){
  var id_company = this.value;
  var id_order = this.getAttribute('data-com-id-order');
  $.ajax({
    url: base_url+'Orders/saveCompany/'+id_order,
    type:'POST',
    dataType: 'json',
    data: {id_company: id_company},
    success:function(json){

    }
  });
});