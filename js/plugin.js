$(document).ready(function(){

    let orderTotalAmount = $("#orderTotalAmount").children("span");
    let totalAmount = $("#total_amount");
    let itemCount = $("#item_count");

    console.log(orderTotalAmount);
    let i = 0;
    let count = 0;
    $(".orderTheItem").click(function(){
        i++;
        let orderButton = $(this);
        let name = $(this).parent().parent().find("#name").text();
        let price = $(this).parent().parent().find("#price").text();
        let pid = $(this).parent().parent().find("#pid").val();
        let itemPrice = parseFloat(price);
        console.log("PID ",pid);
        $(this).css('pointer-events','none');
        $(this).css('opacity','0.5');
        orderTotalAmount.html(parseFloat(orderTotalAmount.text()) + parseFloat(price));
        totalAmount.val(parseFloat(orderTotalAmount.text()));
        itemCount.val(++count);
        
     $("#orderItemContainer").append(`
     <div id="orderItem${i}" class="row product-row" style="margin: auto;">
                
     <div class="col-sm-2">${name}</div>
     <div class="col-sm-1">
         <input text="hidden" name="quantity${i}" class="badge badge-light item_quantity" value="1"/>
         <span class="badge badge-light itemQuantity">1</span>
     </div>
     <div class="col-sm-2">
         <button type="button" class="incItemQuantity btn btn-success">+</button>
     </div>
     <div class="col-sm-2">
         <button type="button" class="decItemQuantity btn btn-info">-</button>
     </div>
     <div class="col-sm-2 itemTotalAmount" >${price} </div>
     <input type="hidden" class="item_total_amount" name="item_total_amount${i}" value="${itemPrice}" />
     <div class="col-sm-2">
         <button type="button" class="removeItem btn btn-danger">X</button>
     </div>
     <input type="hidden" name="productId${i}" value=${pid}/>
    
    </div>
    ` );
    
    $(`#orderItem${i}`).find(".incItemQuantity").click( function () {
        let itemTotalAmount = $(this).parent().parent().find(".itemTotalAmount");
        let itemQuantity = $(this).parent().parent().find(".itemQuantity");
        let item_quantity = $(this).parent().parent().find(".item_quantity");
        let item_total_amount = $(this).parent().parent().find(".item_total_amount");
    
        if(parseFloat(itemQuantity.text()) !== 5){
            itemQuantity.html(parseFloat(itemQuantity.text()) + 1);
            itemTotalAmount.html(parseFloat(itemTotalAmount.text()) + parseFloat(price));
            item_total_amount.val(parseFloat(itemTotalAmount.text()));
            itemTotalAmount.append(" EGP");
            orderTotalAmount.html(parseFloat(orderTotalAmount.text()) + parseFloat(price));
            totalAmount.val(parseFloat(orderTotalAmount.text()));
            item_quantity.val(parseFloat(itemQuantity.text()));
    
        }
        
    });
    
    $(`#orderItem${i}`).find(".decItemQuantity").click( function () {
    let itemTotalAmount = $(this).parent().parent().find(".itemTotalAmount");
    let itemQuantity = $(this).parent().parent().find(".itemQuantity");
    let item_quantity = $(this).parent().parent().find(".item_quantity");
    
    if(parseFloat(itemQuantity.text()) !== 1){
        itemQuantity.html(parseFloat(itemQuantity.text()) - 1);
        itemTotalAmount.html(parseFloat(itemTotalAmount.text()) - parseFloat(price));
        item_total_amount.val(parseFloat(itemTotalAmount.text()));
        itemTotalAmount.append(" EGP");
        orderTotalAmount.html(parseFloat(orderTotalAmount.text()) - parseFloat(price));
        totalAmount.val(parseFloat(orderTotalAmount.text()));
        item_quantity.val(parseFloat(itemQuantity.text()));
    
    }  
    });
    
    // When Remove ordered Item
    $(`#orderItem${i}`).find(".removeItem").click( function () {
        let itemTotalAmount = $(this).parent().parent().find(".itemTotalAmount");
        itemCount.val(--count);
        orderTotalAmount.html(parseFloat(orderTotalAmount.text()) - parseFloat(itemTotalAmount.text()));
        totalAmount.val(parseFloat(orderTotalAmount.text()));
        console.log(parseFloat(orderTotalAmount.html()));
        $(this).parent().parent().remove();
        orderButton.css('pointer-events','all');
        orderButton.css('opacity','1');
    });
    
    });
    });