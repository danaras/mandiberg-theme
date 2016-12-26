/*
Theme Name: Mandiberg
Description: Mandiberg JS
Author: Lukas Eigler-Harding
Author URI: http://lukaslukas.com/
Description: Site for artist/teacher/writer/etc Michael Mandiberg. Design & Build by Lukas Eigler-Harding
Version: 1.0
*/


/**
 * Table of Contents:
 *

 */

// function allows for $ to be used like i would in standard jquery:
(function($) {

$(".category.notactive").each(function(){

  if($(this).siblings(".subcategories").children(".subcategory.sub-active").length){

    $(this).siblings(".subcategories").css({"display" : "inline"})
    $(this).css({"font-style" : "italic"})

  } else{
    $(this).siblings(".subcategories").css({"display" : "none"})
     
  }

})


//$(".subcategory.sub-active")

  var content = $(".subcategory.sub-active").html()
  $('.subcategory.sub-active').html("→" + content)

  $('.subcategories').prepend($(".subcategory.sub-active"))




//barba js function (for smooth page transitions)

var HideShowTransition = Barba.BaseTransition.extend({
  start: function() {
    this.newContainerLoading.then(this.finish.bind(this));
  },

  finish: function() {
    document.body.scrollTop = 0;
    this.done();

  }
});





Barba.Pjax.getTransition = function() {
  return HideShowTransition;
};



	
})( jQuery )


