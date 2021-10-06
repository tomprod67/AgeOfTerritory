$(document).ready(function(){

        if (document.querySelector('#countDownBuilding')) {
            var countDownBuilding = document.querySelector('#countDownBuilding');
            var countDownDateBuilding = countDownBuilding.dataset.countDownDateBuilding;
            var redirectCompleted = countDownBuilding.dataset.redirectCompleted;
            var redirectCancelled = countDownBuilding.dataset.redirectCancelled;


            countDownDateBuilding *= 1000;

            // On creer l'interval d'une seconde
            var x = setInterval(function () {


                // now = represente le timestamp du moment actuel
                var now = new Date().getTime();

                // countDownDate = la endDate en timestamp
                // time = L'écart entre countDownDate et now
                var time = countDownDateBuilding - now;

                if (time < 0) {
                    clearInterval(x);
                    window.location.href = redirectCompleted;
                }
                else {
                    $('.actionBuild').hide();
                    // Calcul du temps
                    var days = Math.floor(time / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((time % (1000 * 60)) / 1000);


                    if (days === 0) {
                        $("#countDownBuilding").html(hours + "h " + minutes + "m " + seconds + "s <br/><a class='jslink' href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la construction de ce batiment ? Vous ne recuperez que 50% du prix batiment si vous decider de terminer la construction maintenant.`);'>interrompre</a>");
                    }

                    if (hours === 0 && days === 0) {
                        $("#countDownBuilding").html(minutes + "m " + seconds + "s <br/><a class='jslink' href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la construction de ce batiment ? Vous ne recuperez que 50% du prix batiment si vous decider de terminer la construction maintenant.`);'>interrompre</a>");
                    }

                    if (minutes === 0 && hours === 0 && days === 0) {
                        $("#countDownBuilding").html(seconds + "s <br/><a class='jslink' href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la construction de ce batiment ? Vous ne recuperez que 50% du prix batiment si vous decider de terminer la construction maintenant.`);'>interrompre</a>");
                    }

                    if (minutes > 0 && hours > 0 && days > 0) {
                        $("#countDownBuilding").html(days + "d " + hours + "h " + minutes + "m " + seconds + "s <br/><a class='jslink' href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la construction de ce batiment ? Vous ne recuperez que 50% du prix batiment si vous decider de terminer la construction maintenant.`);'>interrompre</a>");
                    }
                }
            }, 1000);
        }
});
