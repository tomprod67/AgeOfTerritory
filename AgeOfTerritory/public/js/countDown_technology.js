document.addEventListener('DOMContentLoaded', function() {

    if (document.querySelector('#countDownTechnology')) {

        var countDownTechnology = document.querySelector('#countDownTechnology');
        var countDownDateTechnology = countDownTechnology.dataset.countDownDateTechnology;
        var redirectCompleted = countDownTechnology.dataset.redirectCompleted;
        var redirectCancelled = countDownTechnology.dataset.redirectCancelled;

        countDownDateTechnology *= 1000;

        // On creer l'interval d'une seconde
        var x = setInterval(function () {

            // now = represente le timestamp du moment actuel
            var now = new Date().getTime();

            // countDownDate = la endDate en timestamp
            // time = L'écart entre countDownDate et now
            var time = countDownDateTechnology - now;

            if (time < 0) {
                clearInterval(x);
                window.location.href = redirectCompleted;
               /* $.get(
                    redirectCompleted,
                    {},
                    function(data){
                        $("#technology"+data.id).html(data.view)
                    }
                );
                $('.actionTech').show();*/

            }
            else {
                $('.actionTech').hide();
                // Calcul du temps
                var days = Math.floor(time / (1000 * 60 * 60 * 24));
                var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((time % (1000 * 60)) / 1000);


                if (days === 0) {
                    $("#countDownTechnology").html(hours + "h " + minutes + "m " + seconds + "s <br/><a href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la recherche en cours ? ? Vous ne recuperez que 50% du prix de la recherche si vous decider de terminer la recherche maintenant.`);'>interrompre</a>");
                }

                if (hours === 0 && days === 0) {
                    $("#countDownTechnology").html(minutes + "m " + seconds + "s <br/><a href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la recherche en cours ? ? Vous ne recuperez que 50% du prix de la recherche si vous decider de terminer la recherche maintenant.`);'>interrompre</a>");
                }

                if (minutes === 0 && hours === 0 && days === 0) {
                    $("#countDownTechnology").html(seconds + "s <br/><a href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la recherche en cours ? ? Vous ne recuperez que 50% du prix de la recherche si vous decider de terminer la recherche maintenant.`);'>interrompre</a>");
                }

                if (minutes > 0 && hours > 0 && days > 0) {
                    $("#countDownTechnology").html(days + "d " + hours + "h " + minutes + "m " + seconds + "s <br/><a href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la recherche en cours ? Vous ne recuperez que 50% du prix de la recherche si vous decider de terminer la recherche maintenant.`);'>interrompre</a>");
                }
            }
        }, 1000);
    }
});