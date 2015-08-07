/**
 * Website utils
 */

$(document).ready(function() {
  // NProgress bar
  NProgress.start();
  var interval = setInterval(function() { NProgress.inc(); }, 1000);
  $(window).load(function () {
    clearInterval(interval);
    NProgress.done();
  });
  $(window).unload(function () {
    NProgress.start();
  });

  // Enable bootstrap tooltips and popover
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
  });

  // Add spinner on submit
  $('form.spinner').each(function() {
    var $submitButton = $(this).find('[type=submit]');
    $(this).on('submit',function(e) {
      $submitButton.addClass('disabled');
      var $faIcon = $submitButton.find('i');
      $faIcon.removeClass().addClass('fa fa-spinner fa-fw fa-spin');
    });
  });

  // Enable homepage carousel
  $('#homepage-carousel').owlCarousel({
    autoHeight: false,
    loop: true,
    items: 1,
    margin: 10,
    lazyLoad: true,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true
  });

  // Enable article carousel
  $('#article-carousel').owlCarousel({
    autoHeight: false,
    loop: true,
    items: 1,
    margin: 10,
    lazyLoad: true,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true
  });

  $('.notify-by-mail').each(function() {
    var $input = $(this).find('input');
    var $success = $(this).find('.success');
    var $failure = $(this).find('.failure');

    $input.on('change', function(e) {
      e.preventDefault();

      $.ajax({
        url: Routing.generate('app_homepage_notifybymail'),
        type: 'PUT',
        beforeSend: function() {
          $input.attr('disabled','disabled');
          $success.hide();
          $failure.hide();
        },
        success: function() {
          $success.show();
          $failure.hide();
        },
        error: function() {
          $success.hide();
          $failure.show();
          if (typeof $input.attr('checked') == 'undefined') {
            $input.removeAttr('checked');
          } else {
            $input.attr('checked', 'checked');
          }
        },
        complete: function() {
          $input.removeAttr('disabled');
        }
      });
    })
  });
});

// Remove comment
(function ($) {
  $.fn.extend({
    removeComment: function () {
      var commentId = $(this).data('comment-id');
      var $button = $(this);
      var $comment = $('#comment-' + commentId);

      $.ajax({
        url: Routing.generate('app_comment_remove', {id: commentId}),
        type: 'DELETE',
        beforeSend: function () {
          $button.attr('disabled', 'disabled');
        },
        success: function () {
          $comment.slideUp();
        },
        error: function () {
          $button.removeAttr('disabled');
        }
      });
    }
  });
})(jQuery);

// Disable 300ms delay on mobile devices
$(function() {
  FastClick.attach(document.body);
});
