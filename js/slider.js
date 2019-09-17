/*Slider basso di pagina prodotto*/

function jssor_1_slider_init(){
			var w=document.documentElement.clientWidth || document.body.clientWidth;
			if (w<700) {
				document.getElementById("jssor_1").classList.toggle("Smartphone");
				document.getElementById("altezza").classList.toggle("Smartphone");
			}
            var jssor_1_options = {
              $AutoPlay: 0,
              $AutoPlaySteps: 5,
              $SlideDuration: 160,
              $SlideEasing: $Jease$.$Linear,
              $Loop: 2,
              $SlideWidth: 249,
              $SlideSpacing: 10,
              $Align: 0,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $Steps: 2
              }
            };
			
			var w = document.documentElement.clientWidth || document.body.clientWidth;
            if(w<700){
                jssor_1_options.$SlideWidth= 505;
            }

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 4000; //1023

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };