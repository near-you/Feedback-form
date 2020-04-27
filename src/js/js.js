// Код для Input file
$('.my').change(function() {
  if ($(this).val() != '') $('.amount').text('Вибрано файлів: ' + $(this)[0].files.length);
  else $('.amount').text('Виберіть файли');
});

// Для анімації label у input
$(".form-input, .form-text").focus(function() {
  $(this).siblings('label').addClass('active');
});
$(".form-input, .form-text").focusout(function() {
  if ($(this).val() != false) {
    $(this).siblings('label').addClass('active');
  } else {
    $(this).siblings('label').removeClass('active');
  }
});

// Анімація повідомлення про результи
var showmsg = new TimelineMax();
showmsg.add(TweenMax.to(".msg", 0.7, {opacity: 1,y: -40,ease: Expo.easeOut}));
showmsg.add(TweenMax.to(".msg", 0.7, {opacity: 0,y: 0,ease: Expo.easeOut,delay: 2}));
showmsg.pause();

// Анімація плашки слова "зачекайте"
var loadanim = TweenLite.to(".loading", 1, {autoAlpha: 0.8});
loadanim.pause();

// Відправка даних на сервер
$('#form').trigger('reset');
$(function() {
  'use strict';
  $('#form').on('submit', function(e) {
    $('.msg').removeClass('error success');
    $('input').removeClass('inputerror');
    loadanim.play();
    e.preventDefault();
    $.ajax({
      url: 'send.php',
      type: 'POST',
      contentType: false,
      processData: false,
      data: new FormData(this),
      success: function(msg) {
        console.log(msg);
        if (msg == 'ok') {
          $('#form').trigger('reset');
          $('.amount').text('Виберіть файли');
          $('label').removeClass('active');
          $('.msg').text('Повідомлення успішно надіслано').addClass('success');
          showmsg.restart();loadanim.duration(0.3).reverse();
        } else {
          if (msg == 'mailerror') {
            $("#email").addClass('inputerror');
          }
          $('.msg').text('Помилка. Повідомлення не надіслано').addClass('error');
          showmsg.restart();loadanim.duration(0.3).reverse();
        }
      }
    });
  });
});

  //phone_mask
  $("input[name=phone]").mask("+38 (999) 999-99-99");