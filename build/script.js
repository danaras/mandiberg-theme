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

// MENU: 

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



// LIGHT BOX

  var lighbox = function(){
      $(".post-content").find("img").click(function(){
      
        var imgURL = $(this).attr("src")
        var imgWidth = $(this).width()

         $(".displayed-image").attr("src", imgURL)
         $(".displayed-image").css({"width" : imgWidth + "px"})

        $(".lightbox-frame").fadeIn("fast", function(){

          var bodyTop = $("body").scrollTop()

          //disable scrolling of body at current position
          $('body').css({
              overflow: 'hidden',
              height: '100%'
          })

        })

       

        /*

        <div class="lightbox-frame">
          <div class="lightbox-background">
            <img class="displayed-image" src="' + imgURL + '">
          </div>
        </div>

        */


      })

      $(".lightbox-background").click(function(){
        $(".lightbox-frame").fadeOut("fast", function(){
          
            // enable scrolling of body again:
          $('body').css({
              overflow: 'auto',
              height: 'auto'
          })
        })
      })

  }



  lighbox();





//BARBA js function (for smooth page transitions)

  var HideShowTransition = Barba.BaseTransition.extend({
    start: function() {
      this.newContainerLoading.then(this.finish.bind(this));
    },

    finish: function() {
      document.body.scrollTop = 0;
      this.done();
      lighbox();
    }
  });

  Barba.Pjax.getTransition = function() {
    return HideShowTransition;
  };



	
})( jQuery )


