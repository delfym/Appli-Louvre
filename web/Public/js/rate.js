var birthDay;
var birthDate;

  $('.myBirth select').change(function (e) {
    var test = $(this).val();
    var test2 = $('.myBirth select:nth-child(1)').val();
    var test3 = $('.myBirth select:nth-child(2)').val();
    var test4 = $('.myBirth select:nth-child(3)').val();
    if(test2 <= 9)
    {
      test2 = '0'+test2;
    }
    if(test3 <= 9)
    {
        test3 = '0' + test3;
    }
    birthDate = test2 + '-' + test3 +'-' + test4;

      console.log('je suis dans un select ' + test);
      console.log('je suis dans un select ' + test2 + ' ' +test3 + ' ' + test4);
      console.log(birthDate);


// ************* req AJAX ********************************

        var url = 'http://localhost:8888/Appli-Louvre/web/app_dev.php/louvre_booking/update';
        $.post(url, {birthDay : birthDate},
            function (data) {
                $('input.price')
                    .val(data);
            })
            .fail('zut');

  });
