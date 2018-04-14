
var mathHelper = {
  calculateTotal:function(){
      var total = 0;

      $('input.price').each(
          function (index, elem) {
              var price = $(elem).val();
              if ($.isNumeric(price)) {
                  total += parseInt(price);
              }
          }
      );
      $('.total').val(total);

      return total;
  },
  formatNumber:function(num){
      if(num.length == 1){
          return "0" + num;
      }
      return num;
  }
};

$('.tickets').on('change', '.myBirth', function (e) {

    var parent = $(e.target).closest(".form-inline");
    var idParent = "#" + $(parent).attr("id");
    var inputDayValue = $(idParent + "_day").val();
    var inputMonthValue = $(idParent + "_month").val();
    var inputYearValue = $(idParent + "_year").val();
    var myInput = $(e.target).closest(".myTicket").find("input.price").eq(0);

    var date = mathHelper.formatNumber(inputDayValue) + "-"
        + mathHelper.formatNumber(inputMonthValue)  + "-" + inputYearValue;

    var url = 'http://localhost:8888/Appli-Louvre/web/app_dev.php/louvre_booking/update';
    $.post(url, {birthDay: date},
        function (data) {
            $(myInput).val(data);
            mathHelper.calculateTotal();
        })
        .fail('zut');

});



















































