/*
Part of the WordPress plugin Tag Groups
Plugin URI: https://chattymango.com/tag-groups/
Author: Christoph Amthor
License: GNU GENERAL PUBLIC LICENSE, Version 3
Last modified: 20190510
*/

/*
* Makes the actual Ajax request and populates the table, the pager and the message box
*/
function tg_do_ajax(tg_params, send_data, labels) {

  var nonce = jQuery('#tg_nonce').val();
  var data = {
    action: 'tg_ajax_manage_groups',
    nonce: nonce,
  };
  jQuery.extend(send_data, data);

  send_data.start_position = jQuery('#tg_start_position').val();

  var message_output = '';

  /*
  * Send request and parse response
  */
  jQuery.ajax({
    url: tg_params.ajaxurl,
    data: send_data,
    dataType: 'xml',
    method: 'post',
    success: function (data) {
      var status = jQuery(data).find('response_data').text();
      var message = jQuery(data).find('supplemental message').text();
      var nonce = jQuery(data).find('supplemental nonce').text();
      var task = jQuery(data).find('supplemental task').text();
      // write new nonce
      if (nonce !== '') {
        jQuery('#tg_nonce').val(nonce);
      }
      if (status === 'success') {
        var groups = JSON.parse(jQuery(data).find('groups').text());
        var start_position = jQuery(data).find('start_position').text();
        if (start_position !== '') {
          jQuery('#tg_start_position').val(start_position);
        } else {
          start_position = send_data.start_position;
        }
        var end_position = jQuery(data).find('end_position').text();
        var max_number = jQuery(data).find('max_number').text();

        var output = '';
        var position = start_position;
        if (max_number > 0) {
          for (var key in groups) {
            var data_set = groups[key];
            if (data_set.id!=null) {
              output += '<tr class="tg_sort_tr" data-position="' + position + '">\n';
              output += '<td>' + data_set.id + '</td>\n';
              output += '<td><span class="tg_edit_label tg_text" data-position="' + position + '" data-label="' + escape_html(data_set.label) + '">' + escape_html(data_set.label) + '\<span class="dashicons dashicons-edit tg_pointer" style="display:none;"></span></span></td>\n';
              output += '<td class="tg_hide_when_drag"><div class="tg_term_amounts">';
              if (tg_params.tagsurl!=='') {
                output += '<a href="' + tg_params.tagsurl + '&term-filter=' + data_set.id + '" title="' + labels.tooltip_showtags + '">' + data_set.amount + '</a>';
              } else {
                output += data_set.amount + '</span>';
              }
              output += '</div>';
              output += '</td>\n<td class="tg_hide_when_drag">';
              if (tg_params.tagsurl!=='') {
                output += '<a href="' + tg_params.tagsurl + '&term-filter=' + data_set.id + '" title="' + labels.tooltip_showtags + '"><span class="tg_pointer dashicons dashicons-tag"></span></a> ';
              }
              if (tg_params.postsurl!=='') {
                output += '<a href="' + tg_params.postsurl + '&post_status=all&tg_filter_posts_value=' + data_set.id + '" title="' + labels.tooltip_showposts + '"><span class="tg_pointer dashicons dashicons-admin-page"></span></a>';
              }
              output += '</td>\n<td class="tg_hide_when_drag">';
              output += '<span class="tg_delete tg_pointer dashicons dashicons-trash" data-position="' + position + '" title="' + labels.tooltip_delete + '"></span>';
              output += '<span class="tg_pointer dashicons dashicons-plus-alt" title="' + labels.tooltip_newbelow + '" onclick="tg_toggle_clear(' + position + ')" style="margin-left:5px;"></span>';
              output += '</td>\n';
              output += '<td class="tg_hide_when_drag">';

              output += '<div style="overflow:hidden; position:relative; height:20px; clear:both;">';
              if (position > 1) {
                output += '<span class="tg_up tg_pointer dashicons dashicons-arrow-up" data-position="' + position + '" title="' + labels.tooltip_move_up + '""></span>';
              }
              output += '</div>';

              output += '<div style="overflow:hidden; position:relative; height:20px; clear:both;">';
              if (position < max_number) {
                output += '<span class="tg_down tg_pointer dashicons dashicons-arrow-down" data-position="' + position + '" title="' + labels.tooltip_move_down + '"></span>';
              }
              output += '</div>';

              output += '</td>\n';
              output += '</tr>\n';

              // hidden row for adding a new group
              output += '<tr style="display:none; height:45px; background-color:#FFC;" id="tg_new_' + position + '">\n';
              output += '<td style="display:none;">' + labels.newgroup + '</td>\n';
              output += '<td colspan="4" style="display:none;"><input data-position="' + position + '"  placeholder="' + labels.placeholder_new + '">';
              output += '<span class="tg_new_yes dashicons dashicons-yes tg_pointer" data-position="' + position + '"></span> <span class="tg_new_no dashicons dashicons-no-alt tg_pointer" data-position="' + position + '" onclick="tg_toggle_clear(' + position + ')"></span>';
              output += '</td>\n';
              output += '</tr>\n';
              position++;
            }
          }
        } else {
          // no tag groups yet
          output += '<tr id="tg_new_1">\n';
          output += '<td ></td>\n';
          output += '<td colspan="4"><input data-position="0" placeholder="' + labels.newgroup + '">';
          output += '<span class="tg_new_yes dashicons dashicons-yes tg_pointer" data-id="1"></span></span>';
          output += '</td>\n';
          output += '</tr>\n';
        }

        // write table of groups
        if (task == 'move') {
          jQuery('#tg_groups_container').html(output);
        } else {
          jQuery('#tg_groups_container').fadeOut(300, function () {
            jQuery(this).html(output)
            .fadeIn(300);
          });
        }

        // pager
        var pager_output = '';
        var page, current_page;
        var items_per_page = Number(tg_params.items_per_page);
        if (items_per_page < 1) {
          items_per_page = 1;
        }
        current_page = Math.floor(start_position / items_per_page) + 1;
        max_page = Math.floor((max_number - 1) / items_per_page) + 1;

        if (current_page > 1) {
          pager_output += '<button class="button-secondary tg_pager_button" data-page="' + (current_page - 1) + '"><span class="dashicons dashicons-arrow-left-alt2"></span></button>';
        } else {
          pager_output += '<button class="button-secondary tg_pager_button" disabled><span class="dashicons dashicons-arrow-left-alt2"></span></button>';
        }

        for (i = 1; i <= max_number; i += items_per_page) {
          page = Math.floor(i / items_per_page) + 1;
          if (page == current_page) {
            pager_output += '<button class="tg_reload_button tg_pointer button-secondary" id="tg_groups_reload" title="' + labels.tooltip_reload + '"><span class="dashicons dashicons-update"></span></button>';

          } else {
            pager_output += '<button class="button-secondary tg_pager_button" data-page="' + page + '"><span>' + page + '</span></button>';
          }
        }

        if (current_page < max_page) {
          pager_output += '<button class="button-secondary tg_pager_button" data-page="' + (current_page + 1) + '"><span class="dashicons dashicons-arrow-right-alt2"></span></button>';
        } else {
          pager_output += '<button class="button-secondary tg_pager_button" disabled><span class="dashicons dashicons-arrow-right-alt2"></span></button>';
        }

        jQuery('#tg_pager_container').fadeOut(200, function () {
          jQuery(this).html(pager_output)
          .fadeIn(400, function () {
            jQuery('#tg_pager_container_adjuster').css({
              height: Number(jQuery('#tg_pager_container').height()) + 10
            });
          });
        });

        if (message != '') {
          message_output += '<div class="notice notice-success"><p>' + message + '</p></div><br clear="all" />';
        } else {
          message_output += '<div><p>&nbsp;</p></div><br clear="all" />';
        }
        jQuery('#tg_message_container').fadeTo(500, 0, function () {
          jQuery(this).html(message_output)
          .fadeTo(800, 1);
        });

      } else {
        if (message == '') {
          message = 'Error loading data.';
          console.log(data);
        }
        message_output += '<div class="notice notice-error"><p>' + message + '</p></div><br clear="all" />';

        jQuery('#tg_message_container').fadeTo(500, 0, function () {
          jQuery(this).html(message_output)
          .fadeTo(800, 1);
        });

      }
    },
    error: function(xhr, textStatus, errorThrown) {
      console.log('[Tag Groups] error: ' + xhr.responseText);
    }
  });
}

/*
* Turn an editable label field back into normal text
*/
function tg_close_textfield(element, saved)
{
  var position = element.children(':first').attr('data-position');
  var label;
  if (saved) {
    label = escape_html(element.children(':first').attr('value'));
  } else {
    label = escape_html(element.children(':first').attr('data-label'));
  }
  element.replaceWith('<span class="tg_edit_label tg_text" data-position="' + position + '" data-label="' + label + '">' + label + ' <span class="dashicons dashicons-edit tg_pointer" style="display:none;"></span></span>');

}

/*
* Toggling the "new group" boxes
*/
function tg_toggle_clear(position)
{
  var row = jQuery('#tg_new_' + position);
  if (row.is(':visible')) {
    jQuery('[data-position=' + position + ']').val('');
    row.children().fadeOut(300, function () {
      row.slideUp(600);
    });

  } else {
    jQuery('[id^="tg_new_"]:visible').children().fadeOut(300, function () {
      jQuery('[id^="tg_new_"]:visible').slideUp(400);
    });
    row.delay(500).slideDown(400, function () {
      row.children().fadeIn(300);
      jQuery('[data-position=' + position + ']').focus();
    });

  }
}

/*
* Parse all editable label fields in order to turn them into normal text
*/
function tg_close_all_textfields()
{
  jQuery('.tg_edit_label_active').each(function () {
    tg_close_textfield(jQuery(this), false);
  });
}

/*
* Prevent HTML from breaking
*/
function escape_html(text) {
  return text
  .replace(/&/g, '&amp;')
  .replace(/</g, '&lt;')
  .replace(/>/g, '&gt;')
  .replace(/"/g, '&quot;')
  .replace(/'/g, '&#039;');
}
