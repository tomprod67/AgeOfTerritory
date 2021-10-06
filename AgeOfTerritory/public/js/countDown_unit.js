document.addEventListener('DOMContentLoaded', function() {

    /*const url = new URL('http://localhost:3000/hub');

    url.searchParams.append('topic', 'http://localhost:8000/game/building');

    const eventSource = new EventSource(url);

    console.log(eventSource);*/


    if (document.querySelector('#countDownUnit')) {
        var countDownUnit = document.querySelector('#countDownUnit');
        var countDownDateUnit = countDownUnit.dataset.countDownDateUnit;
        var redirectCompleted = countDownUnit.dataset.redirectCompleted;
        var redirectCancelled = countDownUnit.dataset.redirectCancelled;



        countDownDateUnit *= 1000;

        // On creer l'interval d'une seconde
        var x = setInterval(function () {


            // now = represente le timestamp du moment actuel
            var now = new Date().getTime();

            // countDownDate = la endDate en timestamp
            // time = L'écart entre countDownDate et now
            var time = countDownDateUnit - now;

            if (time < 0) {
                clearInterval(x);
                window.location.href = redirectCompleted;

            }
            else {

                // Calcul du temps
                var days = Math.floor(time / (1000 * 60 * 60 * 24));
                var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((time % (1000 * 60)) / 1000);


                if (days === 0) {
                    $("#time").html(hours + "h " + minutes + "m " + seconds + "s ");
                    $("#actionInTrain").html("<a href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la construction de ces défense ? Vous ne recuperez que 50% du prix des unités si vous decider de terminer la construction maintenant.`);'>interrompre</a>");
                }

                if (hours === 0 && days === 0) {
                    $("#time").html(minutes + "m " + seconds + "s ");
                    $("#actionInTrain").html("<a href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la construction de ces défense ? Vous ne recuperez que 50% du prix des unités si vous decider de terminer la construction maintenant.`);'>interrompre</a>");
                }

                if (minutes === 0 && hours === 0 && days === 0) {
                    $("#time").html(seconds + "s ");
                    $("#actionInTrain").html("<a href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la construction de ces défense ? Vous ne recuperez que 50% du prix des unités si vous decider de terminer la construction maintenant.`);'>interrompre</a>");
                }

                if (minutes > 0 && hours > 0 && days > 0) {
                    $("#time").html(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
                    $("#actionInTrain").html("<a href='" + redirectCancelled + "' onclick='return confirm(`Etes-vous sur de vouloir annuler la construction de ces défense ? Vous ne recuperez que 50% du prix des unités si vous decider de terminer la construction maintenant.`);'>interrompre</a>");
                }

            }
        }, 1000);
    }
    else{
        $("#unitInBuild").hide();
    }

});