if (Drupal.jsEnabled) {
  $(document).ready(function() {
    $('#node-form').attr('action', location.href);
    $('.drupal-tabs').find('ul.anchors').find('a').click( function() {
      var hrefExt = $(this).attr('href');
      var form = $('#node-form');
      var formAction = form.attr('action');
      var index = formAction.indexOf('#');
      if (index > 0) {
        formAction = formAction.substr(0,index) + hrefExt;
      } else {
        formAction = formAction + hrefExt;
      }
      form.attr('action', formAction);
    });
    $('#edit-save, #edit-delete, #edit-cancel').click( function() {
      cleanFormAction();
    });
    $('#edit-save-top, #edit-delete-top, #edit-cancel-top').click( function() {
      cleanFormAction();
    });
    $('#edit-partial-save-template, #edit-partial-save-css, #edit-partial-save-php, #edit-partial-save-js').click( function() {
      return confirm('Are you sure you want to save this to a file? If file exists it will be overwritten.');
    });
    $('#edit-partial-load-template, #edit-partial-load-css, #edit-partial-load-php, #edit-partial-load-js').click( function() {
      return confirm('Are you sure you want to load from a file?');
    });
  });
}

function cleanFormAction() {
  var form = $('#node-form');
  var formAction = form.attr('action');
  var index = formAction.indexOf('#');
  if (index > 0) {
    formAction = formAction.substr(0,index);
  } else {
    formAction = formAction;
  }
  form.attr('action', formAction);
}