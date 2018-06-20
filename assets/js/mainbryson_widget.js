jQuery(function ($) {
  'use strict';
  $('.bryson_ads > .mb_banner.mb_attr_half').each(function( index, col ){
    if ( index % 2 == 0 ) {
      $(col).addClass('even');
    }else{
      $(col).addClass('odd');
    }
  });
});