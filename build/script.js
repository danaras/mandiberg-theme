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
 * - MENU
 * - LIGHT BOX
 * - BARBA
 * - READ MORE
 * - HOMEPAGE CARD HEIGHT

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

  } // end of light box function

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



// FOR READ MORE

if ($('div').hasClass("post-content") && $(".post-content").children("p").length > 4) {

 $(".post-content > p:nth-of-type(3)").after("<div class='readmore'><div><span>READ MORE</span></div></div>")
 $(".post-content > div.readmore ~ *").wrapAll("<span class='long-read'></span>")

 $(".readmore").click(function(){
  $(".readmore").fadeOut(200, function(){
    $(".long-read").fadeIn(500)
    $(".long-read").css({"margin-top": '0px', 'transform' : 'translateY(0px)'})
  })
 })

} // end of readmore function



// FOR HOMEPAGE PROJECT CARD HEIGHT (for when titles become two lines)

if ($('.barba-container').attr("data-namespace") === "homepage") {


  var resizeTitle = function(){
    var cardTitles = $(".col-md-4 > a > h1"),
    cardTitleHeight = 0,
    cardTitleLength = 0, 
    cardTitleNumber = 0;
   
    for (var i = 0; i < cardTitles.length; i++) {   

      if (cardTitles[i].innerHTML.length > cardTitleLength) {
         cardTitleNumber = i
         cardTitleLength = cardTitles[i].innerHTML.length // get title with longest name
         cardTitleHeight = cardTitles[i].offsetHeight // get current height
      }
     
    } // end of first foreach

    console.log(cardTitleNumber, cardTitleLength, cardTitleHeight)

    for (var value = 0; value < cardTitles.length; value++) {
      
      if( value !== cardTitleNumber){
      cardTitles[value].style.height =  cardTitleHeight + "px"

      } 


    } // end of second foreach

  } // end of function


  resizeTitle() // on load


  $(window).resize(function(){
    resizeTitle()
  })


} // end of hompage project card conditional



	
})( jQuery )


