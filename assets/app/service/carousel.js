app.carousel = function (carousel) {
    carousel.carousel().on("touchstart", function(event){
        var xClick = event.originalEvent.touches[0].pageX;
        carousel.one("touchmove", function(event){
            var xMove = event.originalEvent.touches[0].pageX;
            if( Math.floor(xClick - xMove) > 5 ){
                carousel.carousel('next');
            }
            else if( Math.floor(xClick - xMove) < -5 ){
                carousel.carousel('prev');
            }
        }).on("touchend", function(){
            carousel.off("touchmove");
        });
    });
};